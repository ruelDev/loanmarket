@extends('layouts.admin.index')
@php
    $bgColor = ['red', 'blue', 'yellow', 'green'];
@endphp
@section('content')
    <div class="row g-5 gx-xl-10 mb-5 mb-xl-10 row-cols-sm-2 row-cols-md-4 ">
        @foreach ($card as $key => $item)
            <div class="mb-md-5 mb-xl-10">
                <a href="{{route('admin.ros')}}" class="card card-flush bgi-size-contain bgi-position-x-end mb-5 mb-xl-10 h-100 w-100 bg-{{$bgColor[$loop->index]}}-card bg-pattern">
                    <div class="card-header pt-5">
                        <div class="card-title d-flex flex-column">
                            <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{ $item }}</span>
                            <span class="text-white opacity-75 pt-1 fw-semibold fs-6">{{ $key }}</span>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
@endsection
