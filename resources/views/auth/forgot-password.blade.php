<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
</head>

<body>
    <h1>Forgot Your Password?</h1>

    @if (session('status'))
    <div style="color: green;">
        {{ session('status') }}
    </div>
    @endif

    @if ($errors->any())
    <div style="color: red;">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <label for="email">Email Address:</label><br>
        <input id="email" type="email" name="email" required autofocus><br><br>

        <button type="submit">Send Password Reset Link</button>
    </form>
</body>

</html>