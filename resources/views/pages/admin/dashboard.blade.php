@extends('layouts.admin.index')
@section('content')
    @php
        $title = 'Dashboard';
    @endphp
    <div class="row g-5 gx-xl-10 mb-5 mb-xl-10 row-cols-sm-2 row-cols-md-4 ">
        <div class="mb-md-5 mb-xl-10">
            <a href="{{route('admin.clients')}}" class="{{"card card-flush bgi-size-contain bgi-position-x-end mb-5 mb-xl-10 h-100 w-100 bg-pattern bg-blue-card"}}">
                <div class="card-header pt-5">
                    <div class="card-title d-flex flex-column">
                        <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{ $clients }}</span>
                        <span class="text-white opacity-75 pt-1 fw-semibold fs-6">Clients</span>
                    </div>
                </div>
            </a>
        </div>
        <div class="mb-md-5 mb-xl-10">
            <a href="{{route('admin.lenders.list')}}" class="{{"card card-flush bgi-size-contain bgi-position-x-end mb-5 mb-xl-10 h-100 w-100 bg-pattern bg-yellow-card"}}">
                <div class="card-header pt-5">
                    <div class="card-title d-flex flex-column">
                        <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{ $lenders }}</span>
                        <span class="text-white opacity-75 pt-1 fw-semibold fs-6">Lenders</span>
                    </div>
                </div>
            </a>
        </div>
        <div class="mb-md-5 mb-xl-10">
            <a href="{{route('admin.ros')}}" class="{{"card card-flush bgi-size-contain bgi-position-x-end mb-5 mb-xl-10 h-100 w-100 bg-pattern bg-green-card"}}">
                <div class="card-header pt-5">
                    <div class="card-title d-flex flex-column">
                        <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{ $ros }}</span>
                        <span class="text-white opacity-75 pt-1 fw-semibold fs-6">Real Estate Offices</span>
                    </div>
                </div>
            </a>
        </div>
        {{-- <div class="mb-md-5 mb-xl-10">
            <a href="{{route('admin.brokers')}}" class="{{"card card-flush bgi-size-contain bgi-position-x-end mb-5 mb-xl-10 h-100 w-100 bg-pattern bg-red-card"}}">
                <div class="card-header pt-5">
                    <div class="card-title d-flex flex-column">
                        <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{ $brokers }}</span>
                        <span class="text-white opacity-75 pt-1 fw-semibold fs-6">Brokers</span>
                    </div>
                </div>
            </a>
        </div> --}}
    </div>
@endsection
