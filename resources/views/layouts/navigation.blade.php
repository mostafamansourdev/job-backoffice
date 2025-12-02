<nav class=" flex flex-col w-[250px] h-screen bg-white border-r border-gray-200">

  {{-- Application Logo --}}
  <div class="flex items-center py-4 px-6 border-b border-gray-200">
    <a href="{{ route('dashboard') }}" class="flex items-center gap-x-2">
      <x-application-logo class="w-auto h-6 fill-current text-gray-800" />
      <span class="text-lg font-semibold text-gray-800">Shaghalni</span>
    </a>
  </div>


  {{-- Navigation links --}}

  <ul class="flex flex-col flex-1 px-4 py-6 space-y-2 max-h-screen  overflow-y-auto">

    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
      Dashboard
    </x-nav-link>

    <x-nav-link :href="route('companies.index')" :active="request()->routeIs('companies.index')">
      Companies
    </x-nav-link>

    <x-nav-link :href="route('job-applications.index')" :active="request()->routeIs('job-applications.index')">
      Job Applications
    </x-nav-link>

    <x-nav-link :href="route('job-categories.index')" :active="request()->routeIs('job-categories.index')">
      Job Categories
    </x-nav-link>

    <x-nav-link :href="route('job-vacancies.index')" :active="request()->routeIs('job-vacancies.index')">
      Job Vacancies
    </x-nav-link>

    <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')">
      Users
    </x-nav-link>



  </ul>

  {{-- Logout --}}
  <ul>
    <hr>

    <form method="POST" action="logout" class="px-4 py-2">
      @csrf
      <x-nav-link :href="route('logout')" :active="false" class="text-red-500"
        onclick="event.preventDefault(); this.closest('form').submit();">
        Logout
      </x-nav-link>
    </form>

  </ul>


</nav>
