@extends('layouts.pages.main')

@section('content')
    <div class="container relative w-full">
        <image src="{{ asset('assets/images/loanmarket/logos/Loan-Market.svg') }}"
            class=" top-0 left-5 md:left-0 w-[3rem] md:w-[5rem] xl:w-[6rem]"/>
    </div>
    <div id="hero-section" class="bg-cover bg-no-repeat bg-center h-[30vh] md:h-[50vh]">
        <div class="container h-full flex flex-col items-center justify-center gap-5">
            @foreach ($data['hero']['title'] as $key => $item)
                <h1 class="text-center text-2xl md:text-4xl xl:text-5xl {{ $key != 0 ? "font-bold" : "font-serif"}}">{{$item}}</h1>
            @endforeach
        </div>
    </div>
    <div id="rso-section">
        <div class="container py-20">
            <h2 class="text-xl md:text-2xl font-bold mb-5 text-blue-1">Real Estate Offices</h2>
            <div class="grid md:grid-cols-3 gap-5 xl:gap-10">
                @foreach($ros as $key => $item)
                    {{-- <div class="item cursor-pointer" onclick="window.location.href='{{route('ros', $key)}}'"> --}}
                    <div class="item cursor-pointer" onclick="window.location.href='{{route('ros', $item['name'])}}'">
                        <div class="relative w-full h-[200px] bg-center bg-cover"
                            style="
                            background-image:
                                linear-gradient(to bottom, #fefefe00, #1d1d1d00),
                                url('{{ asset($item['featured']) }}');
                            ">
                            <image class="absolute w-[80px] h-auto" src="{{ asset($item['logo']) }}"/>
                        </div>
                        <div class="text-center mt-3">
                            <p class="text-xl font-bold text-blue-1 mb-2">{{$item['name']}}</p>
                            <p class="text-blue-1">{{$item['tagline']}}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="divider h-[1px] bg-blue-1 w-[90vw] mx-auto md:hidden"></div>
    <div id="lenders-section" class="slider mt-10">
        <div class="container">
            <div id="default-carousel" class="relative w-full" data-carousel="slide">
                <div class="w-full flex justify-center">
                    <h2 class="text-center  md:text-2xl xl:text-2xl mb-5 text-blue-1 w-[90vw] md:w-[40vw] xl:w-[50vw]">
                        Loan Market brokers can compare over 60 lenders and thousands of home loan products to find the right loan deal for you.
                    </h2>
                </div>
                <div class="relative h-56 overflow-hidden rounded-lg md:h-[800px]">
                    <div class="hidden duration-700 ease-in-out" data-carousel-item>
                        <img src="{{ asset('assets/images/lenders/slider/1.png') }}" class="absolute block h-[100%] -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"/>
                    </div>
                    <div class="hidden duration-700 ease-in-out" data-carousel-item>
                        <img src="{{ asset('assets/images/lenders/slider/2.png') }}" class="absolute block h-[100%] -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"/>
                    </div>
                    <div class="hidden duration-700 ease-in-out" data-carousel-item>
                        <img src="{{ asset('assets/images/lenders/slider/3.png') }}" class="absolute block h-[100%] -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"/>
                    </div>
                    <div class="hidden duration-700 ease-in-out" data-carousel-item>
                        <img src="{{ asset('assets/images/lenders/slider/4.png') }}" class="absolute block h-[100%] -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"/>
                    </div>
                    <div class="hidden duration-700 ease-in-out" data-carousel-item>
                        <img src="{{ asset('assets/images/lenders/slider/5.png') }}" class="absolute block h-[100%] -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"/>
                    </div>
                    <div class="hidden duration-700 ease-in-out" data-carousel-item>
                        <img src="{{ asset('assets/images/lenders/slider/6.png') }}" class="absolute block h-[100%] -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"/>
                    </div>
                </div>

                <!-- Slider indicators -->
                {{-- <div class="absolute z-30 flex -translate-x-1/2 bottom-0 left-1/2 space-x-3 rtl:space-x-reverse">
                    <button type="button" class="w-3 h-3 rounded-full" aria-current="true" aria-label="Slide 1" data-carousel-slide-to="0"></button>
                    <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 2" data-carousel-slide-to="1"></button>
                    <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 3" data-carousel-slide-to="2"></button>
                    <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 4" data-carousel-slide-to="3"></button>
                    <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 5" data-carousel-slide-to="4"></button>
                </div> --}}
                <!-- Slider controls -->
                {{-- <button type="button" class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                        <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                        </svg>
                        <span class="sr-only">Previous</span>
                    </span>
                </button>
                <button type="button" class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                        <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                        </svg>
                        <span class="sr-only">Next</span>
                    </span>
                </button> --}}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
    </script>
@endpush
