<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta charset="utf-8">
</head>

<body>

    <p>
        Hi {{ $name }},
    </p>

    <a href="{{ url('api/auth/password-reset', $recover_code)}}">Change password</a>

</body>

</html>