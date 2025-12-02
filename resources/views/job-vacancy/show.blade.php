 {{-- classes variables --}}
 @php
   $activeClass = 'text-blue-500 border-blue-500 hover:text-blue-700';
   $inactiveClass = 'text-gray-600 hover:text-gray-800  border-transparent hover:border-gray-300';
 @endphp

 <x-app-layout>
   <x-slot name="header">
     <h2 class="font-semibold text-xl text-gray-800">
       {{ $jobVacancy->title }}
     </h2>
   </x-slot>

   <x-base-wrapper>
     @include('components.toast')

     {{-- back button --}}
     <div class="mb-6">
       <a href="{{ route('job-vacancies.index') }}"
         class="bg-gray-200 hover:bg-gray-300 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
         ← Back
       </a>
     </div>

     {{-- wrapper --}}
     <div class="w-full mx-auto p-6 bg-white rounded-lg shadow-md">

       {{-- job Vacancy details --}}
       <div class="mb-4">
         <h3 class="text-lg font-semibold mb-2">Job vacancy details</h3>
         <p class="text-gray-800"><strong>Title:</strong> {{ $jobVacancy->title }}</p>
         <p class="text-gray-800"><strong>Description:</strong> {{ $jobVacancy->description }}</p>
         <p class="text-gray-800"><strong>Location:</strong> {{ $jobVacancy->location }}</p>
         <p class="text-gray-800"><strong>Salary:</strong> {{ $jobVacancy->salary }}</p>
         <p class="text-gray-800"><strong>Type:</strong> {{ $jobVacancy->type }}</p>
       </div>

       {{-- show the job Category name --}}
       <div class="mb-4">
         <h3 class="text-lg font-semibold mb-2 inline-block">Job Category: </h3>
         <span>{{ $jobCategory->name }}</span>
       </div>

       {{-- actions --}}

       <div class="flex justify-end space-x-2">
         <a href="{{ route('job-vacancies.edit', ['job_vacancy' => $jobVacancy->id, 'redirectToList' => 'false']) }}"
           class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
           Edit
         </a>

         <form action="{{ route('job-vacancies.destroy', $jobVacancy->id) }}" method="POST"
           onsubmit="return confirm('Are you sure you want to archive this job vacancy?');">
           @csrf
           @method('DELETE')
           <button type="submit"
             class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
             Archive
           </button>
         </form>
       </div>
     </div>

     {{-- relations with company and category --}}
     <div class="w-full mt-6 mx-auto p-6 bg-white rounded-lg shadow-md">

       {{-- Taps navigation --}}
       <ul class="flex space-x-4 mb-2">
         <li>
           <a href="{{ route('job-vacancies.show', ['job_vacancy' => $jobVacancy->id, 'tap' => 'company']) }}"
             class="{{ request('tap') == 'company' ? $activeClass : $inactiveClass }} font-semibold border-b-2 pb-1">
             Company
           </a>
         </li>
         <li>
           <a href="{{ route('job-vacancies.show', ['job_vacancy' => $jobVacancy->id, 'tap' => 'applications']) }}"
             class="{{ request('tap') == 'applications' ? $activeClass : $inactiveClass }} font-semibold border-b-2 pb-1">
             Applications
           </a>
         </li>
       </ul>

       {{-- Company details table --}}

       <div id="company" class="{{ request('tap') == 'company' ? 'block' : 'hidden' }}">
         <table class="min-w-full bg-gray-50 rounded-lg shadow mt-4">
           <!-- head -->
           <thead>
             <tr class="bg-gray-200 text-left">
               <th class="px-4 py-2 border">Name</th>
               <th class="px-4 py-2 border">industry</th>
               <th class="px-4 py-2 border">address</th>
               <th class="px-4 py-2 border">website</th>
             </tr>
           </thead>

           <!-- body -->
           <tbody>
             <!-- row 1 -->
             @if ($company)
               <tr class="border-b *:px-6 *:py-4 *:text-left *:text-gray-800 *:border-r ">
                 <td>
                   <a class=" text-blue-500 hover:text-blue-700 hover:underline"
                     href="{{ route('companies.show', ['company' => $company->id, 'tap' => 'jobs']) }}">
                     {{ $company->name }}
                   </a>
                 </td>
                 <td>{{ $company->industry }}</td>
                 <td>{{ $company->address }}</td>
                 <td>
                   <a href="{{ $company->website }}" target="_blank"
                     class="text-blue-500 hover:text-blue-700 hover:underline">
                     {{ $company->website }}
                   </a>
                 </td>
               </tr>
             @else
               <tr>
                 <td colspan="4" class="text-center py-4 text-gray-500"> No Companies found.</td>
               </tr>
             @endIf
           </tbody>
         </table>
       </div>

       {{-- Applications Tap --}}
       <div id="applications" class="{{ request('tap') == 'applications' ? 'block' : 'hidden' }}">
         <table class="min-w-full bg-gray-50 rounded-lg shadow mt-4 ">
           <thead>
             <tr class="bg-gray-200 text-left">
               <th class="px-4 py-2 border w-2"></th>
               <th class="px-4 py-2 border">Application Name</th>
               <th class="px-4 py-2 border">Job Title</th>
               <th class="px-4 py-2 border">status</th>
               <th class="px-4 py-2 border">Actions</th>
             </tr>
           </thead>
           <tbody>

             @forelse ($jobVacancy->jobApplications as $index => $application)
               <tr>
                 <td class="px-4 py-2 border text-center">{{ $index + 1 }}</td>
                 <td class="px-4 py-2 border">{{ $application->user->name }}</td>
                 <td class="px-4 py-2 border">{{ $application->jobVacancy->title }}</td>
                 <td class="px-4 py-2 border">{{ $application->status }}</td>
                 <td class="px-4 py-2 border">
                   <a href="{{ route('job-applications.show', $application->id) }}"
                     class="text-blue-500 hover:text-blue-700 hover:underline">
                     View
                   </a>
                 </td>
               </tr>
             @empty
               <tr>
                 <td colspan="5" class="text-center py-4 text-gray-500">No applications found for this job vacancy.
                 </td>
               </tr>
             @endforelse
           </tbody>
         </table>
       </div>

     </div>

   </x-base-wrapper>

 </x-app-layout>
