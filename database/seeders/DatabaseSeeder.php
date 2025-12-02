<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\JobApplication;
use App\Models\JobCategory;
use App\Models\JobVacancy;
use App\Models\Resume;
use App\Models\User;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create root admin user seeder
        User::firstOrCreate([
            'email' => 'admin@admin.com'
        ], [
            'name' => 'Admin',
            'password' => bcrypt('12345678'), // Set a default password
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // seed job data from JSON file to test with
        $jobData = json_decode(file_get_contents(database_path('data/job_data.json')), true);
        $jobApplications = json_decode(file_get_contents(database_path('data/job_applications.json')), true);

        // create jobs categories from the data
        foreach ($jobData["jobCategories"] as $category) {
            // Logic to create job categories and associated jobs goes here
            JobCategory::firstOrCreate([
                'name' => $category
            ]);
        }

        // create companies from the data
        foreach ($jobData["companies"] as $company) {
            // create company owner user
            $companyOwner = User::firstOrCreate([
                'email' => fake()->unique()->safeEmail()
            ], [
                'name' => fake()->name(),
                'password' => bcrypt('12345678'), // Set a default password
                'role' => 'company-owner',
                'email_verified_at' => now(),
            ]);

            Company::firstOrCreate([
                'name' => $company['name']
            ], [
                'address' => $company['address'],
                'industry' => $company['industry'],
                'website' => $company['website'] ?? null,
                'ownerId' => $companyOwner->id
            ]);
        }

        // create job vacancies from the data
        foreach ($jobData["jobVacancies"] as $vacancy) {

            // gat the created company and job category
            $company = Company::where('name', $vacancy['company'])->firstOrFail();
            $jobCategory = JobCategory::where('name', $vacancy['category'])->firstOrFail();

            JobVacancy::firstOrCreate([
                'title' => $vacancy['title'],
                'companyId' => $company->id

            ], [
                'description' => $vacancy['description'],
                'location' => $vacancy['location'],
                'salary' => $vacancy['salary'],
                'type' => $vacancy['type'],
                'jobCategoryId' => $jobCategory->id,
            ]);
        }

        // create job applications from the data
        foreach ($jobApplications["jobApplications"] as $application) {
            // get random job vacancy // vacancy required for the foreign key relation (vacancyId)
            $jobVacancy = JobVacancy::inRandomOrder()->first();

            // create applicant user (job seeker) // user required for the foreign key relation (userId)
            $applicant = User::firstOrCreate([
                'email' => fake()->unique()->safeEmail()
            ], [
                'name' => fake()->name(),
                'password' => bcrypt('12345678'), // Set a default password
                'role' => 'job-seeker',
                'email_verified_at' => now(),
            ]);

            // create resume for the applicant // resume required for the foreign key relation (resumeId)
            $resume = Resume::create([
                "userId" => $applicant->id,
                'filename' => $application['resume']['filename'],
                'fileUri' => $application['resume']['fileUri'],
                'contactDetails' => $application['resume']['contactDetails'],
                'education' => $application['resume']['education'],
                'summary' => $application['resume']['summary'],
                'skills' => $application['resume']['skills'],
                'experience' => $application['resume']['experience'],
            ]);

            // create job application
            JobApplication::create([
                'jobVacancyId' => $jobVacancy->id,
                'userId' => $applicant->id,
                'resumeId' => $resume->id,
                "status" => $application['status'],
                "aiGeneratedScore" => $application['aiGeneratedScore'],
                "aiGeneratedFeedback" => $application['aiGeneratedFeedback'],
            ]);
        }
    }
}
