<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta charset="utf-8">
</head>

<body>

    <p>
        Hi {{ $name }},
    </p>
    <p>
        Thank you for creating an account with us. Don't forget to complete your registration!
    </p>
    <p>
        Please click on the link below or copy it into the address bar of your browser to confirm your email address:
    </p>

    <a href="{{ url('api/auth/verify', $verification_code)}}">Confirm my email address </a>

</body>

</html>