<div id="kt_app_header" class="app-header mb-5" data-kt-sticky="true" data-kt-sticky-activate="{default: true, lg: true}" data-kt-sticky-name="app-header-minimize" data-kt-sticky-offset="{default: '200px', lg: '0'}" data-kt-sticky-animation="false">
    <div class="app-container container-fluid d-flex align-items-stretch justify-content-between" id="kt_app_header_container">
        <div class="d-flex align-items-center d-lg-none ms-n3 me-1 me-md-2" title="Show sidebar menu">
            <div class="btn btn-icon btn-active-color-primary w-35px h-35px" id="kt_app_sidebar_mobile_toggle">
                <i class="ki-duotone ki-abstract-14 fs-2 fs-md-1">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
            </div>
        </div>
        <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
            <a href="{{route('admin.dashboard')}}" class="d-lg-none">
                <img alt="Logo" src="{{asset('assets/images/loanmarket/logos/Loan-Market.svg')}}" class="h-30px" />
            </a>
        </div>
        <div class="d-flex items-center justify-content-between flex-lg-grow-1" id="kt_app_header_wrapper">
            <h3 class="font-bold text-2xl">{{ $title }}</h3>
            <div class="app-navbar flex-shrink-0">
                <div class="app-navbar-item ms-1 ms-md-4" id="kt_header_user_menu_toggle">
                    <div class="cursor-pointer symbol symbol-35px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                        <img src="{{asset('assets/media/avatars/blank.png')}}" class="rounded-3" alt="user" />
                    </div>
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">
                        <div class="menu-item px-3">
                            <div class="menu-content d-flex align-items-center px-3">
                                <div class="symbol symbol-50px me-5">
                                    <img alt="Logo" src="{{asset('assets/media/avatars/blank.png')}}" />
                                </div>
                                <div class="d-flex flex-column">
                                    <div class="fw-bold d-flex align-items-center fs-5">Administrator
                                    </div>
                                    <a href="#" class="fw-semibold text-muted text-hover-primary fs-7">Super Admin</a>
                                </div>
                            </div>
                        </div>
                        <div class="separator my-2"></div>
                        <div class="menu-item px-5">
                            <a data-bs-toggle='modal' data-bs-target="#update_password_modal" class="menu-link px-5">Update Password</a>
                        </div>
                        <div class="menu-item px-5">
                            <a onclick="logout()" class="menu-link px-5">Sign Out</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="update_password_modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <h3 class="my-3 text-xl">Update Password</h3>
                <div class="mb-3">
                    <label class="form-label text-xs text-black" for="oldpass">Old Password:</label>
                    <input class="form-control form-control-sm" id="oldpass" name="oldpass" type="text" placeholder="Old Password">
                    <small class="text-red-500 hidden" id="oldpass_error">Old password is required.</small>
                </div>
                <div class="mb-3">
                    <label class="label text-xs text-black" for="newpass">New Password:</label>
                    <input id="newpass" name="newpass" type="text" placeholder="New Password">
                    <small class="text-red-500 hidden" id="newpass_error">Please input the correct password.</small>
                </div>
                <div class="mb-3">
                    <label class="label text-xs text-black" for="confirmpass">Confirm Password:</label>
                    <input id="confirmpass" name="confirmpass" type="text" placeholder="Confirm Password">
                </div>
                <button type="button" class="bg-gray-100 border border-blue text-black px-5 py-3 rounded" data-bs-dismiss="modal">Close</button>
                <button type="button" class="bg-blue text-white px-5 py-3 rounded" id="updatePasswordSubmit">Update</button>
            </div>
        </div>
    </div>
</div>
