<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800">
      {{ __('Edit Job Category') }}
    </h2>
  </x-slot>

  <x-base-wrapper>
    <div class="max-w-2xl mx-auto bg-white p-6 rounded shadow-md">

      <form action="{{ route('job-categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
          <label for="name" class="block text-gray-700 font-bold mb-2">Job Category Name</label>
          <input type="text" id="name" name="name" value="{{ old('name') ?? $category->name }}"
            class="{{ $errors->has('name') ? 'outline-red-500 outline outline-1 ' : '' }}  shadow appearance-none border border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
          @error('name')
            <p class="text-red-500 text-sm mt-2">* {{ $message }}</p>
          @enderror
        </div>
        <div class="flex items-center justify-end mt-2 space-x-6">
          {{-- cancel --}}
          <a href="{{ route('job-categories.index') }}" class="text-gray-500 hover:text-gray-700 font-bold ">
            Cancel
          </a>

          {{-- submit --}}
          <button type="submit"
            class="shadow hover:shadow-lg bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            Update Job Category
          </button>
        </div>
      </form>

    </div>
  </x-base-wrapper>



</x-app-layout>
