<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

  <!-- Scripts -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="font-sans antialiased">

  {{-- if screen width is less than 830px display a message to open the website on a laptop, pc or any device with a big screen else show the page --}}

  <div class="@screen max-xl:block hidden w-full h-screen bg-gray-200 pt-6">
    <div class="text-center bg-white shadow-md rounded max-w-sm m-auto p-4">
      <h2 class="text-xl font-bold">❌❌ can't open ❌❌</h2>
      <p>Open The website on a laptop, pc or any device with a big screen.</p>
    </div>
  </div>


  <div class="flex @screen max-xl:hidden">
    @include('layouts.navigation')

    <div class="flex-1 min-h-screen bg-slate-100 max-h-screen  overflow-y-auto">

      <!-- Page Heading -->
      @isset($header)
        <header class="bg-white shadow sticky top-0 z-10">
          <div class="py-4 px-4 w-full">
            {{ $header }}
          </div>
        </header>
      @endisset

      <!-- Page Content -->
      <main>
        {{ $slot }}
      </main>
    </div>


  </div>
</body>

</html>
