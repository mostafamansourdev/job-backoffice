<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800">
      {{ __('Add A new company') }} </h2>
  </x-slot>

  <x-base-wrapper>

    <div class="max-w-2xl mx-auto bg-white p-6 rounded shadow-md">

      {{-- form to create Company --}}

      <form action="{{ route('companies.store') }}" method="POST">
        @csrf

        {{-- company details --}}
        <div class="mb-4 p-6 bg-gray-50 border border-gray-200 rounded shadow-sm">

          <div class="leading-3">

            <h3 class="text-xl font-bold">Company Details
              <span class="font-normal text-gray-500 text-sm "> - Enter company details</span>
            </h3>
          </div>

          {{-- company name --}}
          <div class="my-4">
            <label for="name" class="block text-gray-700 font-bold mb-2">Name</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}"
              class="{{ $errors->has('name') ? 'outline-red-500 outline outline-1' : '' }}  shadow appearance-none border border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            @error('name')
              <p class="text-red-500 text-sm mt-2">* {{ $message }}</p>
            @enderror
          </div>

          {{-- company address --}}
          <div class="my-4">
            <label for="address" class="block text-gray-700 font-bold mb-2">Address</label>
            <input type="text" id="address" name="address" value="{{ old('address') }}"
              class="{{ $errors->has('address') ? 'outline-red-500 outline outline-1' : '' }}  shadow appearance-none border border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            @error('address')
              <p class="text-red-500 text-sm mt-2">* {{ $message }}</p>
            @enderror
          </div>

          {{-- company industry --}}
          <div class="my-4">
            <label for="industry" class="block text-gray-700 font-bold mb-2">Industry</label>
            <select id="industry" name="industry"
              class="{{ $errors->has('industry') ? 'outline-red-500 outline outline-1' : '' }}  shadow appearance-none border border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
              <option value="">-- Select Industry --</option>
              @foreach ($industries as $industry)
                <option value="{{ $industry }}" {{ old('industry') == $industry ? 'selected' : '' }}>
                  {{ $industry }}
                </option>
              @endforeach
            </select>
            @error('industry')
              <p class="text-red-500 text-sm mt-2">* {{ $message }}</p>
            @enderror
          </div>

          {{-- company website --}}
          <div class="my-4">
            <label for="website" class="block text-gray-700 font-bold mb-2">Website <span
                class="font-normal text-gray-500 text-sm ">(Optional)</span>
            </label>
            <input type="text" id="website" name="website" value="{{ old('website') }}"
              class="{{ $errors->has('website') ? 'outline-red-500 outline outline-1' : '' }}  shadow appearance-none border border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            @error('website')
              <p class="text-red-500 text-sm mt-2">* {{ $message }}</p>
            @enderror
          </div>

        </div>


        {{-- company owner --}}
        <div class="mb-4 p-6 bg-gray-50 border border-gray-200 rounded shadow-sm">
          <h3 class="text-xl font-bold">Company owner
            <span class="font-normal text-gray-500 text-sm "> - Enter the owner details of this company</span>
          </h3>

          {{-- owner name --}}
          <div class="my-4">
            <label for="owner_name" class="block text-gray-700 font-bold mb-2">Name</label>
            <input type="text" id="owner_name" name="owner_name" value="{{ old('owner_name') }}"
              class="{{ $errors->has('owner_name') ? 'outline-red-500 outline outline-1' : '' }}  shadow appearance-none border border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            @error('owner_name')
              <p class="text-red-500 text-sm mt-2">* {{ $message }}</p>
            @enderror
          </div>

          {{-- owner email --}}
          <div class="my-4">
            <label for="owner_email" class="block text-gray-700 font-bold mb-2">Email</label>
            <input type="email" id="owner_email" name="owner_email" value="{{ old('owner_email') }}"
              class="{{ $errors->has('owner_email') ? 'outline-red-500 outline outline-1' : '' }}  shadow appearance-none border border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            @error('owner_email')
              <p class="text-red-500 text-sm mt-2">* {{ $message }}</p>
            @enderror
          </div>

          {{-- owner password --}}

          <div>
            <label for="owner_password" class="block text-gray-700 font-bold mb-2">Password</label>
            <div class="relative" x-data="{ showPassword: false }">

              <x-text-input id="owner_password" class="block mt-1 w-full" name="owner_password" required
                autocomplete="current-password" x-bind:type="showPassword ? 'text' : 'password'" />

              {{-- eye open --}}
              <button type="button" @click=" showPassword = !showPassword"
                class="absolute inset-y-0 right-2 flex items-center text-gray-500 hover:text-gray-700">

                <svg x-show="!showPassword" class="w-5 h-5" width="800px" height="800px" viewBox="0 0 24 24"
                  fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M15.0007 12C15.0007 13.6569 13.6576 15 12.0007 15C10.3439 15 9.00073 13.6569 9.00073 12C9.00073 10.3431 10.3439 9 12.0007 9C13.6576 9 15.0007 10.3431 15.0007 12Z"
                    stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                  <path
                    d="M12.0012 5C7.52354 5 3.73326 7.94288 2.45898 12C3.73324 16.0571 7.52354 19 12.0012 19C16.4788 19 20.2691 16.0571 21.5434 12C20.2691 7.94291 16.4788 5 12.0012 5Z"
                    stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                {{-- eye closed --}}
                <svg x-show="showPassword" class="w-5 h-5" width="800px" height="800px" viewBox="0 0 24 24"
                  fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M2.99902 3L20.999 21M9.8433 9.91364C9.32066 10.4536 8.99902 11.1892 8.99902 12C8.99902 13.6569 10.3422 15 11.999 15C12.8215 15 13.5667 14.669 14.1086 14.133M6.49902 6.64715C4.59972 7.90034 3.15305 9.78394 2.45703 12C3.73128 16.0571 7.52159 19 11.9992 19C13.9881 19 15.8414 18.4194 17.3988 17.4184M10.999 5.04939C11.328 5.01673 11.6617 5 11.9992 5C16.4769 5 20.2672 7.94291 21.5414 12C21.2607 12.894 20.8577 13.7338 20.3522 14.5"
                    stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </button>
            </div>

            <x-input-error :messages="$errors->get('owner_password')" class="mt-2" />

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
            Add Company
          </button>
        </div>
      </form>

    </div>

  </x-base-wrapper>



</x-app-layout>
