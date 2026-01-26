<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Storeroom') }}</title>

<<<<<<< HEAD
=======
                if (appearance === 'system') {
                    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

                    if (prefersDark) {
                        document.documentElement.classList.add('dark');
                    }
                }
            })();
        </script>


        <style>
            html {
                background-color: oklch(1 0 0);
            }

            html.dark {
                background-color: oklch(0.145 0 0);
            }
        </style>


>>>>>>> 273a5dd0220baeb80179c36ad7b00eb510b2ad6c

        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">


        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />


        @viteReactRefresh
        @vite(['resources/js/index.tsx', 'resources/css/app.css'])
<<<<<<< HEAD
    </head>
    <body class="font-sans antialiased">
=======

    </head>
    <body>
>>>>>>> 273a5dd0220baeb80179c36ad7b00eb510b2ad6c
        <div id="root"></div>
    </body>
</html>