@extends('layouts.pages.ros')

@section('content')
    <div class="container relative">
        <image
            class="absolute top-0 left-5 md:left-0 w-[3rem] md:w-[5rem] xl:w-[7rem]"
            src="{{ asset($data['logo']) }}"
            />
        <div class="grid md:grid-cols-2 min-h-screen">
            <div class="flex flex-col justify-center items-center md:items-start mt-20 md:mt-0">
                <h2 class="text-white text-center md:text-start text-xl xl:text-3xl">{{$data['name']}}</h2>
                <div class="bg-yellow-raywhite w-[2rem] h-[3px] md:w-[4rem] md:h-[4px] mb-3 md:mb-5" style="display:block;"></div>
                <h1 class="text-white text-center md:text-start text-2xl md:text-4xl xl:text-5xl font-bold">
                    {{$data['tagline']}}
                </h1>
            </div>
            <div class="flex items-center">
                <div class="bg-white p-5 h-min mx-auto rounded" style="width: 80%">
                    <form>
                        <x-bladewind::input
                            required="true"
                            label="Property Address"
                            onfocus="changeCss('.events', '!border-2,!border-red-400')"
                            onblur="changeCss('.events', '!border-2,!border-red-400', 'remove')"
                        />
                        <x-bladewind::input
                            required="true"
                            label="Property Value"
                            numeric="true"
                            onfocus="changeCss('.events', '!border-2,!border-red-400')"
                            onblur="changeCss('.events', '!border-2,!border-red-400', 'remove')"
                        />
                        <x-bladewind::input
                            required="true"
                            label="Loan Amount"
                            numeric="true"
                            onfocus="changeCss('.events', '!border-2,!border-red-400')"
                            onblur="changeCss('.events', '!border-2,!border-red-400', 'remove')"
                        />
                        <x-bladewind::input
                            required="true"
                            label="Interest Rate"
                            numeric="true"
                            onfocus="changeCss('.events', '!border-2,!border-red-400')"
                            onblur="changeCss('.events', '!border-2,!border-red-400', 'remove')"
                        />
                        <x-bladewind::select
                            name="typeOfInterest"
                            required="true"
                            :data="[
                                [ 'label' => 'Fixed', 'value' => 'fixed' ],
                                [ 'label' => 'Variable', 'value' => 'variable' ]
                            ]"
                            label="Type of Interest"
                        />
                        <x-bladewind::button
                            class="bg-blue text-white w-full sm:w-auto"
                            onclick="showModal('userDetails')">
                            CALCULATE SAVINGS
                        </x-bladewind::button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <x-bladewind::modal
        name="userDetails"
        title="User Details"
        blur_size="small"
        size="medium"
        backdrop_can_close="false"
        show_action_buttons="false">
        <form
            method="get"
            action=""
            class="profile-form-simple"
            onsubmit="return saveProfileSimple()"
        >
            @csrf
            <div class="grid grid-cols-2 gap-4 mt-6">
                <x-bladewind::input required="true" name="first_name3"
                    label="First name" error_message="Please enter your first name" />
                <x-bladewind::input required="true" name="last_name3"
                    label="Last name" error_message="Please enter your last name" />
            </div>
            <x-bladewind::input numeric="true" required="true" name="mobile3"
                    label="Mobile" />
            <x-bladewind::button can_submit="true" class="w-full mt-2">
                Proceed
            </x-bladewind::button>
        </form>
    </x-bladewind::modal>
@endsection

@push('scripts')
    <script>
        saveProfileSimple = () => {
            if(validateForm('.profile-form-simple')){
                return domEl('.profile-form-simple').submit();
            }
            return false;
        }
    </script>
@endpush
