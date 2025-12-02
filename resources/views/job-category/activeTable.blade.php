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
      <th class="!border-r-0 w-7">Actions</th>
    </tr>
  </thead>


  <!-- body -->
  <tbody>
    <!-- row 1 -->
    @forelse ($jobCategories as $index => $jobCategory)
      <tr class="border-b *:px-6 *:py-4 *:text-left *:text-gray-800 *:border-r ">
        <th class="text-center">{{ $index + 1 + $startIndex }}</th>
        <td>{{ $jobCategory->name }}</td>

        {{-- actions --}}
        <td class="!border-r-0 flex gap-x-6">
          {{-- Edit button --}}
          <a href="{{ route('job-categories.edit', $jobCategory->id) }}" class="text-blue-500 hover:text-blue-700 ">
            🖊
            <p class="text-xs">Edit</p>
          </a>
          {{-- Delete button --}}
          <form action="{{ route('job-categories.destroy', $jobCategory->id) }}" method="POST" class="inline-block"
            onsubmit="return confirm('Are you sure you want to delete this job category?');">
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
        <td colspan="4" class="text-center py-4 text-gray-500"> No job categories found.</td>
      </tr>
    @endforelse
  </tbody>

</table>
