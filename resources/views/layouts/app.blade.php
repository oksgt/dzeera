<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>D'Zeera</title>
    <link rel="icon" href="{{ asset('images/brand/dzeera-icon.png') }}" />
    <link rel="stylesheet" href="//cdn.ckeditor.com/4.16.2/standard/ckeditor.css">
    <!-- Styles -->
    @vite('resources/sass/app.scss')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" crossorigin="anonymous" />
    <!-- Scripts -->
    @vite('resources/js/app.js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {{-- <script src="{{ asset('tinymce/tinymce.min.js') }}"></script> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .form-check-input:checked{
            background-color: green !important;
            border-color: green !important;
        }
    </style>
</head>

<body>
    @include('layouts.nav')
    @include('layouts.sidenav')
    <main class="content">
        {{-- TopBar --}}
        @include('layouts.topbar')
        @yield('content')
        {{-- Footer --}}
        @include('layouts.footer')
    </main>

    @yield('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="//cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" crossorigin="anonymous"></script>
    <script>
        if (document.getElementById('product_desc') !== null) {
            CKEDITOR.replace('product_desc');
        }

        if (document.getElementById('info_mesasge') !== null) {
            CKEDITOR.replace('info_mesasge');
        }

        if (document.getElementById('about-us-text') !== null) {
            CKEDITOR.replace('about-us-text');
        }
    </script>
    <script>
        function onBrandSelect(selectElement) {
            var selectedBrandId = selectElement.value;
            window.location.href = "{{ route('about-us.index') }}?brand_id=" + selectedBrandId;
        }
    </script>

</body>

</html>
