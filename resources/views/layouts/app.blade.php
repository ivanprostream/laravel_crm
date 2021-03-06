<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @include('layout.styles')

</head>
<body>
    <div id="app" class="bg-grey height100vh">

        <main class="py-4">
            @yield('content')
        </main>
    </div>


</body>
</html>
