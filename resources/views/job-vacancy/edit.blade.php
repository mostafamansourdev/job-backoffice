<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800">
      {{ __('Edit Job vacancy') }}</h2>
  </x-slot>

  <x-base-wrapper>

    <div class="max-w-2xl mx-auto bg-white p-6 rounded shadow-md">

      {{-- form to create job vacancy --}}
      <div class="leading-3 mb-4">

        <h3 class="text-xl font-bold">Edit Job Vacancy
          <span class="font-normal text-gray-500 text-sm "> - Enter details</span>
        </h3>
      </div>

      <form
        action="{{ route('job-vacancies.update', ['job_vacancy' => $jobVacancy, 'redirectToList' => request()->query('redirectToList')]) }}"
        method="POST">
        @csrf
        @method('PUT')

        {{-- job vacancy details --}}
        <div class="mb-4 p-6 bg-gray-50 border border-gray-200 rounded shadow-sm">


          {{-- job vacancy title --}}
          <div class="mb-4">
            <label for="title" class="block text-gray-700 font-bold mb-2">Title</label>
            <input type="text" id="title" name="title" value="{{ old('title', $jobVacancy->title) }}"
              class="{{ $errors->has('title') ? 'outline-red-500 outline outline-1' : '' }}  shadow appearance-none border border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            @error('title')
              <p class="text-red-500 text-sm mt-2">* {{ $message }}</p>
            @enderror
          </div>

          {{-- job vacancy location --}}
          <div class="my-4">
            <label for="location" class="block text-gray-700 font-bold mb-2">Location</label>
            <input type="text" id="location" name="location" value="{{ old('location', $jobVacancy->location) }}"
              class="{{ $errors->has('location') ? 'outline-red-500 outline outline-1' : '' }} shadow appearance-none border border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            @error('location')
              <p class="text-red-500 text-sm mt-2">* {{ $message }}</p>
            @enderror
          </div>

          {{-- Job Vacancy salary --}}
          <div class="my-4">
            <label for="salary" class="block text-gray-700 font-bold mb-2">Expected salary (USD)</label>
            <input type="number" id="salary" name="salary" value="{{ old('salary', $jobVacancy->salary) }}"
              class="{{ $errors->has('salary') ? 'outline-red-500 outline outline-1' : '' }}  shadow appearance-none border border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            @error('salary')
              <p class="text-red-500 text-sm mt-2">* {{ $message }}</p>
            @enderror
          </div>


          {{-- jop vacancy type --}}
          <div class="my-4">
            <label for="type" class="block text-gray-700 font-bold mb-2">Job Type</label>
            <select id="type" name="type"
              class="{{ $errors->has('type') ? 'outline-red-500 outline outline-1' : '' }}  shadow appearance-none border border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
              <option value='Full-Time' {{ old('type', $jobVacancy->type) == 'Full-Time' ? 'selected' : '' }}>Full-Time
              </option>
              <option value='Contract' {{ old('type', $jobVacancy->type) == 'Contract' ? 'selected' : '' }}>Contract
              </option>
              <option value='Remote' {{ old('type', $jobVacancy->type) == 'Remote' ? 'selected' : '' }}>Remote</option>
              <option value='Hybrid' {{ old('type', $jobVacancy->type) == 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
            </select>
            @error('type')
              <p class="text-red-500 text-sm mt-2">* {{ $message }}</p>
            @enderror
          </div>

          {{-- jop vacancy jobCategoryId --}}
          <div class="my-4">
            <label for="jobCategoryId" class="block text-gray-700 font-bold mb-2">Job Category</label>
            <select id="jobCategoryId" name="jobCategoryId"
              class="{{ $errors->has('jobCategoryId') ? 'outline-red-500 outline outline-1' : '' }}  shadow appearance-none border border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
              @foreach ($jobCategories as $jobCategory)
                <option value="{{ $jobCategory->id }}"
                  {{ old('jobCategory', $jobVacancy->jobCategoryId) == $jobCategory->id ? 'selected' : '' }}>
                  {{ $jobCategory->name }}
                </option>
              @endforeach
            </select>
            @error('jobCategoryId')
              <p class="text-red-500 text-sm mt-2">* {{ $message }}</p>
            @enderror
          </div>

          {{-- jop vacancy company --}}
          <div class="my-4">
            <label for="companyId" class="block text-gray-700 font-bold mb-2">Company</label>
            <select id="companyId" name="companyId"
              class="{{ $errors->has('companyId') ? 'outline-red-500 outline outline-1' : '' }}  shadow appearance-none border border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
              @foreach ($companies as $company)
                <option value="{{ $company->id }}"
                  {{ old('company', $jobVacancy->companyId) == $company->id ? 'selected' : '' }}>
                  {{ $company->name }}
                </option>
              @endforeach
            </select>
            @error('companyId')
              <p class="text-red-500 text-sm mt-2">* {{ $message }}</p>
            @enderror
          </div>

          {{-- job vacancy description --}}
          <div class="my-4">
            <label for="description" class="block text-gray-700 font-bold mb-2">Description</label>
            <textarea type="text" id="description" name="description"
              class="{{ $errors->has('description') ? 'outline-red-500 outline outline-1' : '' }} h-40 shadow appearance-none border border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('description', $jobVacancy->description) }}</textarea>
            @error('description')
              <p class="text-red-500 text-sm mt-2">* {{ $message }}</p>
            @enderror
          </div>

        </div>

        {{-- form actions --}}
        <div class="flex items-center justify-end mt-2 space-x-6">
          {{-- cancel --}}
          <a href="{{ route('companies.index') }}" class="text-gray-500 hover:text-gray-700 font-bold ">
            Cancel
          </a>

          {{-- submit --}}
          <button type="submit"
            class="shadow hover:shadow-lg bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            Add job vacancy
          </button>
        </div>
      </form>

    </div>

  </x-base-wrapper>



</x-app-layout>
