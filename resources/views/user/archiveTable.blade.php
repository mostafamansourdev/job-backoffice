@php
  $startIndex = (request()->get('page', 1) - 1) * 10;
@endphp

{{-- create Job category table --}}
<table class=" min-w-full divide-y divide-gray-200 bg-white rounded-lg shadow mt-4 ">
  <!-- head -->
  <thead>
    <tr class="*:px-6 *:py-3 *:text-left *:text-sm *:font-semibold *:text-gray-600 *:border-r">
      <th class="w-3"></th>
      <th>Name</th>
      <th>Email</th>
      <th>Role</th>
      <th class="!border-r-0 w-7">Actions</th>
    </tr>
  </thead>


  <!-- body -->
  <tbody>
    <!-- row 1 -->
    @forelse ($users as $index => $user)
      <tr class="border-b *:px-6 *:py-4 *:text-left *:border-r ">
        <th class="text-center">{{ $index + 1 + $startIndex }}</th>


        {{-- User Name --}}
        <td>
          {{ $user->name }}
        </td>
        {{-- User Email --}}
        <td>
          {{ $user->email }}
        </td>
        {{-- User Role --}}
        <td>
          {{ $user->role }}
        </td>

        {{-- actions --}}
        <td class="!border-r-0 flex gap-x-6">
          {{-- Restore button --}}
          <form action="{{ route('users.restore', $user->id) }}" method="POST" class="inline-block"
            onsubmit="return confirm('Are you sure you want to restore this User?');">
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
