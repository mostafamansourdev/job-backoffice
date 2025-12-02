<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800">
      {{ __('Company') }}
      {{ request()->has('archive') && request()->input('archive') == 'true' ? '(Archived)' : '' }}
    </h2>
  </x-slot>

  <x-base-wrapper>
    {{-- toast message --}}
    @include('components.toast')

    <div class="flex justify-end space-x-2 items-center mb-2">
      {{-- show Archived job-Category button --}}
      @if (request()->has('archive') && request()->input('archive') == 'true')
        <a href="{{ route('companies.index') }}"
          class="bg-black hover:bg-gray-800 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
          Active
        </a>
      @else
        {{-- Add job-Category button --}}
        <a href="{{ route('companies.create') }}"
          class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
          Add company
        </a>

        <a href="{{ route('companies.index', ['archive' => 'true']) }}"
          class="bg-black hover:bg-gray-800 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
          Archived
        </a>
      @endif
    </div>

    <div>
      @if (request()->has('archive') && request()->input('archive') == 'true')
        @include('company.archiveTable')
      @else
        @include('company.activeTable')
      @endif
    </div>

    <div class="mt-4">
      {{ $companies->links() }}
    </div>

  </x-base-wrapper>

</x-app-layout>
