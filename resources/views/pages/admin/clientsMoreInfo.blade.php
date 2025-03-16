@extends('layouts.admin.index')

@section('content')
    @php
        $title = 'Clients';
    @endphp
    <div id="kt_app_content_container" class="container-fluid p-0">
        <div class="card card-flush p-10">
            <div class="d-flex justify-content-end">
                <a href="{{ route('admin.clients') }}" class="rounded px-5 py-2 bg-red-500 text-white-1">Back</a>
            </div>
            <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x mb-5 fs-6">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#kt_tab_pane_4">Client Details</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_5">Lender Details</a>
                </li>
            </ul>

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="kt_tab_pane_4" role="tabpanel">
                    <div class="text-2xl">
                        <p>Name: {{ $client->name }}</p>
                        <p>Email: {{ $client->email }}</p>
                        <p>Phone Number: {{ $client->phone }}</p>
                        <p>Property Management: {{ $client->rso->name }}</p>
                    </div>
                </div>
                <div class="tab-pane fade d-flex flex-col gap-5" id="kt_tab_pane_5" role="tabpanel">
                    @foreach ($client->client_lenders as $lender)
                        <div>
                            <p>Lender Name: {{ $lender->lender }}</p>
                            <p>Loan Type: {{ $lender->loan_type }}</p>
                            @if ($lender->loan_type == 'Fixed')
                                <p>Loan Term: {{ $lender->loan_term }}</p>
                            @endif
                            <p>Loan Rate: {{ $lender->loan_rate }}</p>
                            <p>Monthly Repayment: $ {{ $lender->loan_rate }}</p>
                            <p>Total Savings: $ {{ $lender->savings }}</p>
                        </div>
                    @endforeach
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

        // dt = $("#kt_datatable_example_1").DataTable({
        //     processing: true,
        //     serverSide: true,
        //     ajax: {
        //         url: "{{route('admin.clients')}}",
        //     },
        //     columns: [
        //         {
        //             data: 'property_management',
        //             render: function (data, type, row) {
        //                 console.log('data', data);
        //                 return data ? data.rso_name : 'Your Home Loan Review';
        //             }
        //         },
        //         { data: 'name'},
        //         { data: 'email' },
        //         { data: 'phone' },
        //         {
        //             data: 'date_inquiry',
        //             render: function (data, type, row) {
        //                 return data ? data : '---';
        //             }
        //         },
        //         {
        //             data: 'id',
        //             render: function (data, type, row) {
        //                 return `
        //                     <div class="flex gap-3">
        //                         <button class="btn btn-icon btn-bg-light btn-active-color-success btn-sm" onClick="viewClient(${data})">
        //                             <i class="ki-duotone ki-tablet-text-up fs-2">
        //                                 <span class="path1"></span>
        //                                 <span class="path2"></span>
        //                             </i>
        //                         </button>
        //                     </div>
        //                 `;

        //                 // <button class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm" onClick="deleteClient(${data})">
        //                 //     <i class="ki-duotone ki-trash fs-2">
        //                 //         <span class="path1"></span>
        //                 //         <span class="path2"></span>
        //                 //         <span class="path3"></span>
        //                 //         <span class="path4"></span>
        //                 //         <span class="path5"></span>
        //                 //     </i>
        //                 // </button>
        //             }
        //         }
        //     ],
        // })

        const filterSearch = document.querySelector('[data-kt-docs-table-filter="search"]');
        filterSearch.addEventListener('keyup', function (e) {
            dt.search(e.target.value).draw();
        });

        $(document).ready(function() {
            $('#lender-select').select2({
                placeholder: "Select a lender",
                allowClear: true,
                width: 'resolve',
            });
        });

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

        function viewClient(id) {
            Swal.fire({
                title: 'Under Development',
                text: 'This feature is under development',
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
