<!DOCTYPE html>
<html>
<head>
    <title>Your Home Loan Review</title>
</head>
<body>
    <h3>CLIENT DETAILS:</h3>
    <p>Name: {{ $client['name'] }}</p>
    <p>Phone Number: {{ $client['phone'] }}</p>
    <p>Email Address: {{ $client['email'] }}</p>
    <br/>
    <p>{{ $messageContent }}</p>
    <br/>
    <br/>

</body>
</html>
