@extends('layouts.pages.topLenders')

@section('content')
    <div class="container">
        <image src="{{ asset('assets/images/loanmarket/logos/Loan-Market.svg') }}"
                    class="w-[3rem] md:w-[5rem] xl:w-[7rem] md:hidden"/>
    </div>
    <div id="hero-section"
        class="bg-cover bg-no-repeat bg-center">
        <div class="container relative h-[15vh] md:h-[30vh] flex flex-col items-center justify-center gap-5">
            <image src="{{ asset('assets/images/loanmarket/logos/Loan-Market.svg') }}"
                    class="absolute top-0 left-5 md:left-0 w-[3rem] md:w-[5rem] xl:w-[7rem] hidden md:block"/>
            @foreach ($data['topLenders']['title'] as $key => $item)
                <h1 class="text-center text-2xl md:text-4xl xl:text-5xl {{ $key != 0 ? "font-bold" : "font-serif"}}">{{$item}}</h1>
            @endforeach
        </div>
    </div>
    </div>
    <div id="rso-section">
        <div class="container py-20">
        <div class="flex justify-center">
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
        <div class="flex justify-center mt-5">
            <button id="send-email" class="bg-blue px-10 py-5 rounded text-white">Request a call form your Property Manager</button>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.getElementById('send-email').addEventListener('click', function(){
            Swal.fire({
                text: "Are you sure you want to request a call?",
                icon: "warning",
                buttonsStyling: false,
                confirmButtonText: "Yes, Proceed",
                showCancelButton: true,
                cancelButtonText: 'No, Cancel',
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: 'btn btn-danger'
                }
            })
            .then((result) => {
                if (result.isConfirmed) {
                    fetch("{{route('request.email')}}", {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Content-Type': 'application/json',
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        Swal.fire({
                            text: "Your request has been submitted successfully.",
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, Got it!",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        });
                    })
                    .catch(error => {
                        Swal.fire({
                            text: "An error occurred while requesting call.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok",
                            customClass: {
                                confirmButton: "btn btn-danger"
                            }
                        });
                    });
                }
            })

        });
    </script>
@endpush
