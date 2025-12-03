<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\JobVacancy;
use App\Models\User;

class DashboardController extends Controller
{
    //
    public function index()
    {
        if (auth()->user()->role === 'admin') {
            $analytics = $this->adminDashboard();
        }

        if (auth()->user()->role === 'company-owner') {
            $analytics = $this->companyOwnerDashboard();
        }

        return view('dashboard.index', compact('analytics'));
    }

    private function adminDashboard()
    {
        // over view cards data
        // last 30 days active users
        $activeUsers = User::where('last_login_at', '>=', now()->subDay(30))
            ->where('role', 'job-seeker')
            ->count();

        // Total Jobs (not archived)
        $totalJobs = JobVacancy::whereNull('deleted_at')->count();

        // Total Applications (not archived)
        $totalApplications = JobApplication::whereNull('deleted_at')->count();
        // Most applied jobs
        $mostAppliedJobs = JobVacancy::withCount('jobApplications as totalCount')
            ->whereNull('deleted_at')
            ->orderByDesc('totalCount')
            ->take(5)
            ->get();

        // application Conversion rate
        $jobConversionRates = JobVacancy::withCount('jobApplications as totalCount')
            ->whereNull('deleted_at')
            ->having('totalCount', ">", 0)
            ->orderByDesc('totalCount')
            ->limit(5)
            ->get()
            ->map(function ($job) {
                if ($job->viewCount > $job->totalCount) {

                    $job->conversionRate = round(($job->totalCount / $job->viewCount) * 100, 2);
                } else {
                    $job->conversionRate = 0;
                }
                return $job;
            });

        // analytics
        $analytics = [
            'activeUsers' => $activeUsers,
            'totalJobs' => $totalJobs,
            'totalApplications' => $totalApplications,
            'mostAppliedJobs' => $mostAppliedJobs,
            'jobConversionRates' => $jobConversionRates
        ];

        return $analytics;
    }

    private function companyOwnerDashboard()
    {

        $company = auth()->user()->company;

        // filter active users by applying jobs to this company jobs
        $activeUsers = User::where('last_login_at', '>=', now()->subDay(30))
            ->where('role', 'job-seeker')
            ->whereHas('jobApplications', function ($query) use ($company) {
                $query->whereIn('jobVacancyId', $company->jobVacancies()->pluck('id'));
            })
            ->count();

        // Total Jobs (not archived) for this company
        $totalJobs = $company->jobVacancies()->whereNull('deleted_at')->count();

        // Total Applications (not archived) for this company
        $totalApplications = $company->jobVacancies()
            ->whereNull('deleted_at')
            ->withCount('jobApplications as totalCount')
            ->get()
            ->sum('totalCount');

        // Most applied jobs for this company
        $mostAppliedJobs = $company->jobVacancies()
            ->whereNull('deleted_at')
            ->withCount('jobApplications as totalCount')
            ->orderByDesc('totalCount')
            ->take(5)
            ->get();

        // application Conversion rate for this company
        $jobConversionRates = $company->jobVacancies()
            ->whereNull('deleted_at')
            ->withCount('jobApplications as totalCount')
            ->having('totalCount', ">", 0)
            ->orderByDesc('totalCount')
            ->limit(5)
            ->get()
            ->map(function ($job) {
                if ($job->viewCount > $job->totalCount) {

                    $job->conversionRate = round(($job->totalCount / $job->viewCount) * 100, 2);
                } else {
                    $job->conversionRate = 0;
                }
                return $job;
            });

        // analytics
        $analytics = [
            'activeUsers' =>  $activeUsers,
            'totalJobs' => $totalJobs,
            'totalApplications' => $totalApplications,
            'mostAppliedJobs' => $mostAppliedJobs,
            'jobConversionRates' => $jobConversionRates
        ];

        return $analytics;
    }
}
