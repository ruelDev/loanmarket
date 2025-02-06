@extends('layouts.pages.main')

@section('content')
    <div id="hero-section" class="bg-cover bg-no-repeat bg-center h-[30vh] md:h-[50vh]">
        <div class="container h-full flex flex-col items-center justify-center gap-5">
            @foreach ($data['hero']['title'] as $key => $item)
                <h1 class="text-center text-2xl md:text-6xl text-white {{ $key != 0 ? "font-bold" : "font-serif"}}">{{$item}}</h1>
            @endforeach
        </div>
    </div>
    <section id="rso-section">
        <div class="container py-20">
            <h2 class="text-xl md:text-3xl font-bold mb-5 text-blue-1">Real Estate Offices</h2>
            <div class="grid md:grid-cols-2 gap-5 md:gap-10">
                @foreach($ros as $key => $item)
                    <div class="p-5">
                        <div class="item cursor-pointer rso-card rounded overflow-hidden" onclick="window.location.href='{{route('calculator')}}'">
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
    <section>
        <div class="container mb-5">
            <div class="card p-5 md:p-10">
                <div class="grid grid-cols-5 gap-10 md:gap-0">
                    <div class="col-span-5 md:col-span-3 md:p-3 flex items-center">
                        <div>
                            <h3 class="text-3xl">Home loan products and features</h3>
                            <p class="text-[1.01rem] mt-5">Lorem ipsum dolor sit amet consectetur adipisicing elit. Iure ex quae itaque! Id architecto reiciendis ipsam ex optio non beatae temporibus tenetur, recusandae cumque, ea magnam est praesentium reprehenderit, nemo iure. Quidem nemo corporis recusandae!</p>
                            <ul class="mt-5">
                                <li class="text-[1.01rem] flex align-items-center gap-3"><i class="fa-solid fa-circle text-[5px]"></i>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eius, quo?</li>
                                <li class="text-[1.01rem] flex align-items-center gap-3"><i class="fa-solid fa-circle text-[5px]"></i> Lorem ipsum dolor sit amet consectetur.</li>
                                <li class="text-[1.01rem] flex align-items-center gap-3"><i class="fa-solid fa-circle text-[5px]"></i> Lorem ipsum dolor sit, amet consectetur adipisicing elit. Distinctio totam velit soluta.</li>
                            </ul>
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
    <section>
        <div class="container mb-10">
            <div class="card p-10 bg-blue">
                <div class="grid grid-cols-2 md:grid-cols-6">
                    <div class="col-span-2">
                        <h3 class="text-3xl text-white mb-10 md:mb-0">
                            Why Company?
                        </h3>
                    </div>
                    <div class="col-span-2">
                        <div class="flex flex-col gap-3 mb-10">
                            <img src="{{asset('assets/images/loanmarket/svg/perscent.svg')}}" width="50px"/>
                            <h4 class="text-white text-xl md:w-2/3">Settle for nothing less than great rates and low fees.</h4>
                            <p class="text-white text-[.9rem] md:w-2/3">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dicta, quis?</p>
                        </div>
                        <div class="flex flex-col gap-3 mb-10">
                            <img src="{{asset('assets/images/loanmarket/svg/diffShape.svg')}}" width="50px"/>
                            <h4 class="text-white text-xl md:w-2/3">When it comes to your home loan, we’re flexible.</h4>
                            <p class="text-white text-[.9rem] md:w-2/3">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dicta, quis?</p>
                        </div>
                    </div>
                    <div class="col-span-2">
                        <div class="flex flex-col gap-3 mb-10">
                            <img src="{{asset('assets/images/loanmarket/svg/turnaroundtime.svg')}}" width="50px"/>
                            <h4 class="text-white text-xl md:w-2/3">Turnaround times that won’t leave you wondering.</h4>
                            <p class="text-white text-[.9rem] md:w-2/3">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dicta, quis?</p>
                        </div>
                        <div class="flex flex-col gap-3 mb-10">
                            <img src="{{asset('assets/images/loanmarket/svg/mobile.svg')}}" width="50px"/>
                            <h4 class="text-white text-xl md:w-2/3">An award-winning digital app.</h4>
                            <p class="text-white text-[.9rem] md:w-2/3">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dicta, quis?</p>
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
