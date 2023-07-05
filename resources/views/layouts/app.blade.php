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

    <!-- Scripts -->
    @vite('resources/js/app.js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('tinymce/tinymce.min.js') }}"></script>
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
    <script>
        tinymce.init({
            selector: 'textarea',
            height: 610,
            plugins: 'lists link image imagetools media code',
            toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media | code'
        });
    </script>
    <script>
        $(document).ready(function() {

            $('#brand_id').on('change', function() {
                var brand_id = $(this).val();
                if (brand_id > 0) {
                    $.ajax({
                        url: "{{ url('category/list') }}/"+brand_id,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#category_id').empty();
                            $.each(data, function(key, value) {
                                $('#category_id').append('<option value="' + value.id + '">' +
                                    value.category_name + '</option>');
                            });
                        }
                    });
                } else {
                    $('#category_id').empty();
                    $('#category_id').append('<option value="">Please select brand first</option>');
                }
            });

            $('.tox-promotion').hide();
        });
    </script>
</body>

</html>
