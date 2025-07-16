<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'نظام إدارة المهام') }}</title>

        <!-- Google Fonts: Inter -->
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Bootstrap CSS CDN -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-QWTKZyjpPEjISv5WaRU9Oq+RuvbbuX" crossorigin="anonymous">

        <!-- Custom CSS for beautiful login -->
        <style>
            body {
                background: linear-gradient(135deg, #6dd5ed, #2193b0); /* Gradient background */
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
                margin: 0;
                font-family: 'Inter', sans-serif;
                color: #343a40;
            }
            .login-container {
                max-width: 450px;
                width: 100%;
                padding: 40px;
                border-radius: 15px; /* More rounded corners */
                box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2); /* Deeper shadow */
                background-color: #ffffff;
                transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
            }
            .login-container:hover {
                transform: translateY(-8px); /* More pronounced lift on hover */
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25);
            }
            .login-header {
                text-align: center;
                margin-bottom: 35px;
            }
            .login-header h2 {
                color: #007bff; /* Primary blue for heading */
                font-weight: 800; /* Bolder font */
                margin-bottom: 10px;
                font-size: 1.8rem;
            }
            .login-header p {
                color: #6c757d;
                font-size: 0.95rem;
            }
            .form-control {
                border-radius: 10px; /* More rounded inputs */
                padding: 14px 18px;
                border: 1px solid #ced4da;
                font-size: 1rem;
                transition: border-color 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
            }
            .form-control:focus {
                border-color: #007bff;
                box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.25);
            }
            .btn-primary {
                background-color: #007bff;
                border-color: #007bff;
                border-radius: 10px;
                padding: 14px 0;
                font-weight: 700;
                font-size: 1.1rem;
                letter-spacing: 0.5px;
                transition: background-color 0.2s ease-in-out, border-color 0.2s ease-in-out, transform 0.2s ease-in-out;
            }
            .btn-primary:hover {
                background-color: #0056b3;
                border-color: #004085;
                transform: translateY(-3px); /* Stronger button press effect */
            }
            .btn-link {
                color: #007bff;
                font-weight: 500;
                text-decoration: none;
                transition: color 0.2s ease-in-out;
            }
            .btn-link:hover {
                color: #0056b3;
                text-decoration: underline;
            }
            .alert-danger {
                background-color: #f8d7da;
                color: #721c24;
                border-color: #f5c6cb;
                padding: 15px;
                border-radius: 10px;
                margin-bottom: 20px;
                font-size: 0.9rem;
            }
            .text-muted {
                color: #6c757d !important;
            }
        </style>
    </head>
    <body>
        <div class="login-container">
            <div class="login-header">
                <h2>نظام إدارة مهام الموظفين</h2>
                <p class="text-muted">الرجاء تسجيل الدخول للمتابعة</p>
            </div>
            {{ $slot }}
        </div>

        <!-- Bootstrap JS CDN (Bundle with Popper) -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>
