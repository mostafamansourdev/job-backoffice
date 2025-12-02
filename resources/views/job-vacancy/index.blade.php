<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800">
      {{ __('Job Vacancy') }}
      {{ request()->has('archive') && request()->input('archive') == 'true' ? '(Archived)' : '' }}
    </h2>
  </x-slot>

  <x-base-wrapper>
    {{-- toast message --}}
    @include('components.toast')

    <div class="flex justify-end space-x-2 items-center mb-2">
      {{-- show Archived job-Category button --}}
      @if (request()->has('archive') && request()->input('archive') == 'true')
        <a href="{{ route('job-vacancies.index') }}"
          class="bg-black hover:bg-gray-800 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
          Active
        </a>
      @else
        {{-- Add job-Category button --}}
        <a href="{{ route('job-vacancies.create') }}"
          class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
          Add new jop Vacancy
        </a>

        <a href="{{ route('job-vacancies.index', ['archive' => 'true']) }}"
          class="bg-black hover:bg-gray-800 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
          Archived
        </a>
      @endif
    </div>

    <div>
      @if (request()->has('archive') && request()->input('archive') == 'true')
        @include('job-vacancy.archiveTable')
      @else
        @include('job-vacancy.activeTable')
      @endif
    </div>

    <div class="mt-4">
      {{ $jobVacancies->links() }}
    </div>

  </x-base-wrapper>

</x-app-layout>
