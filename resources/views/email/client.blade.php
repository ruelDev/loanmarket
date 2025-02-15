<!DOCTYPE html>
<html>
<head>
    <title>Your Home Loan Review</title>
</head>
<body>
    <p>{{ $messageContent }}</p>

    <h5>CLIENT DETAILS:</h5>

    <p>Name: {{ $client['name'] }}</p>

    <p>Phone Number: {{ $client['phone'] }}</p>

    <p>Email Address: {{ $client['email'] }}</p>




    <h5>TOP 3 LENDERS WITH THE LEAST MONTHLY REPAYMENT:</h5>

    {{-- [
    "propertyAddress" => "Test"
    "propertyValue" => "1000000"
    "lender" => "CBA"
    "logo" => "assets/images/lenders/Commonwealth.svg"
    "monthly" => "4,466"
    "rate" => "6.59"
    "comparison" => "6.97"
    "term" => 30
    "type" => "FIXED"
  ] --}}
    @foreach ($clientName['top_lenders'] as $lender)
        <p>Lender Name: {{ $lender['lender'] }}</p>
        <p>Loan Type: {{ $lender['type'] }}</p>
        <p>Loan Term (if Fixed): {{ $lender['type'] === 'FIXED' ? $lender['term'] : 'N/A' }}</p>
        <p>Loan Rate: {{ $lender['rate'] }}</p>
        <p>Monthly Repayment: {{ $lender['monthly'] }}</p>
        <br/>
    @endforeach
    <br/>
    <br/>

    <p>Please contact the client to discuss loan options further.</p>
    <br/>

    <p>- YourHomeLoanReview, Your Home Loan Review</p>
    <image src="{{ $logo}}"
    style="width: 80px; height: auto"/>
</body>
</html>
