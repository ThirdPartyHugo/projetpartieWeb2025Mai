<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/script.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')
        <div class="flex flex-row flex-wrap">
            <aside class="flex flex-col left-0 top-0 w-1/4 bg-sky-950 min-h-[calc(100vh-64px)] ">
                <a class="m-2 ml-4 mr-4 p-2" href="{{ route('dashboard') }} ">
                    <button class="rounded-full border-4 p-2 hover:border-sky-300 border-white justify-self-center w-full text-xl text-white">{{ __('Tableau de bord') }}</button>
                </a>
                <a class="m-2 ml-4 mr-4 p-2" href="{{ route('produits') }} ">
                    <button class="rounded-full border-4 p-2 hover:border-sky-300 border-white justify-self-center w-full text-xl text-white">{{ __('Produits') }}</button>
                </a>
                <a class="m-2 ml-4 mr-4 p-2" href="{{ route('listCommandes') }} ">
                    <button class="rounded-full border-4 p-2 hover:border-sky-300 border-white justify-self-center w-full text-xl text-white">{{ __('Commandes') }}</button>
                </a>
                <a class="m-2 ml-4 mr-4 p-2" href="{{ route('listEmployee') }} ">
                    <button class="rounded-full border-4 p-2 hover:border-sky-300 border-white justify-self-center w-full text-xl text-white">{{ __('Employés') }}</button>
                </a>
            </aside>
            <div class="w-3/4">
                <!-- Page Heading -->
                @isset($header)
                    <header class="bg-white shadow">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <!-- Page Content -->
                <main>
                    <div class="mt-4 max-w-7xl mx-auto sm:px-6 lg:px-8">
                        @include('messageFlash')
                       </div>

                    {{ $slot }}
                </main>

            </div>
        </div>
    </div>
</body>

</html>
