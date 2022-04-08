<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Biorev Superadmin') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.css" />

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        <style>
            #nprogress .spinner{display: block;position: fixed;z-index: 1031;top: 3.5rem;right: 0;width: calc(100vw - 17rem);text-align: center;height: calc(100vh - 3rem);background: rgba(255,255,255,0.5);margin: auto;padding: calc(40vh) 0 0 calc(50vw - 8rem);}
            .v-toast__item{border-radius: 0.15em !important; min-height: 3em !important;}
            .v-toast__item .v-toast__icon{width: 24px !important;min-width: 24px !important;height: 24px !important;margin-left: 0.81em !important;}
            .v-toast__item .v-toast__text{padding: 1em !important; font-size: 14px !important;}
        </style>
        <!-- Scripts -->
        @routes
        <script src="{{ mix('js/app.js') }}" defer></script>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>
