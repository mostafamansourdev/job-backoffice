@php
  $startIndex = (request()->get('page', 1) - 1) * 6;
  $statusColors = [
      'pending' => 'text-yellow-600',
      'accepted' => 'text-green-600',
      'rejected' => 'text-red-600',
  ];
@endphp

{{-- create Job category table --}}
<table class=" min-w-full divide-y divide-gray-200 bg-white rounded-lg shadow mt-4 ">
  <!-- head -->
  <thead>
    <tr class="*:px-6 *:py-3 *:text-left *:text-sm *:font-semibold *:text-gray-600 *:border-r">
      <th class="w-3"></th>
      <th>Applicant Name</th>
      <th>Job Vacancy Position</th>
      <th>Company Name</th>
      <th>Status</th>
      <th>AI Score</th>
      <th class="!border-r-0 w-7">Actions</th>
    </tr>
  </thead>


  <!-- body -->
  <tbody>
    <!-- row 1 -->
    @forelse ($jobApplications as $index => $jobApplication)
      <tr class="border-b *:px-6 *:py-4 *:text-left *:border-r ">
        <th class="text-center">{{ $index + 1 + $startIndex }}</th>

        <td>
          <a class=" text-blue-500 hover:text-blue-700 hover:underline"
            href="{{ route('job-applications.show', ['job_application' => $jobApplication->id, 'tap' => 'job']) }}">
            {{ $jobApplication->user->name }}
          </a>
        </td>

        {{-- position --}}
        <td>
          {{ $jobApplication->jobVacancy?->title ?? 'N/A' }}
        </td>
        {{-- company --}}
        <td>
          {{ $jobApplication->jobVacancy?->company?->name ?? 'N/A' }}
        </td>
        {{-- status --}}
        <td class="{{ $statusColors[$jobApplication->status] }} capitalize">
          {{ $jobApplication->status }}
        </td>
        {{-- ai score --}}
        <td>
          {{ $jobApplication->aiGeneratedScore }}
        </td>

        {{-- actions --}}
        <td class="!border-r-0 flex gap-x-6">
          {{-- Edit button --}}
          <a href="{{ route('job-applications.edit', $jobApplication->id) }}"
            class="text-blue-500 hover:text-blue-700 ">
            🖊
            <p class="text-xs">Edit</p>
          </a>
          {{-- Delete button --}}
          <form action="{{ route('job-applications.destroy', $jobApplication->id) }}" method="POST"
            class="inline-block" onsubmit="return confirm('Are you sure you want to delete this Application?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-red-500 hover:text-red-700">
              📄
              <p class="text-xs">
                Archive
              </p>

            </button>
          </form>
        </td>

      </tr>
    @empty
      <tr>
        <td colspan="4" class="text-center py-4 text-gray-500"> No Job Vacancy found.</td>
      </tr>
    @endforelse
  </tbody>

</table>
