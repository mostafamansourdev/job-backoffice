 {{-- classes variables --}}
 @php
   $activeClass = 'text-blue-500 border-blue-500 hover:text-blue-700';
   $inactiveClass = 'text-gray-600 hover:text-gray-800  border-transparent hover:border-gray-300';
 @endphp

 <x-app-layout>
   <x-slot name="header">
     <h2 class="font-semibold text-xl text-gray-800">
       {{ $company->name }}
     </h2>
   </x-slot>

   <x-base-wrapper>
     @include('components.toast')

     {{-- back button --}}
     <div class="mb-6">
       <a href="{{ route('companies.index') }}"
         class="bg-gray-200 hover:bg-gray-300 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
         ← Back
       </a>
     </div>

     {{-- wrapper --}}
     <div class="w-full mx-auto p-6 bg-white rounded-lg shadow-md">

       {{-- company details --}}
       <div class="mb-4">
         <h3 class="text-lg font-semibold mb-2">Company details</h3>
         <p class="text-gray-800"><strong>Industry:</strong> {{ $company->industry }}</p>
         <p class="text-gray-800"><strong>Address:</strong> {{ $company->address }}</p>
       </div>
       <div class="mb-4">
         <h3 class="text-lg font-semibold mb-2">Website:</h3>
         <a href="{{ $company->website }}" target="_blank" class="text-blue-500 hover:text-blue-700 hover:underline">
           {{ $company->website }}
         </a>

       </div>

       {{-- actions --}}

       <div class="flex justify-end space-x-2">
         <a href="{{ route('companies.edit', ['company' => $company->id, 'redirectToList' => 'false']) }}"
           class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
           Edit
         </a>

         <form action="{{ route('companies.destroy', $company->id) }}" method="POST"
           onsubmit="return confirm('Are you sure you want to archive this company?');">
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
           <a href="{{ route('companies.show', ['company' => $company->id, 'tap' => 'jobs']) }}"
             class="{{ request('tap') == 'jobs' ? $activeClass : $inactiveClass }} font-semibold border-b-2 pb-1">
             Jobs
           </a>
         </li>
         <li>
           <a href="{{ route('companies.show', ['company' => $company->id, 'tap' => 'applications']) }}"
             class="{{ request('tap') == 'applications' ? $activeClass : $inactiveClass }} font-semibold border-b-2 pb-1">
             Applications
           </a>
         </li>

       </ul>

       {{-- Tap content --}}
       <div class="mt-4">

         {{-- Jobs Tap --}}
         <div id="jobs" class="{{ request('tap') == 'jobs' ? 'block' : 'hidden' }}">

           <table class="min-w-full bg-gray-50 rounded-lg shadow mt-4 ">
             <thead>
               <tr class="bg-gray-200 text-left">
                 <th class="px-4 py-2 border w-2"></th>
                 <th class="px-4 py-2 border">Job Title</th>
                 <th class="px-4 py-2 border">Type</th>
                 <th class="px-4 py-2 border">Location</th>
                 <th class="px-4 py-2 border">Actions</th>
               </tr>
             </thead>
             <tbody>

               @forelse ($company->jobVacancies as $index => $job)
                 <tr>
                   <td class="px-4 py-2 border text-center">{{ $index + 1 }}</td>
                   <td class="px-4 py-2 border">{{ $job->title }}</td>
                   <td class="px-4 py-2 border">{{ $job->type }}</td>
                   <td class="px-4 py-2 border">{{ $job->location }}</td>
                   <td class="px-4 py-2 border">
                     <a href="{{ route('job-vacancies.show', ['job_vacancy' => $job, 'tap' => 'company']) }}"
                       class="text-blue-500 hover:text-blue-700 hover:underline">
                       View
                     </a>
                   </td>
                 </tr>
               @empty
                 <tr>
                   <td colspan="5" class="text-center py-4 text-gray-500"> No Jobs found for this company.</td>
                 </tr>
               @endforelse
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

               @forelse ($company->jobApplications as $index => $application)
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
                   <td colspan="5" class="text-center py-4 text-gray-500">No Jobs found for this company.</td>
                 </tr>
               @endforelse
             </tbody>
           </table>
         </div>
       </div>



     </div>

   </x-base-wrapper>

 </x-app-layout>
