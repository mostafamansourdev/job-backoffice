@php
  // target job vacancy
  $job = $jobApplication->jobVacancy;

@endphp
<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800">
      {{ __('Edit Job Status') }}</h2>
  </x-slot>

  <x-base-wrapper>

    <div class="max-w-2xl mx-auto bg-white p-6 rounded shadow-md">

      {{-- form to create job vacancy --}}
      <div class="leading-3 mb-4">

        <h3 class="text-xl font-bold">Edit Applicant Status</h3>
      </div>

      <form
        action="{{ route('job-applications.update', ['job_application' => $jobApplication, 'redirectToList' => request()->query('redirectToList')]) }}"
        method="POST">
        @csrf
        @method('PUT')

        {{-- job application status --}}
        <div class="mb-4 p-6 bg-gray-50 border border-gray-200 rounded shadow-sm">

          <p class="text-gray-800"><strong>Position: </strong>{{ $job->title ?? 'N/A' }}</p>
          <p class="text-gray-800"><strong>Company: </strong>{{ $job->company?->name ?? 'N/A' }}</p>

          <p class="text-gray-800"><strong>AI Generated Score:</strong> {{ $jobApplication->aiGeneratedScore }}</p>
          <p class="text-gray-800"><strong>AI Generated Feedback:</strong> {{ $jobApplication->aiGeneratedFeedback }}
          </p>

          {{-- jop application status --}}
          <div class="my-4">
            <label for="status" class="block text-gray-700 font-bold mb-2">Status</label>
            <select id="status" name="status"
              class="{{ $errors->has('status') ? 'outline-red-500 outline outline-1' : '' }}  shadow appearance-none border border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
              <option value='pending' {{ old('status', $jobApplication->status) == 'pending' ? 'selected' : '' }}>
                Pending
              </option>
              <option value='accepted' {{ old('status', $jobApplication->status) == 'accepted' ? 'selected' : '' }}>
                Accepted
              </option>
              <option value='rejected' {{ old('status', $jobApplication->status) == 'rejected' ? 'selected' : '' }}>
                Rejected
              </option>
            </select>
            @error('status')
              <p class="text-red-500 text-sm mt-2">* {{ $message }}</p>
            @enderror
          </div>




          {{-- form actions --}}
          <div class="flex items-center justify-end mt-2 space-x-6">
            {{-- cancel --}}
            <a href="{{ route('job-applications.index') }}" class="text-gray-500 hover:text-gray-700 font-bold ">
              Cancel
            </a>

            {{-- submit --}}
            <button type="submit"
              class="shadow hover:shadow-lg bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
              Save </button>
          </div>
      </form>

    </div>

  </x-base-wrapper>



</x-app-layout>
