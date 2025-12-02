<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobVacancyCreateRequest;
use App\Http\Requests\JobVacancyUpdateRequest;
use App\Models\Company;
use App\Models\JobCategory;
use App\Models\JobVacancy;
use Illuminate\Http\Request;

class JobVacancyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = JobVacancy::latest();

        // Archived
        if ($request->input('archive') == 'true') {
            $query->onlyTrashed();
        }

        $jobVacancies = $query->paginate(10)->onEachSide(1);

        return view('job-vacancy.index', compact('jobVacancies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jobCategories = JobCategory::all();
        $companies = Company::all();
        return view('job-vacancy.create', compact('jobCategories', 'companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JobVacancyCreateRequest $request)
    {
        $validated = $request->validated();
        JobVacancy::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'location' => $validated['location'],
            'salary' => $validated['salary'],
            'type' => $validated['type'],
            'jobCategoryId' => $validated['jobCategoryId'],
            'companyId' => $validated['companyId'],
        ]);

        return redirect()->route('job-vacancies.index')->with('success', 'Job vacancy created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $jobVacancy = JobVacancy::findOrFail($id);
        $company = Company::findOrFail($jobVacancy->companyId);
        $jobCategory = JobCategory::findOrFail($jobVacancy->jobCategoryId);

        // $jobVacancy = JobVacancy::with(['jobApplications.user', 'company', 'jobCategory'])->findOrFail($id);
        // $company = $jobVacancy->company;
        // $jobCategory = $jobVacancy->jobCategory;

        return view('job-vacancy.show', compact('jobVacancy', 'company', 'jobCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $jobVacancy = JobVacancy::findOrFail($id);
        $jobCategories = JobCategory::all();
        $companies = Company::all();
        return view('job-vacancy.edit', compact('jobVacancy', 'jobCategories', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobVacancyUpdateRequest $request, string $id)
    {
        $validated = $request->validated();
        $jobVacancy = JobVacancy::findOrFail($id);
        $jobVacancy->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'location' => $validated['location'],
            'salary' => $validated['salary'],
            'type' => $validated['type'],
            'jobCategoryId' => $validated['jobCategoryId'],
            'companyId' => $validated['companyId'],
        ]);

        // but if not present, default to redirecting to the list
        if ($request->query('redirectToList') === 'false') {
            return redirect()->route('job-vacancies.show', ['job_vacancy' => $jobVacancy, 'tap' => 'company'])->with('success', 'Company updated successfully.');
        }
        return redirect()->route('job-vacancies.index')->with('success', 'Job vacancy updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jobVacancy = JobVacancy::findOrFail($id);
        $jobVacancy->delete();
        return redirect()->route('job-vacancies.index')->with('success', 'Job vacancy deleted successfully.');
    }

    public function restore(string $id)
    {
        $jobVacancy = JobVacancy::withTrashed()->findOrFail($id);
        $jobVacancy->restore();
        return redirect()->route('job-vacancies.index')->with('success', 'Job vacancy restored successfully.');
    }
}
