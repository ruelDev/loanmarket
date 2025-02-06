<!DOCTYPE html>
<html>
<head>
    <title>LoanMarket Email</title>
</head>
<body>
    <p>{{ $messageContent }}</p>

    <h5>CLIENT DETAILS:</h5>

    <p>Name: {{ $clientName }}</p>

    <p>Phone Number: [Client's Phone Number]</p>

    <p>Email Address: [Client's Email Address]</p>




    <h5>TOP 3 LENDERS WITH THE LEAST MONTHLY REPAYMENT:</h5>

    <p>Lender Name: [Lender 1 Name]</p>

    <p>Loan Type: [Fixed/Variable]</p>

    <p>Loan Term (if Fixed): [Loan Term] (Put N/A if Variable)</p>

    <p>Loan Rate: [Loan Rate]</p>

    <p>Monthly Repayment: [Repayment Amount]</p>

    <br/>

    <p>Lender Name: [Lender 2 Name]</p>

    <p>Loan Type: [Fixed/Variable]</p>

    <p>Loan Term (if Fixed): [Loan Term]  (Put N/A if Variable)</p>

    <p>Loan Rate: [Loan Rate]</p>

    <p>Monthly Repayment: [Repayment Amount]</p>


    <p>Lender Name: [Lender 3 Name]</p>

    <p>Loan Type: [Fixed/Variable]</p>

    <p>Loan Term (if Fixed): [Loan Term] (Put N/A if Variable)</p>

    <p>Loan Rate: [Loan Rate]</p>

    <p>Monthly Repayment: [Repayment Amount]</p>

    <br/>

    <p>Please contact the client to discuss loan options further.</p>



    <p>- LoanMarket, Your Home Loan Review</p>
    <image src="{{ $logo}}"
    style="width: 80px; height: auto"/>
</body>
</html>
