<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobCategoryCreateRequest;
use App\Http\Requests\JobCategoryUpdateRequest;
use App\Models\JobCategory;
use Illuminate\Http\Request;

class JobCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Active
        $query = JobCategory::latest();

        // Archived
        if ($request->input('archive') == 'true') {
            $query->onlyTrashed();
        }

        $jobCategories = $query->paginate(10)->onEachSide(1);

        return view('job-category.index', compact('jobCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('job-category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JobCategoryCreateRequest $request)
    {
        //
        $validated = $request->validated();

        JobCategory::create([
            'name' => $validated['name'],
        ]);

        return redirect()->route('job-categories.index')->with('success', 'Job category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = JobCategory::findOrFail($id);
        return view('job-category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobCategoryUpdateRequest $request, string $id)
    {
        $validated = $request->validated();

        $category = JobCategory::findOrFail($id);
        $category->update([
            'name' => $validated['name'],
        ]);

        return redirect()->route('job-categories.index')->with('success', 'Job category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = JobCategory::findOrFail($id);
        $category->delete();
        return redirect()->route('job-categories.index')->with('success', "\"" . $category->name . "\"" . ' Job category archived successfully.');
    }

    // Restore archived category
    public function restore(string $id)
    {
        $category = JobCategory::withTrashed()->findOrFail($id);
        $category->restore();
        return redirect()->route('job-categories.index', ['archive' => 'true'])->with('success', "\"" . $category->name . "\"" . ' Job category restored successfully.');
    }
}
