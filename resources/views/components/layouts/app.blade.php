<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ??
        '
    आदर्श डेरी
    ' }}</title>
     <link href="{{ asset('backend_assets/img/logo.png') }}" rel="icon">
    @livewireStyles
</head>

<body>
    {{ $slot }}

    @livewireScripts
</body>

</html>
