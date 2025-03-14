<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>YourHomeLoanReview</title>

        <link rel="icon" href="{{ asset('assets/images/loanmarket/logos/favicon.png') }}" type="image/x-icon">
        <linke rel="stylesheet" href="{{ asset('assets/css/swiper-bundle.min.css') }}">
        <script src="{{ asset('assets/js/swiper-bundle.min.js') }}"></script>
        <script src="https://kit.fontawesome.com/2673272b88.js" crossorigin="anonymous"></script>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="{{ asset('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;600;700&display=swap" rel="stylesheet">

        <style>
            :root {
                font-size: 16px !important;
                scroll-behavior: smooth !important;
            }

            body {
                font-family: 'poppins';
                position: relative;
            }

            .navbar-link {
                position: relative;
            }

            .navbar-link::after {
                content: "";
                position: absolute;
                width: 5px;
                height: 2px;
                bottom: -3px;
                left: 0;
                border-radius: 100vmax;
                background: #00ABE6;
                transition: all .25s ease-in;
                opacity: 0;
            }

            .navbar-link:hover::after {
                width: 100%;
                opacity: 1;
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
            #become_partner_modal input,
            #become_partner_modal textarea,
            #feedback_modal input,
            #feedback_modal textarea,
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
            #become_partner_modal input:hover,
            #become_partner_modal textarea:hover,
            #feedback_modal input:hover,
            #feedback_modal textarea:hover,
            .calc-form select:hover {
                border: 2px solid lightgrey;
                box-shadow: 0px 0px 20px -17px;
            }

            .calc-form input:active,
            #client_details_modal input:active,
            #become_partner_modal input:active,
            #become_partner_modal textarea:active,
            #feedback_modal input:active,
            #feedback_modal textarea:active,
            .calc-form select:active {
                transform: scale(0.95);
            }

            #become_partner_modal textarea,
            #feedback_modal textarea {
                min-height: 150px !important;
                resize: none;
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

            input[type="number"]::-webkit-inner-spin-button,
            input[type="number"]::-webkit-outer-spin-button {
                -webkit-appearance: none;
                margin: 0;
            }

            input[type="number"] {
                -moz-appearance: textfield;
            }


            .dots-container {
                display: flex;
                align-items: center;
                justify-content: center;
                height: 100%;
                width: 100%;
            }

            .dot {
                height: 10px;
                width: 10px;
                margin-right: 10px;
                border-radius: 10px;
                background-color: #b3d4fc;
                animation: pulse 1.5s infinite ease-in-out;
            }

            .dot:last-child {
                margin-right: 0;
            }

            .dot:nth-child(1) {
                animation-delay: -0.3s;
            }

            .dot:nth-child(2) {
                animation-delay: -0.1s;
            }

            .dot:nth-child(3) {
                animation-delay: 0.1s;
            }

            @keyframes pulse {
                0% {
                    transform: scale(0.8);
                    background-color: #b3d4fc;
                    box-shadow: 0 0 0 0 rgba(178, 212, 252, 0.7);
                }

                50% {
                    transform: scale(1.2);
                    background-color: #6793fb;
                    box-shadow: 0 0 0 10px rgba(178, 212, 252, 0);
                }

                100% {
                    transform: scale(0.8);
                    background-color: #b3d4fc;
                    box-shadow: 0 0 0 0 rgba(178, 212, 252, 0.7);
                }
            }
            .hero-button {
                transition: .2s ease-in-out;
                transition:
            }

            .hero-button:hover {
                transform: scale(1.5) !important;
            }
        </style>

        @vite(['resources/css/app.css','resources/js/app.js'])
    </head>
    <body class="bg-white-1 font-poppins relative">
        @include('components.header')
        @yield('content')

        <button class="bg-blue text-white py-2 px-5 rounded-sm mt-5 transition-all ease-in-out hover:scale-110 hidden sm:block fixed left-[1rem] top-1/2 -translate-y-1/2 rotate-90 origin-left" onclick="openmodal()">Become a Partner</button>

        <div class="fixed bottom-[3rem] right-[2rem] flex flex-col gap-5">
            <button id="backToTop" class="hidden sm:block  bg-blue w-[3.5rem] h-[3.5rem] rounded-full text-[1rem] opacity-0 invisible transition-all duration-200 hover:scale-125"><i class="fa-solid fa-arrow-up text-white"></i></button>
            <button class="hidden sm:block  bg-blue w-[3.5rem] h-[3.5rem] rounded-full text-[1rem] transition-all duration-200 hover:scale-125" onclick="openmodalFeedback()"><i class="fa-solid fa-comment text-white"></i></button>
        </div>

        <div class="modal fade" tabindex="-1" id="become_partner_modal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <h3 class="my-3 text-xl">Become a Partner</h3>
                        <form id="become_partner_form">
                            @csrf
                            <div class="mb-3">
                                <label class="label text-xs text-black required" for="name">Name</label>
                                <input id="name" name="name" type="text" placeholder="Name" required>
                            </div>
                            <div class="mb-3">
                                <label class="label text-xs text-black required" for="phone">Contact Number</label>
                                <input id="phone" name="phone" type="text" placeholder="Contact Number" required>
                            </div>
                            <div class="mb-3">
                                <label class="label text-xs text-black required" for="email">Email</label>
                                <input id="email" name="email" type="email" placeholder="Email" required>
                            </div>
                            <div class="mb-3">
                                <label class="label text-xs text-black required" for="message">Message</label>
                                <textarea id="message" name="message" type="message" placeholder="Message" required></textarea>
                            </div>
                            <button type="button" class="bg-gray-100 border border-gray-100 text-black px-5 py-3 rounded" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="bg-blue text-white px-5 py-3 rounded" id="clientDetailsSubmit">Continue</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" tabindex="-1" id="feedback_modal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <h3 class="my-3 text-xl">Send Feedback</h3>
                        <form id="feedback_form">
                            @csrf
                            <div class="mb-3">
                                <label class="label text-xs text-black required" for="name">Name</label>
                                <input id="name" name="name" type="text" placeholder="Name" required>
                            </div>
                            <div class="mb-3">
                                <label class="label text-xs text-black required" for="email">Email</label>
                                <input id="email" name="email" type="email" placeholder="Email" required>
                            </div>
                            <div class="mb-3">
                                <label class="label text-xs text-black required" for="message">Message</label>
                                <textarea id="message" name="message" type="message" placeholder="Message" required></textarea>
                            </div>
                            <button type="button" class="bg-gray-100 border border-gray-100 text-black px-5 py-3 rounded" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="bg-blue text-white px-5 py-3 rounded" id="FeedbackSubmit">Send</button>
                            <button class="bg-blue text-white px-5 py-3 rounded hidden" id="FeedbackPleasewait">Please wait...</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @include('components.footer')

    </body>
    <script src="assets/plugins/global/plugins.bundle.js"></script>
    <script src="assets/js/scripts.bundle.js"></script>
    @stack('scripts')

    <script>
        const backToTopButton = document.getElementById('backToTop');

        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
                backToTopButton.classList.remove('opacity-0', 'invisible');
                backToTopButton.classList.add('opacity-100', 'visible');
            } else {
                backToTopButton.classList.remove('opacity-100', 'visible');
                backToTopButton.classList.add('opacity-0', 'invisible');
            }
        });

        backToTopButton.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        function openmodal() {
            const myModal = new bootstrap.Modal(document.getElementById('become_partner_modal'));
            myModal.show();
            return;
        }

        function openmodalFeedback() {
            const myModal = new bootstrap.Modal(document.getElementById('feedback_modal'));
            myModal.show();
            return;
        }

        document.getElementById('become_partner_form').addEventListener('submit', function(e) {
            e.preventDefault();

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const form = document.getElementById("become_partner_form");
            const formData = new FormData(form); // Collect form data

            fetch("{{route('become-partner.email')}}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    Swal.fire({
                        text: "Request send successfully!",
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    })
                    .then(() => {
                        form.reset();
                        $('#become_partner_modal').modal('hide');
                        window.location.reload();
                    })
                }
                else {
                    Swal.fire({
                        text: "Something went wrong while requesting.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok",
                        customClass: {
                            confirmButton: "btn btn-danger"
                        }
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    text: "An error occurred while submitting the form.",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Ok",
                    customClass: {
                        confirmButton: "btn btn-danger"
                    }
                })
                .then(() => {
                    $('#client_details_modal').modal('hide');
                });
            });
        })

        document.getElementById('feedback_form').addEventListener('submit', function(e) {
            e.preventDefault();

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const form = document.getElementById("feedback_form");
            const formData = new FormData(form); // Collect form data

            $('#FeedbackPleasewait').removeClass('hidden');
            $('#FeedbackSubmit').addClass('hidden');

            fetch("{{route('feedback.email')}}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    Swal.fire({
                        text: "Feedback send successfully!",
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    })
                    .then(() => {
                        $('#FeedbackPleasewait').addClass('hidden');
                        $('#FeedbackSubmit').removeClass('hidden');
                        form.reset();
                        $('#feedback_modal').modal('hide');
                        window.location.reload();
                    })
                }
                else {
                    Swal.fire({
                        text: "Something went wrong while requesting.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok",
                        customClass: {
                            confirmButton: "btn btn-danger"
                        }
                    });

                    $('#FeedbackPleasewait').addClass('hidden');
                    $('#FeedbackSubmit').removeClass('hidden');
                }
            })
            .catch(error => {
                Swal.fire({
                    text: "An error occurred while submitting the form.",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Ok",
                    customClass: {
                        confirmButton: "btn btn-danger"
                    }
                })
                .then(() => {
                    $('#FeedbackPleasewait').addClass('hidden');
                    $('#FeedbackSubmit').removeClass('hidden');
                    $('#feedback_modal').modal('hide');
                });
            });
        })
    </script>
</html>
