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
                        <span class="text-white opacity-75 pt-1 fw-semibold fs-6">Property Managers</span>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="grid grid-cols-8 gap-3">
        <div class="col col-span-2">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Top 10 Lenders with higher savings</h5>
                </div>
                <div class="card-body">
                    <div class="flex flex-col gap-3">
                        @foreach($lenderCounts as $key => $lender)
                            <div class="">
                                <div class="pe-3">
                                    <div class="fs-5 fw-semibold mb-2">{{ $key + 1 }}. {{ $lender }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col col-span-6">
            <div class="card">
                <div class="card-header flex justify-between items-center">
                    <h5 class="card-title">Property Management - Clients</h5>
                    <div class="flex items-center">
                        <select id="filter_select" class="form-select form-select-solid my-1 w-[200px]" data-kt-select2="true" data-placeholder="All">
                            <option></option>
                            <option value="7">7 days</option>
                            <option value="14">2 weeks</option>
                            <option value="31">1 month</option>
                            <option value="186">6 months</option>
                            <option value="365">12 months</option>
                        </select>
                    </div>
                </div>
                <div class="card-body pt-2">
                    <table class="table align-middle table-row-dashed fs-6 gy-3" id="kt_table_widget_4_table">
                        <thead>
                            <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                <th class="min-w-100px">Property Management</th>
                                <th class="text-center min-w-100px">No. of Clients</th>
                            </tr>
                        </thead>
                        <tbody class="max-h-[350px] overflow-y-scroll"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        "use strict";
        var table;
        var dt;
        const filterSelect = $('#filter_select');

        dt = $("#kt_table_widget_4_table").DataTable({
            processing: true,
            serverSide: true,
            language: {
                emptyTable: "No data available",
                loadingRecords: "Loading..."
            },
            pageLength: 5,
            lengthChange: false,
            ajax: {
                url: "{{route('admin.dashboard')}}",
                data: function (d) {
                    d.days = filterSelect.value;
                }
            },
            columns: [
                {
                    data: 'rso',
                    render: function (data, type, row) {
                        return data ? data.name : '0';
                    }
                },
                {
                    data: 'count',
                    render: function (data, type, row) {
                        return data ? `<p class="text-center">${data}</p>` : '0';
                    }
                },
            ],
        })

        $(document).ready(function () {
            filterSelect.select2({
                placeholder: "All",
                allowClear: true,
                width: 'resolve',
            });

            filterSelect.on('change', function () {
                dt.ajax.reload();
            });
        });
    </script>
@endpush
