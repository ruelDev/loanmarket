<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>LoanMarket</title>

        <link rel="icon" href="{{ asset('assets/images/loanmarket/logos/Loan-Market.svg') }}" type="image/x-icon">
        <linke rel="stylesheet" href="{{ asset('assets/css/swiper-bundle.min.css') }}">
        <script src="{{ asset('assets/js/swiper-bundle.min.js') }}"></script>
        <script src="https://kit.fontawesome.com/2673272b88.js" crossorigin="anonymous"></script>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="{{ asset('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />

        <style>
            :root {
                font-size: 16px !important;
            }
            body {
                scroll-behavior: smooth;
            }

            #hero-section{
                background-image:
                        linear-gradient(to bottom, #3d3d3d6f, #1d1d1dae),
                        /* linear-gradient(to bottom, #E5F7FD, #e5f7fd), */
                        url('{{asset('assets/images/loanmarket/bg/Mortgage-Repayments-Calculator.webp')}}');
                        color: #fefefe;
                        /* color: #01355C; */
            }

            .rso-card {
                transition: transform 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            }

            .rso-card:hover {
                transform: scale(1.05);
            }

            .swiper {
                width: 600px;
                height: 300px;
            }

            .calc-form input,
            #client_details_modal input,
            .calc-form select {
                width: 100%;
                /* max-width: 220px; */
                height: 45px;
                padding: 12px;
                border-radius: 10px !important;
                border: 1.5px solid lightgrey;
                outline: none;
                transition: all 0.3s cubic-bezier(0.19, 1, 0.22, 1);
                box-shadow: 0px 0px 20px -18px;
                position: relative;
            }

            .calc-form input:hover,
            #client_details_modal input:hover,
            .calc-form select:hover {
                border: 2px solid lightgrey;
                box-shadow: 0px 0px 20px -17px;
            }

            .calc-form input:active,
            #client_details_modal input:active,
            .calc-form select:active {
                transform: scale(0.95);
            }

            .radio-inputs {
                position: relative;
                display: flex;
                flex-wrap: wrap;
                border-radius: 0.5rem;
                background-color: #eee;
                box-sizing: border-box;
                box-shadow: 0 0 0px 1px rgba(0, 0, 0, 0.06);
                padding: 0.25rem;
                width: 100%;
                font-size: 14px;
            }

            .radio-inputs .radio {
                flex: 1 1 auto;
                text-align: center;
            }

            .radio-inputs .radio input {
                display: none;
            }

            .radio-inputs .radio .name {
                display: flex;
                cursor: pointer;
                align-items: center;
                justify-content: center;
                border-radius: 0.5rem;
                border: none;
                padding: 0.5rem 0;
                color: rgba(51, 65, 85, 1);
                transition: all 0.15s ease-in-out;
            }

            .radio-inputs .radio input:checked + .name {
                background-color: #fff;
                font-weight: 600;
            }

            /* Hover effect */
            .radio-inputs .radio:hover .name {
                background-color: rgba(255, 255, 255, 0.5);
            }

            /* Animation */
            .radio-inputs .radio input:checked + .name {
                position: relative;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
                animation: select 0.3s ease;
            }

            @keyframes select {
                0% {
                    transform: scale(0.95);
                }
                50% {
                    transform: scale(1.05);
                }
                100% {
                    transform: scale(1);
                }
            }

            #loan-term-container {
                max-height: 100px;
                opacity: 1;
                overflow: visible;
                transition: all 0.3s ease-in-out;
            }

            .hamburger {
                cursor: pointer;
            }

            .hamburger input {
                display: none;
            }

            .hamburger svg {
                /* The size of the SVG defines the overall size */
                height: 2em;
                /* Define the transition for transforming the SVG */
                transition: transform 600ms cubic-bezier(0.4, 0, 0.2, 1);
            }

            .line {
                fill: none;
                stroke: #2B2B2B;
                stroke-linecap: round;
                stroke-linejoin: round;
                stroke-width: 3;
                /* Define the transition for transforming the Stroke */
                transition: stroke-dasharray 600ms cubic-bezier(0.4, 0, 0.2, 1),
                            stroke-dashoffset 600ms cubic-bezier(0.4, 0, 0.2, 1);
            }

            .line-top-bottom {
                stroke-dasharray: 12 63;
            }

            .hamburger input:checked + svg {
                transform: rotate(-45deg);
            }

            .hamburger input:checked + svg .line-top-bottom {
                stroke-dasharray: 20 300;
                stroke-dashoffset: -32.42;
            }

            /* Chrome, Safari, Edge, Opera */
            input[type="number"]::-webkit-inner-spin-button,
            input[type="number"]::-webkit-outer-spin-button {
                -webkit-appearance: none;
                margin: 0;
            }

            /* Firefox */
            input[type="number"] {
                -moz-appearance: textfield;
            }
        </style>

        @vite(['resources/css/app.css','resources/js/app.js'])
    </head>
    <body class="bg-white-1 font-geomanist">
        @include('components.header')
        @yield('content')
        @include('components.footer')
    </body>
    <script src="assets/plugins/global/plugins.bundle.js"></script>
    <script src="assets/js/scripts.bundle.js"></script>
    @stack('scripts')
</html>
