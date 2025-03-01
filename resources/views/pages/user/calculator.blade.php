@extends('layouts.pages.main')

@section('content')
    <div class="bg-cover bg-no-repeat bg-center h-[20vh] lg:h-[40vh]"
        style="background-image:
                        linear-gradient(to bottom, #3d3d3d6f, #1d1d1dae),
                        /* linear-gradient(to bottom, #E5F7FD, #e5f7fd), */
                        url('{{asset($rso['featured'])}}');
                        color: #fefefe;">
        <div class="container h-full flex items-center justify-center gap-5">
            <h1 class="text-center text-white text-2xl md:text-6xl font-bold animate-hero-title flex items-center" style="animation-delay: {{1 * 0.3}}s;">
                <img src="{{asset($rso['logo'])}}" class="me-3 w-[2rem] md:w-[3rem]" height="100%" /> {{ $rso['name'] }}
            </h1>
        </div>
    </div>
    <div id="calculator-section" class="bg-white-3">
        <div class="container py-10">
            <div class="container">
                <div class="card bg-white rounded-md p-5 p-sm-10 p-md-5">
                    <div class="grid gap-4 grid-cols-1 lg:grid-cols-6">
                        <div class="col-span-6 lg:col-span-2">
                            <div class="flex flex-col justify-between h-full">
                                <div>
                                    <h3 class="text-2xl mb-5 text-black">Calculate Your Own Savings</h3>
                                    <div class="calc-form flex flex-col gap-3">
                                        <div class="calc-input flex flex-col gap-1">
                                            <label class="label text-xs text-black" for="property_address">Property Address</label>
                                            <input id="property_address" name="property_ddress" type="text" placeholder="Address">
                                            <small class="text-red-500 hidden" id="property_address_error">Please enter a valid address.</small>
                                        </div>
                                        <div class="calc-input flex flex-col gap-1">
                                            <label class="label text-xs text-black" for="property_value">Property Value ($)</label>
                                            <input id="property_value" class="input-style" name="text" type="number" placeholder="Value" min="0" value="500000">
                                            <small class="text-red-500 hidden" id="property_value_error">Please enter a valid value.</small>
                                        </div>
                                        <div class="calc-input flex flex-col gap-1">
                                            <label class="label text-xs text-black" for="loan_amount">Loan Amount ($)</label>
                                            <input id="loan_amount" class="" name="text" type="number" placeholder="Amount" min="0" value="300000">
                                            <small class="text-red-500 hidden" id="loan_amount_error">Please enter a valid amount.</small>
                                        </div>
                                        <div class="calc-input flex flex-col gap-1">
                                            <label class="label text-xs text-black" for="loan_purpose">Loan Purpose</label>
                                            <div class="radio-inputs">
                                                <label class="radio">
                                                  <input type="radio" name="loan_purpose" value="OWNER_OCCUPIED" id="loan-purpose-owner-occupied" checked=""/>
                                                  <span class="name">Owner Occupied</span>
                                                </label>
                                                <label class="radio">
                                                  <input type="radio" name="loan_purpose" value="INVESTMENT" id="loan-purpose-investment"/>
                                                  <span class="name">Investment</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="calc-input flex flex-col gap-1">
                                            <label class="label text-xs text-black" for="loan-type">Loan Type</label>
                                            <div class="radio-inputs">
                                                <label class="radio">
                                                  <input type="radio" name="loan_type" value="FIXED" id="loan-type-fixed" checked=""  onchange="toggleLoanTerm()"/>
                                                  <span class="name">Fixed</span>
                                                </label>
                                                <label class="radio">
                                                  <input type="radio" name="loan_type" value="VARIABLE" id="loan-type-variable" onchange="toggleLoanTerm()"/>
                                                  <span class="name">Variable</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="calc-input flex flex-col gap-1" id="loan-term-container">
                                            <label class="label text-xs text-black" for="loan_term">Fixed Term</label>
                                            <select id="loan_term" class="" name="text" type="text" placeholder="Term">
                                                <option value="1">1 Year</option>
                                                <option value="2">2 Years</option>
                                                <option value="3">3 Years</option>
                                                <option value="4">4 Years</option>
                                                <option value="5" selected>5 Years</option>
                                            </select>
                                        </div>
                                        <div class="calc-input flex flex-col gap-1">
                                            <label class="label text-xs text-black" for="client_rate">Interest Rate (%)</label>
                                            <input id="client_rate" class="input-style" name ="client_rate" type="number" placeholder="Current interest rate" min="0" value="6.5">
                                            <small class="text-red-500 hidden" id="property_value_error">Please enter a valid value.</small>
                                        </div>
                                        <div class="calc-input flex flex-col gap-1" id="loan-term-container">
                                            <label class="label text-xs text-black" for="client_term">Remaning Loan Term</label>
                                            <select id="client_term" class="" name="client_term" placeholder="Term">
                                                @for ($option = 1; $option <= 30; $option++)
                                                    <option value="{{$option}}" {{ $option == 30 ? "Selected" : ""}}>{{$option}} {{ $option == 1 ? 'Year' : 'Years'}}</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <button id="calculate-btn" class="bg-blue text-white w-[200px] py-3 rounded-lg">Calculate Savings</button>
                                    </div>
                                </div>
                                <p class="text-[1rem] my-10 mb-md-0 mt-md-10 underline cursor-pointer"
                                    data-bs-toggle="modal"
                                    data-bs-target="#how_calc_works_modal"
                                >How did we do the computations?</p>
                            </div>
                        </div>
                        <div class="col-span-6 lg:col-span-4">
                            <div class="bg-white-3 border p-5 rounded">
                                <div class="hidden md:flex justify-between items-center">
                                    <h4 class="text-xl calc-title">Top 3 Lenders</h4>
                                    <button class="text-blue text-[1.1rem] text-decoration-underline requestCallBtn hidden" onclick="requestCall()">Request a call from your {{ $rso['call_to'] == null ? 'Review Partner' : $rso['call_to'] }}</button>
                                    <p class="text-blue text-[1.1rem] requestCallBtnPw  hidden">Please wait...</p>
                                </div>
                                <div class="flex justify-center items-center md:hidden">
                                    <h4 class="text-2xl font-bold calc-title">Top 3 Lenders</h4>
                                </div>
                                <section class="dots-container hidden mt-10">
                                    <div class="dot"></div>
                                    <div class="dot"></div>
                                    <div class="dot"></div>
                                    <div class="dot"></div>
                                    <div class="dot"></div>
                                </section>
                                <div class="flex justify-center mt-10">
                                    <div class="flex flex-col gap-5 w-full h-[600px] overflow-y-scroll" id="top-3-container">
                                        @foreach($data['lenders'] as $item)
                                         @foreach ($item as $key => $value)
                                            <div class="border rounded overflow-hidden cursor-pointer hover:border-black w-auto">
                                                <div class="header bg-black h-[60px] ps-5">
                                                    <image src='{{ asset($value['logo'])}}' style="height: 100%; width: 100px"/>
                                                </div>
                                                <div class="grid gap-10 md:grid-cols-4 py-3 hover:bg-blue-hover">
                                                    <div class="text-center">
                                                        <div class="text-2xl flex items-center justify-center gap-2">
                                                            <p>{{ $value['ratePA'] }}</p>
                                                            <div class="flex flex-col"><span class="text-[10px] leading-none">%</span><span class="text-[10px] leading-none">p.a.</span></div>
                                                        </div>
                                                        <p class="text-xs text-black-1">Fixed rate</p>
                                                        <p class="text-xs text-black-1">for 5 years</p>
                                                    </div>
                                                    <div class="text-center">
                                                        <div class="text-2xl flex items-center justify-center gap-2">
                                                            <p>{{ $value['comparisonRatePA'] }}</p>
                                                            <div class="flex flex-col"><span class="text-[10px] leading-none">%</span><span class="text-[10px] leading-none">p.a.</span></div>
                                                        </div>
                                                        <p class="text-xs text-black-1">Comparison</p>
                                                    </div>
                                                    <div class="text-center">
                                                        <p class="text-2xl">${{ $value['perMonth'] }}</p>
                                                        <p class="text-xs text-black-1">Monthly</p>
                                                        <p class="text-xs text-black-1">Repayments</p>
                                                    </div>
                                                    <div class="text-center">
                                                        <p class="text-2xl">${{ $value['perMonth'] }}</p>
                                                        <p class="text-xs text-black-1">Savings over</p>
                                                        <p class="text-xs text-black-1">5 years</p>
                                                    </div>
                                                </div>
                                            </div>
                                         @endforeach
                                        @endforeach
                                    </div>
                                </div>
                                <div class="flex md:hidden justify-center items-center mt-5">
                                    <button id="requestCallBtnMobile" class="text-white bg-blue py-3 w-full rounded requestCallBtn hidden" onclick="requestCall()">Request a call from your Property  Manager</button>
                                    <p class="text-blue text-[1.1rem] requestCallBtnPw hidden">Please wait...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card p-5 p-sm-10 mt-5">
                    <h3 class="text-2xl">Which interest rate is right for me?</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 md:divide-x-2 mt-10">
                        <div class="cols px-5 flex flex-col gap-3">
                            <img src="{{ asset('assets/images/loanmarket/svg/calcPercent.svg') }}" width="50px"/>
                            <p class="text-[1.1rem]">Variable - Flexibility & Potential Savings</p>
                            <p class="text-[1rem]">A variable rate can increase or decrease over the loan period. Your monthly repayments may vary.</p>
                            <ul class="text-[1rem]">
                                <li><i class="fa-solid fa-check me-2"></i> Interest rate moves with the market.</li>
                                <li><i class="fa-solid fa-check me-2"></i> Benefit from rate drops & extra repayments options.</li>
                                <li><i class="fa-solid fa-check me-2"></i> Access to features like offset accounts & redraw.</li>
                                <li><i class="fa-solid fa-check me-2"></i> Repayments can increase if rates rise.</li>
                            </ul>
                        </div>
                        <div class="cols px-5 flex flex-col gap-3 mt-10 mt-md-0">
                            <img src="{{ asset('assets/images/loanmarket/svg/calcLock.svg') }}" width="50px"/>
                            <p class="text-[1.1rem]">Fixed - Stability and Predictability</p>
                            <p class="text-[1rem]">The fixed rate remains the same for a set time. Your repayments remain unchanged during the fixed term.</p>
                            <ul class="text-[1rem]">
                                <li><i class="fa-solid fa-check me-2"></i> Locked-in interest rate for a set period.</li>
                                <li><i class="fa-solid fa-check me-2"></i> Consistent repayments make budgeting easier.</li>
                                <li><i class="fa-solid fa-check me-2"></i> Protection from rate increases.</li>
                                <li><i class="fa-solid fa-check me-2"></i> Less flexibility if rates drop.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="client_details_modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <h3 class="my-3 text-xl">Client Details:</h3>
                    <div class="mb-3">
                        <label class="label text-xs text-black" for="name">Name</label>
                        <input id="name" name="name" type="text" placeholder="Name">
                        <small class="text-red-500 hidden" id="name_error">Please enter your fullname.</small>
                    </div>
                    <div class="mb-3">
                        <label class="label text-xs text-black" for="phone">Contact Number</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 z-10 left-3 flex items-center text-black-1"><i class="fa-solid fa-plus"></i></span>
                            <input id="phone" name="phone" type="number" class="ps-7" placeholder="Contact Number">
                        </div>
                        <small class="text-red-500 hidden" id="phone_error">Please enter a 10 digit contact number.</small>
                    </div>
                    <div class="mb-3">
                        <label class="label text-xs text-black" for="email">Email</label>
                        <input id="email" name="email" type="email" placeholder="Email">
                        <small class="text-red-500 hidden" id="email_error">Please enter a valid email address.</small>
                    </div>
                    <button type="button" class="bg-gray-100 border border-blue text-black px-5 py-3 rounded" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="bg-blue text-white px-5 py-3 rounded" id="clientDetailsSubmit">Continue</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="how_calc_works_modal">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-[1rem] md:text-xl">How did we do the computations?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                <div class="modal-body">
                    <p class="fw-bold mb-2">Assumptions Used in This Calculator</p>
                    <p class="mb-2">This calculator operates based on the following assumptions:</p>
                    <ul class="ms-5">
                        {{-- <li class="flex items-center"><i class="fa-solid fa-circle me-2 text-[5px]"></i><p>The loan term is set at <strong class="ms-1">30 years</strong>.</p></li> --}}
                        <li class="flex items-center"><i class="fa-solid fa-circle me-2 text-[5px]"></i><p>Interest is <strong class="ms-1">compounded monthly</strong>.</p></li>
                        <li class="flex items-center"><i class="fa-solid fa-circle me-2 text-[5px]"></i><p>Repayments are made on a <strong class="ms-1">monthly basis</strong>.</p></li>
                        <li class="flex items-start"><i class="fa-solid fa-circle me-2 pt-2 text-[5px]"></i><p>The <span class="fw-bold text-nowrap">Loan-to-Value Ratio (LVR)</span> is determined by dividing the loan amount by the property&#39;s value, expressed as a percentage.</p></li>
                        <li class="flex items-center"><i class="fa-solid fa-circle me-2 text-[5px]"></i><p>Your <strong class="mx-1">LVR, loan purpose, and repayment method</strong> influence the applicable interest rate.</p></li>
                        <li class="flex items-center"><i class="fa-solid fa-circle me-2 text-[5px]"></i><p>The property&#39;s value is assumed to be the sum of the <strong class="ms-1">loan amount plus the deposit</strong>.</p></li>
                        <li class="flex items-center"><i class="fa-solid fa-circle me-2 text-[5px]"></i><p>The calculations assume <strong class="mx-1">interest rates remain unchanged</strong> throughout the loan term.</p></li>
                        <li class="flex items-start"><i class="fa-solid fa-circle me-2 pt-2 text-[5px]"></i><p>
                            If a <strong class="mx-1">fixed interest rate</strong> is chosen for 1 to 5 years, it will apply for that period, after which the loan
                                will revert to a <strong class="ms-1">variable rate</strong>.
                        </p></li>
                        <li class="flex items-center"><i class="fa-solid fa-circle me-2 text-[5px]"></i><p>This tool does not assess your <strong class="ms-1">ability to meet repayment obligations</strong>.</p></li>
                        <li class="flex items-center"><i class="fa-solid fa-circle me-2 text-[5px]"></i><p>
                            The calculations <strong class="mx-1">do not include fees, charges, or any other costs</strong> that may be associated with
                                your loan.
                        </p></li>
                    </ul>
                    <p class="fw-bold mt-5">Next Steps</p>
                    <p class="mt-2">
                        While this calculator provides an estimate of potential loan repayments, it does not account for
                        individual financial circumstances, eligibility, or lender-specific requirements. Additional costs, such as
                        fees and charges, may apply and should be considered when assessing loan affordability.
                    </p>
                    <p class="mt-2">
                        If you would like a more detailed and personalized discussion about the loan options available to you,
                        we encourage you to speak with an expert. Click the “<strong>Request a call from your Property Manager</strong>”
                        button to connect with one of our experienced property managers, who can provide insights on loan
                        structures, interest rates, repayment plans, and any other relevant factors affecting your loan.
                    </p>
                </div>
            </div>
        </div>
    </div>

    @include('components.lenders')
@endsection

@push('scripts')
    <script>

        let propertyAddress;

        document.addEventListener("DOMContentLoaded", function() {
            localStorage.removeItem('client')

            propertyAddress = document.getElementById('property_address').value.trim();
            let propertyValue = document.getElementById('property_value').value;
            let loanAmount = document.getElementById('loan_amount').value;
            const loanType = document.querySelector('input[name="loan_type"]:checked').value;
            const loanTerm = document.getElementById('loan_term').value;
            const loanPurpose = document.querySelector('input[name="loan_purpose"]:checked').value;
            const clientTerm = document.getElementById('client_term').value;
            const clientRate = document.getElementById('client_rate').value;

            calculatorData = JSON.stringify({
                propertyAddress,
                propertyValue,
                loanAmount,
                loanType,
                loanTerm,
                loanPurpose,
                clientTerm,
                clientRate
            })

            calculateSavingsNoDelay()

        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let calculatorData;

        function toggleLoanTerm() {
            var loanTermContainer = document.getElementById('loan-term-container');
            var isVariable = document.getElementById('loan-type-variable').checked;
            if (isVariable) {
                loanTermContainer.style.maxHeight = '0px';
                loanTermContainer.style.opacity = '0';
                loanTermContainer.style.overflow = 'hidden';
            } else {
                loanTermContainer.style.maxHeight = '100px'; // Adjust based on expected content size
                loanTermContainer.style.opacity = '1';
                loanTermContainer.style.overflow = 'visible';
            }
        }

        toggleLoanTerm();

        document.getElementById('calculate-btn').addEventListener('click', async (event) => {
            event.preventDefault();

            propertyAddress = document.getElementById('property_address').value.trim();
            const propertyAddressError = document.getElementById('property_address_error')

            let propertyValue = document.getElementById('property_value').value;
            let loanAmount = document.getElementById('loan_amount').value;
            const loanType = document.querySelector('input[name="loan_type"]:checked').value;
            const loanTerm = document.getElementById('loan_term').value;
            const loanPurpose = document.querySelector('input[name="loan_purpose"]:checked').value;
            const clientTerm = document.getElementById('client_term').value;
            const clientRate = document.getElementById('client_rate').value;


            if(propertyValue == null || propertyValue == '') {
                document.getElementById('property_value').value = 0
                propertyValue = 0
            }

            if(loanAmount == null || loanAmount == '') {
                document.getElementById('loan_amount').value = 0
                loanAmount = 0
            }

            if (!propertyAddress) {
                propertyAddressError.classList.remove("hidden");
                isValid = false;
                return;
            } else {
                propertyAddressError.classList.add("hidden");
            }

            calculatorData = JSON.stringify({
                propertyAddress,
                propertyValue,
                loanAmount,
                loanType,
                loanTerm,
                loanPurpose,
                clientTerm,
                clientRate
            })

            const client = localStorage.getItem('client');

            if (!client) {
                const myModal = new bootstrap.Modal(document.getElementById('client_details_modal'));
                myModal.show();
                return;
            } else {
                calculateSavings()
            }
        });

        document.getElementById('property_address').addEventListener('keyup', function(){
            document.getElementById('property_address_error').classList.add('hidden')
        });

        document.addEventListener("DOMContentLoaded", function() {
            const nameInput  = document.getElementById("name"),
                nameError  = document.getElementById("name_error"),
                emailInput = document.getElementById("email"),
                emailError = document.getElementById("email_error"),
                phoneInput = document.getElementById("phone"),
                phoneError = document.getElementById("phone_error");

            phoneInput.addEventListener("input", function(e) {
                let value = e.target.value.replace(/\D/g, '');

                if (value.length > 10) {
                    value = value.slice(0, 10);
                }

                e.target.value = value;
            });



            const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/,
                    phonePattern = /^\d{10}$/;

            function validate() {
                let isValid = true;

                if (nameInput.value.trim() === "") {
                    nameError.classList.remove("hidden");
                    isValid = false;
                } else nameError.classList.add("hidden");


                if (emailInput.value.trim() === "" || !emailPattern.test(emailInput.value)) {
                    emailError.classList.remove("hidden");
                    isValid = false;
                } else  emailError.classList.add("hidden");

                if (!phonePattern.test(phoneInput.value)) {
                    phoneError.classList.remove("hidden");
                    isValid = false;
                } else phoneError.classList.add("hidden");

                return isValid;
            }

            document.getElementById("clientDetailsSubmit").addEventListener("click", function(e) {
                e.preventDefault();

                if (validate()) {
                    const clientDetails = {
                        name:  nameInput.value,
                        email: emailInput.value,
                        phone: phoneInput.value
                    };

                    localStorage.setItem('client', JSON.stringify(clientDetails));

                    $('#client_details_modal').modal('hide');
                    calculateSavings();
                }
            });
        });

        function calculateSavings () {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const container = document.getElementById('top-3-container');
            const calcTitle = document.querySelector('.calc-title')
            const dotsContainer = document.querySelector('.dots-container')

            calcTitle.innerHTML = 'Calculating';
            container.innerHTML = '';
            dotsContainer.classList.remove('hidden')

            setTimeout(() => {
                fetch("{{route('calculate-savings')}}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: calculatorData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // if (data) {

                        const bgColor = {
                            'Macquarie' : 'bg-blue',
                            'St. George' : 'bg-white-1',
                            'CBA' : 'bg-black',
                        }

                        const lenderList = data.data.map(lender =>{
                            return (`
                                <div class="border rounded overflow-hidden cursor-pointer hover:border-black w-auto mb-3">
                                    <div class="header ${bgColor[lender?.lender] ?? 'bg-white'} h-[60px] flex items-center ps-5">
                                        <image src='${lender.logo}' style="height: auto; width: 130px"/><span>${lender.lender_id}. ${lender.lender}</span>
                                    </div>
                                    <div class="grid gap-10 md:grid-cols-4 py-3 hover:bg-blue-hover">
                                        <div class="text-center">
                                            <div class="text-2xl flex items-center justify-center gap-2">
                                                <p>${lender.rate }</p>
                                                <div class="flex flex-col"><span class="text-[10px] leading-none">%</span><span class="text-[10px] leading-none">p.a.</span></div>
                                            </div>
                                            <p class="text-xs text-black-1">${lender.type} rate</p>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-2xl flex items-center justify-center gap-2">
                                                <p>${ lender.comparison }</p>
                                                <div class="flex flex-col"><span class="text-[10px] leading-none">%</span><span class="text-[10px] leading-none">p.a.</span></div>
                                            </div>
                                            <p class="text-xs text-black-1">Comparison</p>
                                        </div>
                                        <div class="text-center">
                                            <p class="text-2xl">$ ${ Number(lender.monthly).toLocaleString() }</p>
                                            <p class="text-xs text-black-1">Monthly</p>
                                            <p class="text-xs text-black-1">Repayments</p>
                                        </div>
                                        <div class="text-center">
                                            <p class="text-2xl">$ ${ Number(lender.savings).toLocaleString() }</p>
                                            <p class="text-xs text-black-1">Savings over</p>
                                            <p class="text-xs text-black-1">${ lender.term } ${ lender.term > 1 ? 'years' : 'year' }</p>
                                        </div>
                                    </div>
                                </div>
                            `)
                        }).join('');

                        dotsContainer.classList.add('hidden')
                        calcTitle.innerHTML = 'Top 3 Lenders';
                        container.innerHTML = `<ul>${lenderList}</ul>`;
                        if(!propertyAddress == '') document.querySelector('.requestCallBtn').classList.remove('hidden')
                        if(!propertyAddress == '') document.querySelector('#requestCallBtnMobile').classList.remove('hidden')
                        $('#client_details_modal').modal('hide');
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
                    })
                    .then(() => {
                        $('#client_details_modal').modal('hide');
                    });
                });
            }, 3000);
        }

        function requestCall () {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const clientJson = localStorage.getItem('client')
            let clientData = {};
            let calcData = JSON.parse(calculatorData)

            $(".requestCallBtn").addClass('hidden');
            $(".requestCallBtnPw").removeClass('hidden');

            if(clientJson) {
                const parsed = JSON.parse(clientJson)
                clientData = {
                    name: parsed.name,
                    phone: parsed.phone,
                    email: parsed.email,
                }
            }

            const combinedData = {
                ...clientData,
                ...calcData
            };

            fetch("{{route('request.email')}}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify(combinedData)
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    Swal.fire({
                        text: "Request send successfully!",
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });

                    $(".requestCallBtn").removeClass('hidden');
                    $(".requestCallBtnPw").addClass('hidden');
                }
                else {
                    Swal.fire({
                        text: "Something went wrong while requesting.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok",
                        customClass: {
                            confirmButton: "btn btn-danger"
                        }
                    });

                    $(".requestCallBtn").removeClass('hidden');
                    $(".requestCallBtnPw").addClass('hidden');
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

                $(".requestCallBtn").removeClass('hidden');
                $(".requestCallBtnPw").addClass('hidden');
            });
            // Swal.fire({
            //     text: "Are you sure you want to request a call?",
            //     icon: "info",
            //     iconColor: '#00ABE6',
            //     showCancelButton: true,
            //     confirmButtonColor: "#3085d6",
            //     cancelButtonColor: "#d33",
            //     cancelButtonText: "No, Cancel.",
            //     confirmButtonText: "Yes, Proceed!",
            // })
            // .then((result) => {
            //     if (result.isConfirmed) {
            //         fetch("{{route('request.email')}}", {
            //             method: 'POST',
            //             headers: {
            //                 'Content-Type': 'application/json',
            //                 'X-CSRF-TOKEN': csrfToken,
            //                 'X-Requested-With': 'XMLHttpRequest',
            //             },
            //             body: JSON.stringify(combinedData)
            //         })
            //         .then(response => response.json())
            //         .then(data => {
            //             if(data.success) {
            //                 Swal.fire({
            //                     text: "Request send successfully!",
            //                     icon: "success",
            //                     buttonsStyling: false,
            //                     confirmButtonText: "Ok, got it!",
            //                     customClass: {
            //                         confirmButton: "btn btn-primary"
            //                     }
            //                 })
            //             }
            //             else {
            //                 Swal.fire({
            //                     text: "Something went wrong while requesting.",
            //                     icon: "error",
            //                     buttonsStyling: false,
            //                     confirmButtonText: "Ok",
            //                     customClass: {
            //                         confirmButton: "btn btn-danger"
            //                     }
            //                 });
            //             }
            //         })
            //         .catch(error => {
            //             Swal.fire({
            //                 text: "An error occurred while submitting the form.",
            //                 icon: "error",
            //                 buttonsStyling: false,
            //                 confirmButtonText: "Ok",
            //                 customClass: {
            //                     confirmButton: "btn btn-danger"
            //                 }
            //             });
            //         });
            //     }
            // });
        }

        function calculateSavingsNoDelay () {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const container = document.getElementById('top-3-container');
            const calcTitle = document.querySelector('.calc-title')
            const dotsContainer = document.querySelector('.dots-container')

            calcTitle.innerHTML = 'Calculating';
            container.innerHTML = '';
            dotsContainer.classList.remove('hidden')

            fetch("{{route('calculate-savings')}}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: calculatorData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // if (data) {

                    const bgColor = {
                        'Macquarie' : 'bg-blue',
                        'St. George' : 'bg-white-1',
                        'CBA' : 'bg-black',
                    }

                    const lenderList = data.data.map(lender =>{
                        return (`
                            <div class="border rounded overflow-hidden cursor-pointer hover:border-black w-auto mb-3">
                                <div class="header ${bgColor[lender?.lender] ?? 'bg-white'} h-[60px] flex items-center ps-5">
                                    <image src='${lender.logo}' style="height: auto; width: 130px; margin-right: 10px"/><span>${lender.lender_id}. ${lender.lender}</span>
                                </div>
                                <div class="grid gap-10 md:grid-cols-4 py-3 hover:bg-blue-hover">
                                    <div class="text-center">
                                        <div class="text-2xl flex items-center justify-center gap-2">
                                            <p>${lender.rate }</p>
                                            <div class="flex flex-col"><span class="text-[10px] leading-none">%</span><span class="text-[10px] leading-none">p.a.</span></div>
                                        </div>
                                        <p class="text-xs text-black-1">${lender.type} rate</p>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-2xl flex items-center justify-center gap-2">
                                            <p>${ lender.comparison }</p>
                                            <div class="flex flex-col"><span class="text-[10px] leading-none">%</span><span class="text-[10px] leading-none">p.a.</span></div>
                                        </div>
                                        <p class="text-xs text-black-1">Comparison</p>
                                    </div>
                                    <div class="text-center">
                                        <p class="text-2xl">$ ${ Number(lender.monthly).toLocaleString() }</p>
                                        <p class="text-xs text-black-1">Monthly</p>
                                        <p class="text-xs text-black-1">Repayments</p>
                                    </div>
                                    <div class="text-center">
                                        <p class="text-2xl">$ ${ Number(lender.savings).toLocaleString() }</p>
                                        <p class="text-xs text-black-1">Savings over</p>
                                        <p class="text-xs text-black-1">${ lender.term } ${ lender.term > 1 ? 'years' : 'year' }</p>
                                    </div>
                                </div>
                            </div>
                        `)
                    }).join('');

                    dotsContainer.classList.add('hidden')
                    calcTitle.innerHTML = 'Top 3 Lenders';
                    container.innerHTML = `<ul>${lenderList}</ul>`;
                    $('#client_details_modal').modal('hide');
                    if(!propertyAddress == '') $('.requestCallBtn').removeClass('hidden')
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
                })
                .then(() => {
                    $('#client_details_modal').modal('hide');
                });
            });
        }
    </script>
@endpush
