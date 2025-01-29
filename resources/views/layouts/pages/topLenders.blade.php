<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>LoanMarket</title>

        <link rel="icon" href="{{ asset('assets/images/loanmarket/logos/Loan-Market.svg') }}" type="image/x-icon">

        <script src="https://kit.fontawesome.com/2673272b88.js" crossorigin="anonymous"></script>

        <style>
            #hero-section{
                background-image:
                        /* linear-gradient(to bottom, #3d3d3d6f, #1d1d1dae), */
                        linear-gradient(to bottom, #E5F7FD, #e5f7fd),
                        url('{{asset('assets/images/loanmarket/bg/Mortgage-Repayments-Calculator.webp')}}');
                        /* color: #fefefe; */
                        color: #01355C;
            }
        </style>

        @vite('resources/css/app.css')
    </head>
    <body class="bg-white-1 font-geomanist">
        @yield('content')
        @include('components.footer')
    </body>
</html>
