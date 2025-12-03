{{-- create Job category table --}}
<table class=" min-w-full divide-y divide-gray-200 bg-white rounded-lg shadow mt-4 ">
  <!-- head -->
  <thead>
    <tr class="*:px-6 *:py-3 *:text-left *:text-sm *:font-semibold *:text-gray-600 *:border-r">
      <th class="w-3"></th>
      <th>Applicant Name</th>
      <th>Job Vacancy Position</th>
      @if (!$isCompanyOwner)
        <th>Company Name</th>
      @endif
      <th>Status</th>
      <th>AI Score</th>
      <th class="!border-r-0 w-7">Actions</th>
    </tr>
  </thead>


  <!-- body -->
  <tbody>
    <!-- row 1 -->
    @forelse ($jobApplications as $index => $jobApplication)
      <tr class="border-b *:px-6 *:py-4 *:text-left *:text-gray-800 *:border-r ">
        <th class="text-center">{{ $index + 1 + $startIndex }}</th>

        <td>
          {{ $jobApplication->user->name }}
        </td>

        {{-- position --}}
        <td>
          {{ $jobApplication->jobVacancy?->title ?? 'N/A' }}
        </td>
        {{-- company name --}}
        @if (!$isCompanyOwner)
          <td>
            {{ $jobApplication->jobVacancy?->company?->name ?? 'N/A' }}
          </td>
        @endif
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
          {{-- Restore button --}}
          <form action="{{ route('job-applications.restore', $jobApplication->id) }}" method="POST" class="inline-block"
            onsubmit="return confirm('Are you sure you want to restore this Application?');">
            @csrf
            @method('PUT')
            <button type="submit" class="text-green-500 hover:text-green-700">
              ♻
              <p class="text-xs">
                Restore
              </p>
            </button>
          </form>
        </td>

      </tr>
    @empty
      <tr>
        <td colspan="6" class="text-center py-4 text-gray-500"> No Job Vacancy found.</td>
      </tr>
    @endforelse
  </tbody>

</table>
