<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 20px;
            padding: 1rem;
        }

        .login-container {
            width: 100%;
            max-width: 500px;
            background: #fff;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-header {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            color: #007bff;
            margin-bottom: 1.5rem;
        }

        .form-floating {
            margin-bottom: 1rem;
        }

        .form-floating label {
            color: #6c757d;
        }

        .form-control {
            border-radius: 5px;
            padding: 0.75rem;
            border: 1px solid #ced4da;
            width: 100%;
        }

        .form-control:focus {
            border-color: #80bdff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.25);
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            padding: 0.75rem;
            font-size: 1rem;
            border-radius: 8px;
            width: 100%;
            margin-top: 1rem;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-secondary {
            background-color: #6c757d;
            border: none;
            padding: 0.75rem;
            font-size: 1rem;
            border-radius: 8px;
            width: 100%;
            margin-top: 1rem;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .error-message {
            color: red;
            font-size: 0.9rem;
            text-align: center;
            margin-bottom: 1rem;
        }

        .success-message {
            color: green;
            font-size: 0.9rem;
            text-align: center;
            margin-bottom: 1rem;
        }

        @media (max-width: 768px) {
            .login-container {
                padding: 1.5rem;
            }

            .btn-primary,
            .btn-secondary {
                margin-top: 1.5rem;
            }
        }

        @media (max-width: 576px) {
            body {
                padding: 0.5rem;
            }

            .login-container {
                padding: 1.5rem;
            }

            .login-header {
                font-size: 20px;
            }

            .form-control {
                padding: 0.6rem;
            }

            .btn-primary,
            .btn-secondary {
                padding: 0.6rem;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h3 class="login-header">Login</h3>
        <p>Selamat datang kembali di villa BMI.</p>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="form-floating">
                <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email"
                    required />
                <label for="email">Email</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" id="password" name="password"
                    placeholder="Masukkan password" required />
                <label for="password">Password</label>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
            <div class="mt-2 text-center">
                <a href="/" class="btn btn-outline-primary w-100">Kembali ke Beranda</a>
            </div>
        </form>

        <div class="mt-3 text-center">
            Belum memiliki akun? <a href="/register" class="text-decoration-none">Daftar di sini</a>
            <br />
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>