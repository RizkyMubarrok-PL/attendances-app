<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SiHadir Login</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=visibility_off" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=visibility" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300..700&family=Edu+AU+VIC+WA+NT+Pre:wght@400..700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="style/css.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    @if (session('status') === false)
    <div class="alert alert-danger alert-dismissible fade show alert-custom" role="alert">
        <p>{{ session('message') }}</p>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <div class="login-card">
        <div class="login-left">
            <img src="img/smkn10.png" alt="Logo">
            <h3 class="judul-login-besar">Absence Go</h3>
            <p class="judul-login-kecil">Website Absensi</p>
            <p class="judul-login-kecil-dua">SMKN 10</p>
        </div>
        <div class="login-right">
            <h2>Login</h2>
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="input-container">
                    <input type="email" id="email" name="email" required autofocus>
                    <label for="email">Email</label>
                    <i class="fas fa-user"></i>
                </div>
                <div class="input-container">
                    <input type="password" id="password" name="password" required>
                    <label for="password">Password</label>
                    <span class="toggle-password" onclick="togglePassword()">
                        <img id="toggleIcon" src="img/eye-closed.png" alt="Toggle Password"
                            style="cursor: pointer; width: 24px;">
                    </span>
                </div>
                <button type="submit" class="login-button">Login</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="jsnya/js.js"></script>
</body>

</html>
