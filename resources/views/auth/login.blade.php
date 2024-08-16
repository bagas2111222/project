<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{ asset('img/logo.ico') }}">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <title>Log in</title>
</head>
<body>

<div class="box">
    <div class="form">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <h1><b>LOG IN</b></h1>
            <label for="email">Email:<br>
                <input type="text" id="email" name="email" required autofocus>
            </label>
            <br><br>
            <label for="password">Password:<br>
                <input type="password" name="password" id="password" required>
            </label>
            <br><br>
            <button type="submit">Log in</button>
            @if ($errors->any())
                <div>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </form>
    </div>
</div>

</body>
</html>
