<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobApplicationUpdateRequest;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = JobApplication::latest();
        // Archived
        if ($request->input('archive') == 'true') {
            $query->onlyTrashed();
        }

        $jobApplications = $query->paginate(6)->onEachSide(1);

        return view('job-application.index', compact('jobApplications'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $jobApplication = JobApplication::findOrFail($id);

        return view('job-application.show', compact('jobApplication'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $jobApplication = JobApplication::findOrFail($id);


        return view('job-application.edit', compact('jobApplication'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobApplicationUpdateRequest $request, string $id)
    {
        $jobApplication = JobApplication::findOrFail($id);
        // Validate and update logic here
        $jobApplication->update([
            'status' => $request->input('status')
        ]);

        if ($request->query('redirectToList') == 'false') {
            return redirect()->route('job-applications.show', $jobApplication->id)
                ->with('success', 'Job Application status updated successfully.');
        }
        return redirect()->route('job-applications.index')
            ->with('success', 'Job Application status updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jobApplication = JobApplication::findOrFail($id);
        $jobApplication->delete();

        return redirect()->route('job-applications.index')
            ->with('success', 'Job Application deleted successfully.');
    }
    /**
     * Restore the specified resource from storage.
     */
    public function restore(string $id)
    {
        $jobApplication = JobApplication::withTrashed()->findOrFail($id);
        $jobApplication->restore();
        return redirect()->route('job-applications.index', ['archive' => 'true'])
            ->with('success', 'Job Application restored successfully.');
    }
}
