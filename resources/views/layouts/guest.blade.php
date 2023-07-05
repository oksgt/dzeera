<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>D'Zeera</title>
    <link rel="icon" href="{{ asset('images/brand/dzeera-icon.png') }}" />


    <!-- Styles -->
    @vite('resources/sass/app.scss')
</head>

<body>
    <main>
        <section class="vh-lg-100 mt-5 mt-lg-0 bg-soft d-flex align-items-center">
            @yield('content')
        </section>
    </main>
</body>

</html>
