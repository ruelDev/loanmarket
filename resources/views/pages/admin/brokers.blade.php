@extends('layouts.admin.index')

@section('content')
    @php
        $title = 'Brokers';
    @endphp
    <div id="kt_app_content_container" class="container-fluid p-0">
        <div class="card card-flush p-10">
            <div class="flex justify-end items-center mb-3 gap-3">
                <div class="d-flex align-items-center position-relative my-1">
                    <i class="ki-duotone ki-magnifier fs-1 position-absolute ms-6"><span class="path1"></span><span class="path2"></span></i>
                    <input type="text" data-kt-docs-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="Search Lenders"/>
                </div>
                <button
                    class="rounded px-5 m-0 bg-green-600 py-3 border-2 border-green-600 text-white"
                    data-bs-toggle="modal"
                    data-bs-target="#broker_create_modal"
                >
                    New Broker
                </button>
            </div>
            <table id="kt_datatable_example_1" class="table align-middle table-row-dashed fs-6 gy-5">
                <thead>
                <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                    <th class="min-w-100px">Name</th>
                    <th class="min-w-100px">Email</th>
                    <th class="min-w-100px">Phone</th>
                    <th class="min-w-200px">RSO</th>
                    <th class="min-w-50px">Action</th>
                </tr>
                </thead>
                <tbody class="text-gray-600 fw-semibold">
                </tbody>
            </table>
        </div>
    </div>

    {{-- ROS Create Modal --}}
    <div class="modal fade" id="broker_create_modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content rounded">
                <div class="modal-header pb-0 border-0 justify-content-end">
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </div>
                </div>
                <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
                    <form id="broker_create_form" class="form" action="#">
                        @csrf
                        <div class="mb-13 text-center">
                            <h1 class="mb-3 font-bold fs-xl">Create Broker</h1>
                        </div>
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span class="required">Name</span>
                            </label>
                            <input type="text" class="form-control form-control-solid" placeholder="Enter name" name="name" />
                        </div>
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span class="required">Email</span>
                            </label>
                            <input type="email" class="form-control form-control-solid" placeholder="Enter email" name="email" />
                        </div>
                        <div class="d-flex flex-column mb-8">
                            <label class="fs-6 fw-semibold mb-2 required">Phone</label>
                            <input type="text" class="form-control form-control-solid" placeholder="Enter phone" name="phone" />
                        </div>
                        <div class="d-flex flex-column mb-8">
                            <label class="fs-6 fw-semibold mb-2 required">Real Estate Office</label>
                            <select name="ros_select[]" aria-label="Select real estate office" data-control="select2" data-placeholder="Select real estate office" class="form-select form-select-solid form-select-lg" multiple></select>
                        </div>
                        <div class="text-center">
                            <button type="reset" id="kt_modal_new_target_cancel" class="btn btn-danger me-3" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" id="kt_modal_new_target_submit" class="btn btn-primary">
                                <span class="indicator-label">Submit</span>
                                <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>
                        <!--end::Actions-->
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- ROS Edit Modal --}}
    <div class="modal fade" data-bs-backdrop="static" id="ros_update_modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content rounded">
                <div class="modal-header pb-0 border-0 justify-content-end">
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </div>
                </div>
                <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
                    <form id="ros_create_form" class="form" action="#">
                        <div class="mb-13 text-center">
                            <h1 class="mb-3 font-bold fs-xl">Edit Real State Office <span id="rosID"></span></h1>
                        </div>
                        <div class="mb-3">
                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span class="required">Logo</span>
                            </label>
                            <!--begin::Image input-->
                            <div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url('{{asset('assets/media/logos/blank-img.jpg')}}')">
                                <!--begin::Preview existing avatar-->
                                <div class="image-input-wrapper w-125px h-125px bgi-position-center" style="background-size: 100%; background-image: url('{{asset('assets/media/logos/blank-img.jpg')}}')"></div>
                                <!--end::Preview existing avatar-->
                                <!--begin::Label-->
                                <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                                    <i class="ki-duotone ki-pencil fs-7">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    <!--begin::Inputs-->
                                    <input type="file" name="avatar" accept=".png, .jpg, .jpeg" />
                                    <input type="hidden" name="avatar_remove" />
                                    <!--end::Inputs-->
                                </label>
                                <!--end::Label-->
                                <!--begin::Cancel-->
                                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
                                    <i class="ki-duotone ki-cross fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </span>
                                <!--end::Cancel-->
                                <!--begin::Remove-->
                                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
                                    <i class="ki-duotone ki-cross fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </span>
                                <!--end::Remove-->
                            </div>
                            <!--end::Image input-->
                            <!--begin::Hint-->
                            <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                            <!--end::Hint-->
                        </div>
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span class="required">Name</span>
                            </label>
                            <input type="text" class="form-control form-control-solid" placeholder="Enter name" name="name" />
                        </div>
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span class="required">Email</span>
                            </label>
                            <input type="text" class="form-control form-control-solid" placeholder="Enter email" name="email" />
                        </div>
                        <div class="d-flex flex-column mb-8">
                            <label class="fs-6 fw-semibold mb-2 required">Tagline</label>
                            <textarea class="form-control form-control-solid" rows="3" name="ros_tagline" placeholder="Enter tagline"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span class="required">Featured Image</span>
                            </label>
                            <!--begin::Image input-->
                            <div class="image-input image-input-outline w-full" data-kt-image-input="true" style="background-image: url('{{asset('assets/media/logos/blank-img.jpg')}}')">
                                <!--begin::Preview existing avatar-->
                                <div class="image-input-wrapper w-100 h-125px bgi-position-center" style="background-size: 100%; background-image: url('{{asset('assets/media/logos/blank-img.jpg')}}')"></div>
                                <!--end::Preview existing avatar-->
                                <!--begin::Label-->
                                <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                                    <i class="ki-duotone ki-pencil fs-7">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    <!--begin::Inputs-->
                                    <input type="file" name="avatar" accept=".png, .jpg, .jpeg" />
                                    <input type="hidden" name="avatar_remove" />
                                    <!--end::Inputs-->
                                </label>
                                <!--end::Label-->
                                <!--begin::Cancel-->
                                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
                                    <i class="ki-duotone ki-cross fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </span>
                                <!--end::Cancel-->
                                <!--begin::Remove-->
                                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
                                    <i class="ki-duotone ki-cross fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </span>
                                <!--end::Remove-->
                            </div>
                            <!--end::Image input-->
                            <!--begin::Hint-->
                            <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                            <!--end::Hint-->
                        </div>
                        <div class="text-center">
                            <button type="reset" id="kt_modal_new_target_cancel" class="btn btn-danger me-3" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" id="kt_modal_new_target_submit" class="btn btn-primary">
                                <span class="indicator-label">Submit</span>
                                <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>
                        <!--end::Actions-->
                    </form>
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

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        dt = $("#kt_datatable_example_1").DataTable({
            processing: true,
            serverSide: true,
            "scrollX": true,
            ajax: {
                url: "{{route('admin.brokers')}}",
            },
            columns: [
                {
                    data: 'name',
                    render: function (data, type, row) {
                        return `<p class="align-top">${data}</p>`;
                    },
                 },
                {
                    data: 'email',
                    render: function (data, type, row) {
                        return `<p class="align-top">${data}</p>`;
                    },
                },
                {
                    data: 'phone',
                    render: function (data, type, row) {
                        return `<p class="align-top">${data}</p>`;
                    },
                },
                {
                    data: 'rso',
                    render: function (data, type, row) {
                        if(data) {
                            const parsedData = JSON.parse(data);
                            const length = parsedData.length;
                            const content = parsedData.map((item, key) => `<span>${item}${key !== length-1 ? ',' : ''}</span>`).join('');
                            return `<div class="flex gap-3">${content}</div>`;
                        } else
                        return `<div class="flex gap-3">N/A</div>`;
                    }
                },
                {
                    data: 'id',
                    render: function (data, type, row) {
                        return `
                            <div class="flex gap-3">
                                <button class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm" onClick="deleteROS(${data})">
                                    <i class="ki-duotone ki-trash fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                        <span class="path5"></span>
                                    </i>
                                </button>
                            </div>
                        `;
                    }
                },
            ],
            columnDefs: [
                { width: "200px", targets: 0 },
                { width: "200px", targets: 1 },
                { width: "200px", targets: 2 },
                { width: "250px", targets: 3},
                { width: "50px", targets: 4},
            ]
        });

        document.querySelector('[data-kt-docs-table-filter="search"]').addEventListener('keyup', function (e) {
            dt.search(e.target.value).draw();
        });

        document.getElementById('broker_create_form').addEventListener('submit', e =>{
            e.preventDefault();

            const formData = new FormData(e.target);

            fetch("{{route('admin.brokers.store')}}", {
                method: 'POST',
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        text: "Broker added successfully!",
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    })
                    .then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        text: data.message || "Something went wrong.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok",
                        customClass: {
                            confirmButton: "btn btn-danger"
                        }
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    text: "An error occurred while submitting the form.",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Ok",
                    customClass: {
                        confirmButton: "btn btn-danger"
                    }
                });
            });
        });

        document.getElementById('broker_create_modal').addEventListener('shown.bs.modal', () => {

            fetch("{{route('admin.utility.ros.option')}}", {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const selectElement = document.querySelector('select[name="ros_select[]"]');
                    selectElement.innerHTML = '';

                    let defaultOption = document.createElement('option');
                    defaultOption.value = '';
                    defaultOption.textContent = 'Select real estate office';
                    selectElement.appendChild(defaultOption);

                    data.options.forEach(option => {
                        console.log(option)
                        let opt = document.createElement('option');
                        opt.value = option.label;
                        opt.textContent = option.label;
                        selectElement.appendChild(opt);
                    });
                }
                else {
                    Swal.fire({
                        text: data.message || "Something went wrong.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok",
                        customClass: {
                            confirmButton: "btn btn-danger"
                        }
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    text: "An error occurred while submitting the form.",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Ok",
                    customClass: {
                        confirmButton: "btn btn-danger"
                    }
                });
            });

        });

        document.getElementById('broker_create_modal').addEventListener('hide.bs.modal', () => {
            const selectElement = document.querySelector('select[name="ros_select"]');
            selectElement.innerHTML = '';
        });

        const updateROSStatus = (id) => {
            Swal.fire({
                text: "Are you sure you want to update the status of this office?",
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
        }

        const deleteROS = (id) => {

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            Swal.fire({
                text: "Are you sure you want to delete this broker?",
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
            .then(response => {
                fetch("{{route('admin.brokers.delete')}}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken, // Include CSRF token
                        'X-Requested-With': 'XMLHttpRequest', // For AJAX request
                    },
                    body: JSON.stringify({ id: id })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            text: "Broker deleted successfully!",
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        })
                        .then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            text: data.message || "Something went wrong.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok",
                            customClass: {
                                confirmButton: "btn btn-danger"
                            }
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        text: "An error occurred while submitting the form.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok",
                        customClass: {
                            confirmButton: "btn btn-danger"
                        }
                    });
                });
            })
        }

        const updateROS = (id) => {
            $('#ros_update_modal').modal('show');
        }

    </script>
@endpush
