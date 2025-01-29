<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>LoanMarket</title>

        <script src="https://kit.fontawesome.com/2673272b88.js" crossorigin="anonymous"></script>

        <style>
            main{
                background-image:
                        linear-gradient(to bottom, #3d3d3d6f, #1d1d1dae),
                        url("{{asset($data['background'])}}");

                min-height: 100vh !important;
            }
        </style>

        <link href="{{ asset('vendor/bladewind/css/animate.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('vendor/bladewind/css/bladewind-ui.min.css') }}" rel="stylesheet" />
        <script src="{{ asset('vendor/bladewind/js/helpers.js') }}"></script>

        @vite('resources/css/app.css')
    </head>
    <body>
        <main class="bg-cover bg-center bg-no-repeat">
            @yield('content')
        </main>
    </body>

    @stack('scripts')
</html>
