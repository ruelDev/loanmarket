<div class="sticky top-0 md:relative z-50 bg-white w-full shadow-md">
    <div class="container">
        <div class="flex justify-between items-center">
            <a href="{{ route('home') }}">
                <image src="{{ asset('assets/images/loanmarket/logos/Logo.png') }}"
                    class="md:left-0 w-[5rem] xl:w-[7.1rem]"/>
            </a>
            <ul class="items-center justify-between gap-5 hidden sm:flex text-[1.1rem]">
                <li><a href="{{route('home')}}">Home</a></li>
                <li class="cursor-pointer">Real Estate</li>
                <li><a href="#lenders-section">Lenders</a></li>
                <li><a href="#footer">Contact</a></li>
                <li><a href="{{route('home')}}" class="text-blue font-bold">Login</a></li>
            </ul>
            <label id="menu-toggle" class="hamburger sm:hidden z-50">
                <input type="checkbox">
                <svg viewBox="0 0 32 32">
                    <path class="line line-top-bottom" d="M27 10 13 10C10.8 10 9 8.2 9 6 9 3.5 10.8 2 13 2 15.2 2 17 3.8 17 6L17 26C17 28.2 18.8 30 21 30 23.2 30 25 28.2 25 26 25 23.8 23.2 22 21 22L7 22"></path>
                    <path class="line" d="M7 16 27 16"></path>
                </svg>
            </label>
            <div id="backdrop" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden"></div>
            <div id="mobile-nav" class="side-nav-mobile sm:hidden fixed top-0 right-0 h-full w-2/3 bg-white z-40 transform translate-x-full transition-transform duration-300">
                <ul class="flex flex-col items-center justify-between gap-5 py-10">
                    <li><a href="{{route('home')}}">Home</a></li>
                    <li class="cursor-pointer">Real Estate</li>
                    <li><a href="#lenders-section">Lenders</a></li>
                    <li><a href="#footer">Contact</a></li>
                    <li><a href="{{route('home')}}" class="text-blue font-bold">Login</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>


<script>
    // const menuToggle = document.getElementById('menu-toggle');
    // const mobileNav = document.getElementById('mobile-nav');

    // menuToggle.addEventListener('change', () => {
    //   mobileNav.classList.toggle('translate-x-full');
    // });

    const menuToggle = document.querySelector('#menu-toggle input');
    const mobileNav = document.getElementById('mobile-nav');
    const backdrop = document.getElementById('backdrop');
    const navLinks = document.querySelectorAll('.nav-link');

    function closeNav() {
        mobileNav.classList.add('translate-x-full');
        backdrop.classList.add('hidden');
        menuToggle.checked = false;
    }

    menuToggle.addEventListener('change', () => {
        if (menuToggle.checked) {
        mobileNav.classList.remove('translate-x-full');
        backdrop.classList.remove('hidden');
        } else {
        closeNav();
        }
    });

    backdrop.addEventListener('click', closeNav);

    navLinks.forEach(link => {
        link.addEventListener('click', closeNav);
    });
</script>
