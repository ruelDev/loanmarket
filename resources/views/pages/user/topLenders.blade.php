@extends('layouts.pages.topLenders')

@section('content')
<div id="hero-section"
    class="bg-cover bg-no-repeat bg-center h-[25vh] md:h-[30vh]">
    <div class="container relative h-full flex flex-col items-center justify-center gap-5">
        <image src="{{ asset('assets/images/loanmarket/logos/Loan-Market.svg') }}"
                class="absolute top-0 left-5 md:left-0 w-[3rem] md:w-[5rem] xl:w-[7rem]"/>
        @foreach ($data['topLenders']['title'] as $key => $item)
            <h1 class="text-center text-2xl md:text-4xl xl:text-5xl {{ $key != 0 ? "font-bold" : "font-serif"}}">{{$item}}</h1>
        @endforeach
    </div>
    </div>
    <div id="rso-section">
    <div class="container flex justify-center py-20">
        <div class="flex flex-col gap-5 md:w-[70vw] max-w-[700px]">
            @foreach($data['lenders'] as $key => $value)
                <div class="border rounded overflow-hidden cursor-pointer hover:border-black w-[90vw] md:w-auto">
                    <div class="header bg-black h-[60px] ps-5">
                        <image src='{{ asset($value['logo'])}}' style="height: 100%; width: 100px"/>
                    </div>
                    <div class="grid gap-10 md:grid-cols-3 py-3 hover:bg-blue-hover">
                        <div class="text-center">
                            <p class="text-2xl">{{ $value['ratePA'] }}%</p>
                            <p class="text-xs text-black-1">RATE P.A</p>
                            <p class="text-xs text-black-1">FIXED - {{ $value['range'] }}</p>
                        </div>
                        <div class="text-center">
                            <p class="text-2xl">{{ $value['comparisonRatePA'] }}%</p>
                            <p class="text-xs text-black-1">RATE P.A</p>
                            <p class="text-xs text-black-1">COMPARISON**</p>
                        </div>
                        <div class="text-center">
                            <p class="text-2xl">${{ $value['perMonth'] }}</p>
                            <p class="text-xs text-black-1">PER MONTH*</p>
                            <p class="text-xs text-black-1">PRINCIPAL + INTEREST</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
