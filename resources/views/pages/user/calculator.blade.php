@extends('layouts.pages.main')

@section('content')
    <div id="hero-section" class="bg-cover bg-no-repeat bg-center h-[20vh] md:h-[30vh]">
        <div class="container h-full flex flex-col items-center justify-center gap-5">
            <h1 class="text-center text-white text-2xl md:text-6xl font-bold">Calculator</h1>
        </div>
    </div>
    <div id="calculator-section" class="bg-white-3">
        <div class="container py-10">
            <div class="container">
                <div class="card bg-white rounded-md p-0 sm:p-10">
                    <div class="grid gap-4 grid-cols-1 md:grid-cols-6 p-4 md:p-10">
                        <div class="col-span-4 md:col-span-2">
                            <h3 class="text-2xl mb-5 text-black">Calculate your rate and repayments</h3>
                            <div class="calc-form flex flex-col gap-3">
                                <div class="calc-input flex flex-col gap-1">
                                    <label class="label text-xs text-black" for="property_address">Property Address</label>
                                    <input id="property_address" name="property_ddress" type="text" placeholder="Address">
                                    <small class="text-red-500 hidden" id="property_address_error">Please enter a valid address.</small>
                                </div>
                                <div class="calc-input flex flex-col gap-1">
                                    <label class="label text-xs text-black" for="property_value">Property Value ($)</label>
                                    <input id="property_value" class="input-style" name="text" type="number" placeholder="Value" min="0">
                                    <small class="text-red-500 hidden" id="property_address_error">Please enter a valid value.</small>
                                </div>
                                <div class="calc-input flex flex-col gap-1">
                                    <label class="label text-xs text-black" for="loan_amount">Loan Amount ($)</label>
                                    <input id="loan_amount" class="" name="text" type="number" placeholder="Amount" min="0">
                                    <small class="text-red-500 hidden" id="loan_amount_error">Please enter a valid amount.</small>
                                </div>
                                {{-- <div class="calc-input flex flex-col gap-1">
                                    <label class="label text-xs text-black" for="loan-rate">Loan Rate</label>
                                    <input id="loan-rate" class="" name="text" type="text" placeholder="Rate">
                                </div> --}}
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
                                    <label class="label text-xs text-black" for="loan_term">Loan Term</label>
                                    <select id="loan_term" class="" name="text" type="text" placeholder="Term">
                                        <option value="1">1 Year</option>
                                        <option value="2">2 Years</option>
                                        <option value="3">3 Years</option>
                                        <option value="4">4 Years</option>
                                        <option value="5">5 Years</option>
                                    </select>
                                </div>
                                <button id="calculate-btn" class="bg-blue text-white w-[200px] py-3 rounded-lg">Calculate Savings</button>
                            </div>
                        </div>
                        <div class="col-span-4">
                            <div class="bg-white-3 border p-5 rounded">
                                <div class="hidden md:flex justify-between items-center">
                                    <h4>Top Lenders</h4>
                                    <button class="text-blue">Request a call from your Property  Manager</button>
                                </div>
                                <div class="flex justify-center items-center md:hidden">
                                    <h4 class="text-2xl font-bold">Top 3 Lenders</h4>
                                </div>
                                <div class="flex justify-center mt-10">
                                    <div class="flex flex-col gap-5 w-full">
                                        @foreach($data['lenders'] as $key => $value)
                                            <div class="border rounded overflow-hidden cursor-pointer hover:border-black w-auto">
                                                <div class="header bg-black h-[60px] ps-5">
                                                    <image src='{{ asset($value['logo'])}}' style="height: 100%; width: 100px"/>
                                                </div>
                                                <div class="grid gap-10 md:grid-cols-3 py-3 hover:bg-blue-hover">
                                                    <div class="text-center">
                                                        <p class="text-2xl">{{ $value['ratePA'] }}%</p>
                                                        <p class="text-xs text-black-1">RATE P.A</p>
                                                        <p class="text-xs text-black-1">FIXED - {{ $value['range'] }}</p>
                                                    </div>
                                                    <div class="text-center">
                                                        <p class="text-2xl">{{ $value['comparisonRatePA'] }}%</p>
                                                        <p class="text-xs text-black-1">RATE P.A</p>
                                                        <p class="text-xs text-black-1">COMPARISON**</p>
                                                    </div>
                                                    <div class="text-center">
                                                        <p class="text-2xl">${{ $value['perMonth'] }}</p>
                                                        <p class="text-xs text-black-1">PER MONTH*</p>
                                                        <p class="text-xs text-black-1">PRINCIPAL + INTEREST</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="flex md:hidden justify-center items-center mt-5">
                                    <button class="text-white bg-blue py-3 w-full rounded">Request a call from your Property  Manager</button>
                                </div>
                            </div>
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
                    </div>
                    <div class="mb-3">
                        <label class="label text-xs text-black" for="phone">Contact Number</label>
                        <input id="phone" name="phone" type="text" placeholder="Contact Number">
                    </div>
                    <div class="mb-3">
                        <label class="label text-xs text-black" for="email">Email</label>
                        <input id="email" name="email" type="email" placeholder="Email">
                    </div>
                    <button type="button" class="border border-blue text-black px-5 py-3 rounded" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="bg-blue text-white px-5 py-3 rounded" id="clientDetailsSubmit" onclick="calculateSavings()">Continue</button>
                </div>
            </div>
        </div>
    </div>

    @include('components.lenders')
@endsection

@push('scripts')
    <script>
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

            // Gather form data
            const propertyAddress = document.getElementById('property_address').value.trim();
            const propertyAddressError = document.getElementById('property_address_error')

            let propertyValue = document.getElementById('property_value').value;
            let loanAmount = document.getElementById('loan_amount').value;
            const loanType = document.querySelector('input[name="loan_type"]:checked').value;
            const loanTerm = document.getElementById('loan_term').value;

            if(propertyValue == null || propertyValue == '') {
                document.getElementById('property_value').value = 0
                propertyValue = 0
            }

            if(loanAmount == null || loanAmount == '') {
                document.getElementById('loan_amount').value = 0
                loanAmount = 0
            }

            // Validate form inputs
            if (!propertyAddress) {
                propertyAddressError.classList.remove("hidden");
                isValid = false;
                return;
            } else {
                propertyAddressError.classList.add("hidden");
            }

            calculatorData = JSON.stringify({
                    propertyValue,
                    loanAmount,
                    loanType,
                    loanTerm
                })

            // Check for user information in localStorage
            const client = localStorage.getItem('client');

            // Show modal if any information is missing
            if (!client) {
                const myModal = new bootstrap.Modal(document.getElementById('client_details_modal'));
                myModal.show();
                return;
            } else {
                calculateSavings()
            }
        });


        document.getElementById('client_details_modal').addEventListener('shown.bs.modal', function () {
            const clientDetails = {
                name: document.getElementById('name').value,
                phone: document.getElementById('phone').value,
                email: document.getElementById('email').value,
            };

            localStorage.setItem('client', JSON.stringify(clientDetails));

            document.getElementById('clientDetailsSubmit').addEventListener('click', () => {
                calculateSavings();
            })
        })

        function calculateSavings () {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
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
                        console.log('data: ', data)
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
        }
    </script>
@endpush
