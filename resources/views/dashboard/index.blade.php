<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800">
      {{ __('Dashboard') }}
    </h2>
  </x-slot>

  @include('components.toast')
  <div class="py-12 px-6 flex flex-col gap-4">

    {{-- over view cards --}}
    <div class="grid grid-cols-3 gap-4">
      {{-- Active Users card --}}
      <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
        <h3 class="text-gray-900 font-medium text-lg">
          {{ __('Active Users') }}
        </h3>
        <p class="mt-1 text-indigo-600 text-3xl font-bold">{{ $analytics['activeUsers'] }}</p>
        <p class=" text-xs text-gray-500">Last 30 days.</p>
      </div>

      {{-- active job postings card --}}
      <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
        <h3 class="text-gray-900 font-medium text-lg">
          {{ __('Active Job Postings') }}
        </h3>
        <p class="mt-1 text-indigo-600 text-3xl font-bold">{{ $analytics['totalJobs'] }}</p>
        <p class=" text-xs text-gray-500">Currently active.</p>
      </div>

      {{-- total applications card --}}
      <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
        <h3 class="text-gray-900 font-medium text-lg">
          {{ __('Total Applications') }}
        </h3>
        <p class="mt-1 text-indigo-600 text-3xl font-bold">{{ $analytics['totalApplications'] }}</p>
        <p class=" text-xs text-gray-500">All time.</p>
      </div>
    </div>

    {{-- Most applied jobs --}}
    <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">

      <h3 class="text-gray-900 font-medium text-lg">
        {{ __('Most Applied Jobs') }}
      </h3>

      <table class="w-full mt-4 text-left divide-y divide-gray-200">
        <thead class="text-gray-500 text-xs font-medium uppercase">
          <tr>
            <th class="py-2">JOB TITLE</th>
            <th>COMPANY</th>
            <th>APPLICATIONS</th>
          </tr>
        </thead>

        <tbody class="text-gray-900 text-md font-medium divide-y divide-gray-200">

          @forelse ($mostAppliedJobs as $job)
            <tr>
              <td class="py-4">{{ $job->title }}</td>
              <td>{{ $job->company->name }}</td>
              <td>{{ $job->totalCount }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="3" class="text-center py-4">No data available</td>
            </tr>
          @endforelse
        </tbody>

      </table>
    </div>

    {{-- conversion rate --}}
    <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">

      <h3 class="text-gray-900 font-medium text-lg">
        {{ __('Top Converting Job Posts') }}
      </h3>

      <table class="w-full mt-4 text-left divide-y divide-gray-200">
        <thead>
          <tr class="text-gray-500 text-xs font-medium uppercase">
            <th class="py-2">JOB TITLE</th>
            <th>VIEWS</th>
            <th>APPLICANTS</th>
            <th>CONVERSION RATE</th>
          </tr>
        </thead>

        <tbody class="text-gray-900 text-md font-medium divide-y divide-gray-200">
          @forelse ($jobConversionRates as $job)
            <tr>
              <td class="py-4">{{ $job->title }}</td>
              <td>{{ $job->viewCount }}</td>
              <td>{{ $job->totalCount }}</td>
              <td>{{ $job->conversionRate }}%</td>
            </tr>
          @empty
            <tr>
              <td colspan="4" class="text-center py-4">No data available</td>
            </tr>
          @endforelse
        </tbody>

      </table>

    </div>

  </div>






</x-app-layout>
