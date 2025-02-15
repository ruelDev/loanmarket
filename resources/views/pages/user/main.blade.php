@extends('layouts.pages.main')

@section('content')
    <div id="hero-section" class="bg-cover bg-no-repeat bg-center h-[30vh] md:h-[50vh]">
        <div class="container h-full flex flex-col items-center justify-center gap-5">
            @foreach ($data['hero']['title'] as $key => $item)
                <h1 class="text-center text-2xl md:text-6xl text-white {{ $key != 0 ? "font-bold" : "font-poppins"}} animate-hero-title"
                    style="animation-delay: {{$key * 0.3}}s;">
                    {{$item}}
                </h1>
            @endforeach
        </div>
    </div>
    <section id="rso-section">
        <div class="container py-20">
            <h2 class="text-xl md:text-3xl font-bold mb-5 text-blue-1">Property Management</h2>
            <div class="grid md:grid-cols-2 gap-5 md:gap-10">
                @foreach($ros as $key => $item)
                    <div class="p-5 animate-card">
                        <div class="item cursor-pointer rso-card rounded overflow-hidden {{ $key % 2 == 0 ? 'animate-slide-left -translate-x-1/2' : 'animate-slide-right translate-x-1/2' }}"
                            onclick="window.location.href='{{route('rso', $item['name'])}}'"
                            style="animation-delay: {{ $key * 0.3 }}s;">
                            <div class="relative w-full h-[300px] bg-center bg-cover flex items-center justify-center"
                                style="
                                background-image:
                                    linear-gradient(to bottom, #fefefe00, #1d1d1dbc),
                                    url('{{ asset($item['featured']) }}');
                                ">
                                <image class="absolute w-[50px] md:w-[80px] h-auto top-0 left-5" src="{{ asset($item['logo']) }}"/>
                                <div class="text-center mt-3">
                                    <p class="text-2xl md:text-3xl font-bold text-white mb-2">{{$item['name']}}</p>
                                    <p class="text-xl text-white">{{$item['tagline']}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <div class="divider h-[1px] bg-blue-1 w-[90vw] mx-auto md:hidden"></div>
    @include('components.lenders')
    <section id="find-the-right-loan-section">
        <div class="container mb-5">
            <div class="card p-5 md:p-10">
                <div class="grid grid-cols-5 gap-10 md:gap-0">
                    <div class="col-span-5 md:col-span-3 md:p-3 flex items-center">
                        <div>
                            <h3 class="text-xl md:text-3xl">Find The Right Loan For You:</h3>
                            <div>
                                <p class="text-[1.01rem] mt-5">Types of Home Loans:</p>
                                <ul class="mt-5">
                                    <li class="text-[1.01rem] flex align-items-top gap-3">
                                        <div class="mt-[5px] md:pt-[1px] w-[1.9rem] xl:w-[16px]">
                                            <img class="w-full" src="{{ asset('assets/images/loanmarket/rightLoanIcons/2.png') }}"/>
                                        </div><div>Variable Rate Loan - Interest rate changes with the marke, offering flexibility and potential savings.</div></li>
                                    <li class="text-[1.01rem] flex align-items-top gap-3">
                                        <div class="mt-[5px] md:pt-[1px] w-[1.9rem] xl:w-[16px]">
                                            <img class="w-full" src="{{ asset('assets/images/loanmarket/rightLoanIcons/2.png') }}"/>
                                        </div>Fixed Rate Loan - Lock in your interest rate for 1-5 years for repayment certainty.</li>
                                    <li class="text-[1.01rem] flex align-items-top gap-3">
                                        <div class="mt-[5px] md:pt-[1px] w-[1.9rem] xl:w-[16px]">
                                            <img class="w-full" src="{{ asset('assets/images/loanmarket/rightLoanIcons/2.png') }}"/>
                                        </div>Split Loan - Combine fixed and variable rates for balance and flexibility.</li>
                                    <li class="text-[1.01rem] flex align-items-top gap-3">
                                        <div class="mt-[5px] md:pt-[1px] w-[1.9rem] xl:w-[16px]">
                                            <img class="w-full" src="{{ asset('assets/images/loanmarket/rightLoanIcons/2.png') }}"/>
                                        </div>Interest-Only Loan - Lower repayments for a set period, ideal for investors. </li>
                                    <li class="text-[1.01rem] flex align-items-top gap-3">
                                        <div class="mt-[5px] md:pt-[1px] w-[1.9rem] xl:w-[16px]">
                                            <img class="w-full" src="{{ asset('assets/images/loanmarket/rightLoanIcons/2.png') }}"/>
                                        </div>Principal & Interest Loan - Repay both the loan amount and interest over time.</li>
                                </ul>
                            </div>
                            <div>
                                <p class="text-[1.01rem] mt-5">Key Home Loan Features:</p>
                                <ul class="mt-5">
                                    <li class="text-[1.01rem] flex align-items-top gap-3">
                                        <div class="mt-[5px] md:mt-[3px]  w-[1.9rem] xl:w-[16px]">
                                            <img class="w-full" src="{{ asset('assets/images/loanmarket/rightLoanIcons/3.png') }}"/>
                                        </div>Offset Account - Reduce interest by linking a savings account to your loan.</li>
                                    <li class="text-[1.01rem] flex align-items-top gap-3">
                                        <div class="mt-[5px] md:mt-[3px]  w-[1.9rem] xl:w-[16px]">
                                            <img class="w-full" src="{{ asset('assets/images/loanmarket/rightLoanIcons/4.png') }}"/>
                                        </div>Redraw Facility - Access estra repayments when needed.</li>
                                    <li class="text-[1.01rem] flex align-items-top gap-3">
                                        <div class="mt-[5px] md:mt-[3px]  w-[1.9rem] xl:w-[16px]">
                                            <img class="w-full" src="{{ asset('assets/images/loanmarket/rightLoanIcons/5.png') }}"/>
                                        </div>Extra Repayments - Pay off your loan faster and save on interest.</li>
                                    <li class="text-[1.01rem] flex align-items-top gap-3">
                                        <div class="mt-[5px] md:mt-[3px]  w-[1.9rem] xl:w-[16px]">
                                            <img class="w-full" src="{{ asset('assets/images/loanmarket/rightLoanIcons/6.png') }}"/>
                                        </div>Package Loans - Bundle with a credit card or bank account for discounts.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-5 md:col-span-2">
                        <div class="rounded overflow-hidden">
                            <img src="{{asset('assets/images/loanmarket/featured1.webp')}}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="why-review-loan-section">
        <div class="container mb-10">
            <div class="card p-10 bg-blue">
                <div class="grid grid-cols-2 md:grid-cols-6">
                    <div class="col-span-2">
                        <h3 class="text-3xl text-white mb-10 md:mb-0">
                            Why Review Your Home Loan?
                        </h3>
                    </div>
                    <div class="col-span-2">
                        <div class="flex flex-col gap-3 mb-10">
                            <img src="{{asset('assets/images/loanmarket/svg/perscent.svg')}}" width="50px"/>
                            <h4 class="text-white text-xl md:w-2/3">Save Money</h4>
                            <p class="text-white text-[.9rem] md:w-2/3">Interest rates change! A better deal could save you thousands.</p>
                        </div>
                        <div class="flex flex-col gap-3 mb-10">
                            <img src="{{asset('assets/images/loanmarket/svg/diffShape.svg')}}" width="50px"/>
                            <h4 class="text-white text-xl md:w-2/3">Stay on Track</h4>
                            <p class="text-white text-[.9rem] md:w-2/3"> Life changes - make sure your loan still fits your goals.</p>
                        </div>
                    </div>
                    <div class="col-span-2">
                        <div class="flex flex-col gap-3 mb-10">
                            <img src="{{asset('assets/images/loanmarket/svg/turnaroundtime.svg')}}" width="50px"/>
                            <h4 class="text-white text-xl md:w-2/3">Cut Unnecessary Fees</h4>
                            <p class="text-white text-[.9rem] md:w-2/3">Spot hidden charges and refinance smarter.</p>
                        </div>
                        <div class="flex flex-col gap-3 mb-10">
                            <img src="{{asset('assets/images/loanmarket/svg/mobile.svg')}}" width="50px"/>
                            <h4 class="text-white text-xl md:w-2/3">Unlock Your Equity</h4>
                            <p class="text-white text-[.9rem] md:w-2/3">Use your home's value to invest, renovate, or reduce debt.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
    </script>
@endpush
