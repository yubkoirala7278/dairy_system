<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>आदर्श डेरी</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="{{ asset('backend_assets/img/logo.png') }}" rel="icon">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        body {
            background-color: #d4f1c4;
            /* Light green background */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            max-width: 400px;
            width: 100%;
            padding: 20px;
        }

        .card {
            background-color: #073b18;
            /* Dark green background */
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            color: #ffffff;
            text-align: center;
        }

        .card-header {
            font-size: 1.5em;
            font-weight: bold;
            color: #ffffff;
            margin-bottom: 10px;
        }

        .alert {
            background-color: #ff4c4c;
            /* Red background for error message */
            color: #ffffff;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .form-control {
            background-color: #a2d9a2;
            /* Light green background for inputs */
            border: none;
            color: #073b18;
            padding: 10px;
            border-radius: 8px;
            font-size: 1em;
        }

        .form-control:focus {
            outline: none;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
        }

        .btn-primary {
            background-color: #28a745;
            /* Green color for the button */
            color: #ffffff;
            font-weight: bold;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            font-size: 1em;
            cursor: pointer;
            width: 100%;
            margin-top: 15px;
            transition: background-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #218838;
        }

        .form-check-label,
        .btn-link {
            color: #b2d9b2;
            /* Light green color for text links */
        }

        .form-check-input {
            background-color: #28a745;
            border: none;
        }

        .btn-link:hover {
            color: #e8f0e8;
            text-decoration: underline;
        }

        .footer-text {
            color: #b2d9b2;
            margin-top: 10px;
        }

        .footer-text a {
            color: #28a745;
            text-decoration: none;
        }

        .footer-text a:hover {
            color: #218838;
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div id="app">
        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>

</html>
