<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - {{ config('app.name') }}</title>

    <!-- AdminLTE -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        body {
            margin: 0;
            height: 100vh;
            background: url('{{ asset('images/cafe_bg.jpeg') }}') center/cover no-repeat;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Poppins', sans-serif;
        }

        /* Blur overlay */
        .bg-overlay {
            position: absolute;
            inset: 0;
            backdrop-filter: blur(8px);
            background: rgba(0, 0, 0, 0.45);
            z-index: 1;
        }

        /* Card */
        .login-card {
            position: relative;
            z-index: 5;
            width: 100%;
            max-width: 420px;
            border-radius: 18px;
            padding: 30px;
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.25);
            box-shadow: 0 8px 35px rgba(0,0,0,0.35);
        }

        .logo-wrapper {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo-wrapper img {
            width: 90px;
            height: 90px;
            border-radius: 16px;
            object-fit: cover;
            border: 2px solid rgba(255,255,255,0.4);
        }

        .brand-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: #ffffff;
            margin-top: 10px;
            text-shadow: 0px 2px 4px rgba(0,0,0,0.4);
        }

        .input-group-custom {
            position: relative;
            margin-bottom: 18px;
        }

        .input-group-custom input {
            width: 100%;
            padding: 12px 45px 12px 15px;
            border-radius: 14px;
            border: none;
            background: rgba(255,255,255,0.85);
            font-size: 1rem;
        }

        .input-group-custom .input-icon {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #6d4b3e;
            font-size: 1rem;
        }

        .login-btn {
            background: #8b5e34;
            border: none;
            padding: 12px;
            border-radius: 14px;
            font-size: 1rem;
            font-weight: 600;
            color: white;
            margin-top: 5px;
            width: 100%;
            transition: 0.25s ease-in-out;
        }

        .login-btn:hover {
            background: #704b2a;
        }

        .text-light-small {
            color: #e0d6ce;
            font-size: 0.85rem;
        }

        @media(max-width: 480px) {
            .login-card {
                padding: 24px;
            }
        }
    </style>
</head>

<body>

<div class="bg-overlay"></div>

<div class="login-card">

    <!-- LOGO -->
    <div class="logo-wrapper">
        <img src="{{ asset('images/logo_cafe.jpg') }}" alt="Cafe Logo">
        <div class="brand-title">{{ config('app.name') }}</div>
    </div>

    {{-- ERROR ALERT --}}
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- LOGIN FORM --}}
    <form action="/login" method="POST">
        @csrf

        <!-- Email -->
        <div class="input-group-custom">
            <input type="email" name="email" placeholder="Email" required>
            <i class="fas fa-envelope input-icon"></i>
        </div>

        <!-- Password -->
        <div class="input-group-custom">
            <input type="password" name="password" placeholder="Password" required>
            <i class="fas fa-lock input-icon"></i>
        </div>

        <!-- Button -->
        <button class="login-btn">
            <i class="fas fa-sign-in-alt me-2"></i> Login
        </button>
    </form>
</div>

</body>
</html>
