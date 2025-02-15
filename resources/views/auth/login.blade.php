<!DOCTYPE html>
<html lang="en">

<head>
    <base href="../../../" />
    <title>YourHomeLoanReview-Login</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" href="{{ asset('assets/images/loanmarket/logos/Logo.png') }}" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />

    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    @vite('resources/css/app.css')
</head>

<body id="kt_body" class="app-blank bgi-size-cover bgi-attachment-fixed bgi-position-center bgi-no-repeat">
    <script>
        var defaultThemeMode = "light";
        var themeMode;
        if (document.documentElement) {
            if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
                themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
            } else {
                if (localStorage.getItem("data-bs-theme") !== null) {
                    themeMode = localStorage.getItem("data-bs-theme");
                } else {
                    themeMode = defaultThemeMode;
                }
            }
            if (themeMode === "system") {
                themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
            }
            document.documentElement.setAttribute("data-bs-theme", themeMode);
        }
    </script>

    <div class="flex items-center justify-center bg-blue h-full" id="kt_app_root">
        <div class="bg-body w-md-400px">
            <div class="flex justify-center px-10 py-10">
                <form method="POST" action="{{ route('login') }}" class="form w-100" novalidate="novalidate"
                    id="kt_sign_up_form" data-kt-redirect-url="/admin">
                    @csrf
                    <div class="flex flex-col items-center justify-center gap-5 mb-5">
                        <!--begin::Title-->
                        <image src="{{ asset('assets/images/loanmarket/logos/Logo.png') }}"
                            class="w-[3rem] md:w-[8rem]" />
                        <h1 class="text-blue-1 text-3xl fw-bolder mb-3">Your Home Loan Review</h1>
                        <!--end::Title-->
                        <!--begin::Subtitle-->
                        <!--end::Subtitle=-->
                    </div>
                    <div class="fv-row mb-8">
                        <input type="text" placeholder="Username" name="name" autocomplete="off"
                            class="form-control bg-transparent" :value="old('name')" required />
                    </div>
                    <div class="fv-row mb-8">
                        <input placeholder="Password" name="password" type="password" autocomplete="off"
                            class="form-control bg-transparent" />
                    </div>
                    <div class="d-grid mb-10">
                        <button type="submit" id="kt_sign_up_submit" class="btn btn-primary">
                            <span class="indicator-label">Login</span>
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        var hostUrl = "assets/";
    </script>
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/custom/authentication/sign-up/general.js') }}"></script>
</body>

</html>
