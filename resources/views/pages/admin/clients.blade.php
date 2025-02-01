@extends('layouts.admin.index')

@section('content')
    @php
        $title = 'Clients';
    @endphp
    <div id="kt_app_content_container" class="container-fluid p-0">
        <div class="card card-flush p-10">
            <div class="flex justify-end mb-3">
                <div class="d-flex align-items-center position-relative my-1">
                    <i class="ki-duotone ki-magnifier fs-1 position-absolute ms-6"><span class="path1"></span><span class="path2"></span></i>
                    <input type="text" data-kt-docs-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="Search Visitors"/>
                </div>
            </div>
            <table id="kt_datatable_example_1" class="table align-middle table-row-dashed fs-6 gy-5">
                <thead>
                <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Broker</th>
                </tr>
                </thead>
                <tbody class="text-gray-600 fw-semibold">
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        "use strict";
        var table;
        var dt;

        dt = $("#kt_datatable_example_1").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{route('admin.clients')}}",
            },
            columns: [
                { data: 'name'},
                { data: 'email' },
                { data: 'phone' },
                { data: 'broker.name' },
            ],
        })

        const filterSearch = document.querySelector('[data-kt-docs-table-filter="search"]');
        filterSearch.addEventListener('keyup', function (e) {
            dt.search(e.target.value).draw();
        });

    </script>
@endpush
