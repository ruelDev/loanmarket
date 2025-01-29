@extends('layouts.pages.main')

@section('content')
    <div id="hero-section" class="bg-cover bg-no-repeat bg-center h-[50vh]">
        <div class="container relative h-full flex flex-col items-center justify-center gap-5">
            <image src="{{ asset('assets/images/loanmarket/logos/Loan-Market.svg') }}"
                class="absolute top-0 left-5 md:left-0 w-[3rem] md:w-[5rem] xl:w-[7rem]"/>
            @foreach ($data['hero']['title'] as $key => $item)
                <h1 class="text-center text-2xl md:text-4xl xl:text-5xl {{ $key != 0 ? "font-bold" : "font-serif"}}">{{$item}}</h1>
            @endforeach
        </div>
        </div>
        <div id="rso-section">
        <div class="container py-20">
            <div class="grid md:grid-cols-3 xl:grid-cols-4 gap-5 xl:gap-10">
                @foreach($data['ros'] as $key => $item)
                    <div class="item" onclick="window.location.href='{{route('ros', $key)}}'">
                        <div class="relative w-full h-[200px] bg-center bg-cover"
                            style="
                            background-image:
                                linear-gradient(to bottom, #fefefe00, #1d1d1d00),
                                url('{{ asset($item['background']) }}');
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
            <div class="flex items-center justify-center mt-10">
                <button class="bg-blue text-white px-10 py-2 rounded">Load more</button>
            </div>
        </div>
    </div>
@endsection
