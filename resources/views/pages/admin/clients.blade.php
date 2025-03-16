@extends('layouts.admin.index')

@section('content')
    @php
        $title = 'Clients';
    @endphp
    <div id="kt_app_content_container" class="container-fluid p-0">
        <div class="card card-flush p-10">
            <div class="flex justify-between mb-3">
                <select id="lender-select" class="form-select form-select-solid my-1 w-[300px]" data-kt-select2="true" data-placeholder="Filter by Property Management">
                    <option></option>
                    <option value="yhlr">Your Home Loan Review</option>
                    @foreach ($rso as $office)
                        <option value="{{ $office->id }}">{{ $office->name }}</option>
                    @endforeach
                </select>
                <div class="d-flex align-items-center position-relative my-1">
                    <i class="ki-duotone ki-magnifier fs-1 position-absolute ms-6"><span class="path1"></span><span class="path2"></span></i>
                    <input type="text" data-kt-docs-table-filter="search" class="form-control form-control-solid w-250px ps-15 py-3" placeholder="Search Visitors"/>
                </div>
            </div>
            <table id="kt_datatable_example_1" class="table align-middle table-row-dashed fs-6 gy-5">
                <thead>
                <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                    <th>Property Management</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Date Inquiry</th>
                    <th>Action</th>
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
        const filterSearch = document.querySelector('[data-kt-docs-table-filter="search"]');
        const lenderSelect = $('#lender-select');

        dt = $("#kt_datatable_example_1").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{route('admin.clients')}}",
                data: function (d) {
                    d.search = filterSearch.value;
                    d.lender = lenderSelect.val(); // Send lender filter value
                }
            },
            columns: [
                {
                    data: 'rso',
                    render: function (data, type, row) {
                        console.log('data', data);
                        return data ? data.rso_name : 'Your Home Loan Review';
                    }
                },
                { data: 'name'},
                { data: 'email' },
                { data: 'phone' },
                {
                    data: 'date_inquiry',
                    render: function (data, type, row) {
                        return data ? data : '---';
                    }
                },
                {
                    data: 'id',
                    render: function (data, type, row) {
                        return `
                            <div class="flex gap-3">
                                <a href="/admin/clients/${data}" class="btn btn-icon btn-bg-light btn-active-color-success btn-sm">
                                    <i class="ki-duotone ki-tablet-text-up fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </a>
                            </div>
                        `;

                        // <button class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm" onClick="deleteClient(${data})">
                        //     <i class="ki-duotone ki-trash fs-2">
                        //         <span class="path1"></span>
                        //         <span class="path2"></span>
                        //         <span class="path3"></span>
                        //         <span class="path4"></span>
                        //         <span class="path5"></span>
                        //     </i>
                        // </button>
                    }
                }
            ],
        })

        // filterSearch.addEventListener('keyup', function (e) {
        //     dt.search(e.target.value).draw();
        // });

        // Search input event
        filterSearch.addEventListener('keyup', function (e) {
            dt.ajax.reload();
        });

        // Lender dropdown filter
        $(document).ready(function () {
            lenderSelect.select2({
                placeholder: "Select a lender",
                allowClear: true,
                width: 'resolve',
            });

            lenderSelect.on('change', function () {
                dt.ajax.reload(); // Reload with the new filter applied
            });
        });

        // $(document).ready(function() {
        //     $('#lender-select').select2({
        //         placeholder: "Select a lender",
        //         allowClear: true,
        //         width: 'resolve',
        //     });

            // $('#lender-select').on('change', function (e) {
            //     $.ajax({
            //         url: "{{route('admin.clients')}}",
            //         type: 'GET',
            //         data: {
            //             filter: e.target.value
            //         },
            //         success: function (data) {
            //             dt.clear().draw();
            //             dt.rows.add(data.data).draw();
            //         }
            //     });
            // });
        // });

        function deleteClient(id) {
            Swal.fire({
                title: 'Under Development',
                text: `This feature is under development ${id}`,
                icon: 'info',
                confirmButtonText: 'Okay, got it!',
                customClass: {
                    confirmButton: 'btn btn-primary',
                },
                buttonsStyling: false
            })
        }
    </script>
@endpush
