<div id="kt_app_sidebar" class="app-sidebar flex-column bg-blue" data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
    <div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
        <a href="{{route('admin.dashboard')}}" class="flex items-center gap-3">
            <img alt="Logo" src="{{ asset('assets/images/loanmarket/logos/Logo.png') }}" class="h-50px app-sidebar-logo-default" />
            <span class="app-sidebar-logo-default text-white">YourHomeLoanReview</span>
            <img alt="Logo" src="{{ asset('assets/images/loanmarket/logos/Logo.png') }}" class="h-30px app-sidebar-logo-minimize" />
        </a>
        <div id="kt_app_sidebar_toggle" class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary h-30px w-30px position-absolute top-50 start-100 translate-middle rotate" data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="app-sidebar-minimize">
            <i class="ki-duotone ki-black-left-line fs-3 rotate-180">
                <span class="path1"></span>
                <span class="path2"></span>
            </i>
        </div>
    </div>
    <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
        <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper">
            <div id="kt_app_sidebar_menu_scroll" class="scroll-y my-5 mx-3" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer" data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">
                <div class="menu menu-column menu-rounded menu-sub-indention fw-semibold fs-6" id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
                    <div class="menu-item pt-5">
                        <div class="menu-content">
                            <span class="menu-heading fw-bold text-uppercase fs-7">Menu</span>
                        </div>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link" href="{{route('admin.dashboard')}}">
                            <span class="menu-icon">
                                <i class="ki-duotone ki-abstract-13 fs-2 text-white">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </span>
                            <span class="menu-title">Dashboard</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link" href="{{route('admin.clients')}}">
                            <span class="menu-icon">
                                <i class="ki-duotone ki-abstract-13 fs-2 text-white">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </span>
                            <span class="menu-title">Client Record</span>
                        </a>
                    </div>

                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="ki-duotone ki-abstract-13 fs-2 text-white">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </span>
                            <span class="menu-title">Lender Interest Rates</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div class="menu-sub menu-sub-accordion">
                            <div class="menu-item">
                                <a class="menu-link" href="{{route('admin.lenders.rates')}}">
                                    <i class="fa-solid fa-circle text-white text-[4px] mx-3"></i>
                                    <span class="menu-title">Fixed</span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link" href="{{route('admin.lenders.rates.variable')}}">
                                    <i class="fa-solid fa-circle text-white text-[4px] mx-3"></i>
                                    <span class="menu-title">Variable</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="ki-duotone ki-abstract-13 fs-2 text-white">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </span>
                            <span class="menu-title">Management Module</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div class="menu-sub menu-sub-accordion">
                            <div class="menu-item">
                                <a class="menu-link" href="{{route('admin.ros')}}">
                                    <i class="fa-solid fa-circle text-white text-[4px] mx-3"></i>
                                    <span class="menu-title">Property Managers</span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link" href="{{route('admin.lenders.list')}}">
                                    <i class="fa-solid fa-circle text-white text-[4px] mx-3"></i>
                                    <span class="menu-title">Lenders</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
