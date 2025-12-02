{{-- create Job category table --}}
<table class=" min-w-full divide-y divide-gray-200 bg-white rounded-lg shadow mt-4 ">
  <!-- head -->
  <thead>
    <tr class="*:px-6 *:py-3 *:text-left *:text-sm *:font-semibold *:text-gray-600 *:border-r">
      <th class="w-3"></th>
      <th>Name</th>
      <th>Created At</th>
      <th>Archived At</th>
      <th class="!border-r-0 w-7">Actions</th>
    </tr>
  </thead>

  <!-- body -->
  <tbody>
    <!-- row 1 -->
    @forelse ($companies as $index => $company)
      <tr class="border-b *:px-6 *:py-4 *:text-left *:text-gray-800 *:border-r ">
        <th class="text-center">{{ $index + 1 }}</th>
        <td>{{ $company->name }}</td>
        <td>{{ $company->created_at->format('Y-m-d') }}</td>
        <td>{{ $company->deleted_at->format('Y-m-d') }}</td>
        <td class="!border-r-0 flex gap-x-6">
          {{-- Restore button --}}
          <form action="{{ route('companies.restore', $company->id) }}" method="POST" class="inline-block"
            onsubmit="return confirm('Are you sure you want to restore this company?');">
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
        <td colspan="4" class="text-center py-4 text-gray-500"> No Companies found.</td>
      </tr>
    @endforelse
  </tbody>

</table>
