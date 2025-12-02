<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\JobVacancy;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index()
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

        // analytics
        $analytics = [
            'activeUsers' => $activeUsers,
            'totalJobs' => $totalJobs,
            'totalApplications' => $totalApplications
        ];

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

        return view('dashboard.index', compact(['analytics', 'mostAppliedJobs', 'jobConversionRates']));
    }
}
