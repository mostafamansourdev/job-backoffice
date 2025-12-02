 {{-- classes variables --}}
 @php
   $activeClass = 'text-blue-500 border-blue-500 hover:text-blue-700';
   $inactiveClass = 'text-gray-600 hover:text-gray-800  border-transparent hover:border-gray-300';

   // target job vacancy
   $job = $jobApplication->jobVacancy;
   // target applicant
   $applicant = $jobApplication->user;
   // target resume
   $resume = $jobApplication->resume;

   $statusColors = [
       'pending' => 'text-yellow-600',
       'accepted' => 'text-green-600',
       'rejected' => 'text-red-600',
   ];
 @endphp
 <x-app-layout>
   <x-slot name="header">
     <h2 class="font-semibold text-xl text-gray-800">
       Applicant: {{ $applicant->name ?? 'N/A' }}
     </h2>
   </x-slot>

   <x-base-wrapper>
     @include('components.toast')

     {{-- back button --}}
     <div class="mb-6">
       <a href="{{ route('job-applications.index') }}"
         class="bg-gray-200 hover:bg-gray-300 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
         ← Back
       </a>
     </div>

     {{-- wrapper --}}
     <div class="w-full mx-auto p-6 bg-white rounded-lg shadow-md">

       {{-- application details --}}
       <div class="mb-4 *:mb-2">
         <h3 class="text-lg font-semibold mb-2">Application details</h3>
         <p class="text-gray-800"><strong>job vacancy:</strong> {{ $job->title }}</p>
         <p class="text-gray-800"><strong>Status:</strong>
           <span class="{{ $statusColors[$jobApplication->status] }}">{{ $jobApplication->status }}</span>
         </p>
         <p class="text-gray-800"><strong>Email:</strong> {{ $applicant->email ?? 'N/A' }}</p>
         <p class="text-gray-800"><strong>Resume:</strong> <a class="text-blue-500 hover:text-blue-800 hover:underline"
             href="{{ $resume->fileUri }}" target="_blank">{{ $resume->filename }}</a>
         </p>

         <p class="text-gray-800"><strong>AI Generated Score:</strong> {{ $jobApplication->aiGeneratedScore }}</p>
         <p class="text-gray-800"><strong>AI Generated Feedback:</strong> {{ $jobApplication->aiGeneratedFeedback }}</p>
       </div>

       {{-- actions --}}

       <div class="flex justify-end space-x-2">
         <a href="{{ route('job-applications.edit', ['job_application' => $jobApplication->id, 'redirectToList' => 'false']) }}"
           class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
           Edit
         </a>

         <form action="{{ route('job-applications.destroy', $jobApplication->id) }}" method="POST"
           onsubmit="return confirm('Are you sure you want to archive this application?');">
           @csrf
           @method('DELETE')
           <button type="submit"
             class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
             Archive
           </button>
         </form>
       </div>
     </div>

     {{-- wrapper --}}
     <div class="w-full mt-6 mx-auto p-6 bg-white rounded-lg shadow-md">

       {{-- Taps navigation --}}
       <ul class="flex space-x-4">
         <li>
           <a href="{{ route('job-applications.show', ['job_application' => $jobApplication->id, 'tap' => 'job']) }}"
             class="{{ request('tap') == 'job' ? $activeClass : $inactiveClass }} font-semibold border-b-2 pb-1">
             Job
           </a>
         </li>

         <li>
           <a href="{{ route('job-applications.show', ['job_application' => $jobApplication->id, 'tap' => 'resume']) }}"
             class="{{ request('tap') == 'resume' ? $activeClass : $inactiveClass }} font-semibold border-b-2 pb-1">
             Resume
           </a>
         </li>


       </ul>

       {{-- Tap content --}}
       <div class="mt-4">

         {{-- Jobs Tap --}}
         <div id="job" class="{{ request('tap') == 'job' ? 'block' : 'hidden' }}">
           <table class="min-w-full bg-gray-50 rounded-lg shadow mt-4 ">
             <thead>
               <tr class="bg-gray-200 text-left">
                 <th class="px-4 py-2 border">Job Title</th>
                 <th class="px-4 py-2 border">Type</th>
                 <th class="px-4 py-2 border">Company</th>
                 <th class="px-4 py-2 border">Location</th>
                 <th class="px-4 py-2 border">Actions</th>
               </tr>
             </thead>
             <tbody>
               @if ($job)
                 <tr>
                   <td class="px-4 py-2 border">{{ $job->title ?? 'N/A' }}</td>
                   <td class="px-4 py-2 border">{{ $job->type ?? 'N/A' }}</td>
                   <td class="px-4 py-2 border">{{ $job->company?->name ?? 'N/A' }}</td>
                   <td class="px-4 py-2 border">{{ $job->location ?? 'N/A' }}</td>
                   <td class="px-4 py-2 border">
                     <a href="{{ route('job-vacancies.show', ['job_vacancy' => $job, 'tap' => 'company']) }}"
                       class="text-blue-500 hover:text-blue-700 hover:underline">
                       View
                     </a>
                   </td>
                 </tr>
               @else
                 <tr>
                   <td class="px-4 py-2 border text-center" colspan="4">No Job Vacancy Associated</td>
                 </tr>
               @endif
             </tbody>
           </table>
         </div>



         {{-- Resume Tap --}}
         <div id="resume" class="{{ request('tap') == 'resume' ? 'block' : 'hidden' }}">

           @if ($resume)
             <h3 class="font-bold text-lg mt-4">ContactDetails:</h3>
             <p>{{ $resume->contactDetails ?? 'N/A' }}</p>
             <table class="min-w-full bg-gray-50 rounded-lg shadow mt-4 ">
               <thead>
                 <tr class="bg-gray-200 text-left">
                   <th class="px-4 py-2 border">Education</th>
                   <th class="px-4 py-2 border">Summary</th>
                   <th class="px-4 py-2 border">Skills</th>
                   <th class="px-4 py-2 border">Experience</th>
                 </tr>
               </thead>
               <tbody>
                 <tr>
                   <td class="px-4 py-2 border">{{ $resume->education ?? 'N/A' }}</td>
                   <td class="px-4 py-2 border">{{ $resume->summary ?? 'N/A' }}</td>
                   <td class="px-4 py-2 border">{{ $resume->skills ?? 'N/A' }}</td>
                   <td class="px-4 py-2 border">{{ $resume->experience ?? 'N/A' }}</td>
                 </tr>
               </tbody>

             </table>
           @else
             <p class="px-4 py-2 border text-center" colspan="4">No resume Associated</p>
           @endif
         </div>

       </div>

   </x-base-wrapper>

 </x-app-layout>
