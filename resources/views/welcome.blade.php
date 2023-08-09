<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Decrypt Encrypt</title>
    <!-- Tambahkan stylesheet Bootstrap di sini -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css">

    <style>
        .custom-container {
            width: 100%;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body>
    <div class="custom-container">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center align-items-center mb-4">
                                <img src="/image/encryption.png" width="50" height="50" class="me-3">
                                <h5 class="card-title mb-0">Web Decrypt Encrypt</h5>
                            </div>
                            <a href="{{ route('login') }}" class="btn btn-primary">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-secondary">Register</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
