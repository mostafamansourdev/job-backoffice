<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyCreateRequest;
use App\Http\Requests\CompanyUpdateRequest;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;



class CompanyController extends Controller
{
    public $industries = ['Technology', 'Finance', 'Healthcare', 'Education',  'Manufacturing', 'Retail', 'Other'];

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Active
        $query = Company::latest();

        // Archived
        if ($request->input('archive') == 'true') {
            $query->onlyTrashed();
        }

        $companies = $query->paginate(10)->onEachSide(1);

        return view('company.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $industries = $this->industries;
        return view('company.create', compact('industries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CompanyCreateRequest $request)
    {

        $validated = $request->validated();

        //create owner
        $owner = User::create([
            'name' => $request->input('owner_name'),
            'email' => $request->input('owner_email'),
            'password' => Hash::make($request->input('owner_password')),
            "role" => "company-owner",
        ]);

        //  return error response if owner creation failed
        if (!$owner) {
            return redirect()->back()->withInput()->withErrors(['owner_creation' => 'Failed to create company owner. Please try again.']);
        }

        Company::create([
            'name' => $validated['name'],
            'address' => $validated['address'],
            'industry' => $validated['industry'],
            'website' => $validated['website'] ?? null,
            'ownerId' => $owner->id,
        ]);

        return redirect()->route('companies.index')->with('success', 'Job category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $company = Company::findOrFail($id);
        return view('company.show', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $industries = $this->industries;
        $company = Company::findOrFail($id);

        return view('company.edit', compact('company', 'industries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CompanyUpdateRequest $request, string $id)
    {
        $validated = $request->validated();
        $company = Company::findOrFail($id);

        $company->update([
            'name' => $validated['name'],
            'address' => $validated['address'],
            'industry' => $validated['industry'],
            'website' => $validated['website'] ?? null
        ]);

        // update owner details
        $ownerData = [];
        if (isset($validated['owner_name'])) {
            $ownerData['name'] = $validated['owner_name'];
        }
        if (isset($validated['owner_password'])) {
            $ownerData['password'] = Hash::make($validated['owner_password']);
        }
        $company->owner->update($ownerData);

        // the 'redirectToList' query is used to determine whether to redirect to the company list or stay on the company details page
        // and it is passed as a query parameter from the edit form taken from the show page (companies.show) not the list page (companies.index)
        // but if not present, default to redirecting to the list
        if ($request->query('redirectToList') === 'false') {
            return redirect()->route('companies.show', compact('company'))->with('success', 'Company updated successfully.');
        }

        return redirect()->route('companies.index')->with('success', 'Company updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $company = Company::findOrFail($id);
        $company->delete();
        return redirect()->route('companies.index')->with('success', "\"" . $company->name . "\"" . ' Company is archived successfully.');
    }

    // Restore archived category
    public function restore(string $id)
    {
        $company = Company::withTrashed()->findOrFail($id);
        $company->restore();
        return redirect()->route('companies.index', ['archive' => 'true'])->with('success', "\"" . $company->name . "\"" . ' restored successfully.');
    }
}
