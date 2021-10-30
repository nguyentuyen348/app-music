<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
</head>
<body>
    <form class="login100-form validate-form" action="{{ route('login.login') }}" method="post">
        @csrf
        <span class="login100-form-title p-b-37">
            Log In
        </span>

        <div>
            <input class="input100" type="text" name="user_name"
                   placeholder="Name">
            <span class="focus-input100"></span>
            @error('user_name')
            <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <input class="input100" type="password" name="password"
                   placeholder="Password">
            <span class="focus-input100"></span>
            @error('password')
            <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="container-login100-form-btn">
            <button class="login100-form-btn">
                Log In
            </button>
        </div>

    </form>

</body>
</html>