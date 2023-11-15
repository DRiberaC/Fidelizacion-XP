<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body>
    <div class = "alert alert-error">
        @foreach ($errors->all('<p>:message</p>') as $input_error)
            {{ $input_error }}
        @endforeach
    </div>
    <div class="form">
        <div class="form_box">
            <div class="form_left">
                <div class="form_padding">
                    <img class="form_image"
                        src="https://i.pinimg.com/originals/8b/44/51/8b4451665d6b2139e29f29b51ffb1829.png" />
                </div>
            </div>
            <div class="form_right">
                <div class="form_padding-right">
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <h1 class="form_title">Login</h1>
                        <input class="form_email" name="email" type="text" placeholder="Email" />
                        <input class="form_password" name="password" type="password" placeholder="******" />
                        <input class="form_submit-btn" type="submit" value="Login" />
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
