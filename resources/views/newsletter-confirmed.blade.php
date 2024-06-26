<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href='{{ global_asset('images/' . config('config.favicon')) }}'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kumbh+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    <title>{{ $message ?? 'Confirmed' }}</title>
</head>

<body>
    <div class="container">
        <div class="min-vh-100 row align-items-center justify-content-center">
            <div class="col-md-8 mx-auto ">
                <div class="card">
                    <div class="card-body">
                        <div class="alert alert-default-primary">
                            <h3 class="text-center">{{ $message ?? 'Confirmed' }}</h3>
                        </div>

                        <div class="text-center">
                            <a href="{{ url('/') }}" class="btn btn-primary">Go home</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
