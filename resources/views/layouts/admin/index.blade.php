<!DOCTYPE html>
<html lang="en">
	<head>
		<title>ADMIN</title>

		<meta charset="utf-8" />
		<meta name="description" content="The most advanced Tailwind CSS & Bootstrap 5 Admin Theme with 40 unique prebuilt layouts on Themeforest trusted by 100,000 beginners and professionals. Multi-demo, Dark Mode, RTL support and complete React, Angular, Vue, Asp.Net Core, Rails, Spring, Blazor, Django, Express.js, Node.js, Flask, Symfony & Laravel versions. Grab your copy now and get life-time updates for free." />
		<meta name="keywords" content="tailwind, tailwindcss, metronic, bootstrap, bootstrap 5, angular, VueJs, React, Asp.Net Core, Rails, Spring, Blazor, Django, Express.js, Node.js, Flask, Symfony & Laravel starter kits, admin themes, web design, figma, web development, free templates, free admin themes, bootstrap theme, bootstrap template, bootstrap dashboard, bootstrap dak mode, bootstrap button, bootstrap datepicker, bootstrap timepicker, fullcalendar, datatables, flaticon" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta property="og:locale" content="en_US" />
		<meta property="og:type" content="article" />
		<meta property="og:title" content="Metronic - The World's #1 Selling Tailwind CSS & Bootstrap Admin Template by KeenThemes" />
		<meta property="og:url" content="https://keenthemes.com/metronic" />
		<meta property="og:site_name" content="Metronic by Keenthemes" />
		<link rel="canonical" href="http://preview.keenthemes.comindex.html" />
        <link rel="icon" href="{{ asset('assets/images/loanmarket/logos/Logo.png') }}" type="image/x-icon">

		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
		<link href="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @vite('resources/css/app.css')
		<script>// Frame-busting to prevent site from being loaded within a frame without permission (click-jacking) if (window.top != window.self) { window.top.location.replace(window.self.location.href); }</script>

        <style>
            .select2-container .select2-selection--single {
                height: 3rem;
                padding: 6px;
            }

            #update_password_modal input {
                width: 100%;
                height: 45px;
                padding: 12px;
                border-radius: 10px !important;
                border: 1.5px solid lightgrey;
                outline: none;
                transition: all 0.3s cubic-bezier(0.19, 1, 0.22, 1);
                box-shadow: 0px 0px 20px -18px;
                position: relative;
            }

            #update_password_modal input:hover {
                border: 2px solid lightgrey;
                box-shadow: 0px 0px 20px -17px;
            }

            #update_password_modal input:active {
                transform: scale(0.95);
            }
        </style>
    </head>
	<body id="kt_app_body" data-kt-app-layout="dark-sidebar" data-kt-app-header-fixed="true" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" class="app-default">
		<script>
            var defaultThemeMode = "light"; var themeMode;
            if ( document.documentElement ) {
                if ( document.documentElement.hasAttribute("data-bs-theme-mode"))
                    { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); }
                else {
                    if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); }
                    else { themeMode = defaultThemeMode; }
                }
                if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; }
                document.documentElement.setAttribute("data-bs-theme", themeMode);
            }
        </script>

		<div class="d-flex flex-column flex-root app-root" id="kt_app_root">
			<div class="app-page flex-column flex-column-fluid" id="kt_app_page">
				@include('components.admin.header', ['title' => $title ?? ''])
				<div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
                    @include('components.admin.sidebar')
					<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
						<div class="d-flex flex-column flex-column-fluid">
                            <div id="kt_app_content" class="app-content flex-column-fluid">
								<div id="kt_app_content_container" class="app-container container-fluid">
                                    @yield('content')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<script>var hostUrl = "assets/";</script>
		<script src="{{asset('assets/plugins/global/plugins.bundle.js')}}"></script>
		<script src="{{asset('assets/js/scripts.bundle.js')}}"></script>
		<script src="{{asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js')}}"></script>
		<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/map.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/geodata/continentsLow.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/geodata/usaLow.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js"></script>
		<script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
		<script src="{{asset('assets/js/widgets.bundle.js')}}"></script>
		<script src="{{asset('assets/js/custom/widgets.js')}}"></script>
		<script src="{{asset('assets/js/custom/apps/chat/chat.js')}}"></script>
		<script src="{{asset('assets/js/custom/utilities/modals/upgrade-plan.js')}}"></script>
		<script src="{{asset('assets/js/custom/utilities/modals/create-app.js')}}"></script>
		<script src="{{asset('assets/js/custom/utilities/modals/new-target.js')}}"></script>
		<script src="{{asset('assets/js/custom/utilities/modals/users-search.js')}}"></script>
        @stack('scripts')

        <script>
            function logout(){
                Swal.fire({
                    text: 'Are you sure you want to logout?',
                    icon: 'warning',
                    confirmButtonText: 'Yes, Logout',
                    customClass: {
                        confirmButton: 'btn btn-success',
                    },
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "{{ route('admin.logout') }}";
                    }
                });
            }

            document.getElementById('updatePasswordSubmit').addEventListener('click', function () {
                const oldPass = document.getElementById('oldpass').value.trim();
                const newPass = document.getElementById('newpass').value.trim();
                const confirmPass = document.getElementById('confirmpass').value.trim();

                const oldPassError = document.getElementById('oldpass_error');
                const newPassError = document.getElementById('newpass_error');

                let isValid = true;

                // Check Old Password
                if (oldPass === "") {
                    oldPassError.textContent = "Old password is required!";
                    oldPassError.classList.remove('hidden');
                    isValid = false;
                } else {
                    oldPassError.classList.add('hidden');
                }

                // Check New Password Length
                if (newPass === "") {
                    newPassError.textContent = "New password is required!";
                    newPassError.classList.remove('hidden');
                    isValid = false;
                }
                else if (newPass.length < 6) {
                    newPassError.textContent = "New password must be at least 6 characters long!";
                    newPassError.classList.remove('hidden');
                    isValid = false;
                } else {
                    newPassError.classList.add('hidden');
                }

                // Check if Confirm Password matches New Password
                if (newPass !== confirmPass) {
                    newPassError.textContent = "Passwords do not match!";
                    newPassError.classList.remove('hidden');
                    isValid = false;
                }

                if (isValid) {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    fetch("{{ route('admin.password.update', Auth::user()->id) }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                        body: JSON.stringify({
                            old_password: oldPass,
                            new_password: newPass,
                        }),
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                text: 'Password updated successfully!',
                                icon: 'success',
                                confirmButtonText: 'Close',
                                customClass: {
                                    confirmButton: 'btn btn-success',
                                },
                            })
                            .then((result) => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire({
                                text: data.message,
                                icon: 'error',
                                confirmButtonText: 'Close',
                                customClass: {
                                    confirmButton: 'btn btn-danger',
                                },
                            });
                        }
                    });
                }
            });

            document.addEventListener("DOMContentLoaded", function () {
                const modal = document.getElementById('update_password_modal');

                // Listen to the Bootstrap modal close event
                modal.addEventListener('hidden.bs.modal', function () {
                    // Reset form fields
                    document.getElementById('oldpass').value = '';
                    document.getElementById('newpass').value = '';
                    document.getElementById('confirmpass').value = '';

                    // Hide error messages
                    document.getElementById('oldpass_error').classList.add('hidden');
                    document.getElementById('newpass_error').classList.add('hidden');
                });
            });
        </script>
	</body>
</html>
