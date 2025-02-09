<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="{{ config('app.description', 'A Laravel Application') }}">
        <meta name="theme-color" content="#ffffff" media="(prefers-color-scheme: light)">
        <meta name="theme-color" content="#1f2937" media="(prefers-color-scheme: dark)">

        <title>{{ config('app.name', 'Laravel') }} - @yield('title', 'Welcome')</title>

        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="/favicon.ico">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
        <link rel="manifest" href="/site.webmanifest">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Custom Styles -->
        <style>
            .bg-gradient {
                background-image: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 dark:text-gray-100 antialiased min-h-screen bg-gray-100 dark:bg-gray-900">
        <!-- Background Pattern -->
        <div class="fixed inset-0 bg-gradient opacity-5 dark:opacity-10 pointer-events-none">
            <div class="absolute inset-0" style="background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23000000' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");">
            </div>
        </div>

        <div x-data="{ loaded: false }" 
             x-init="setTimeout(() => loaded = true, 150)"
             x-cloak
             class="min-h-screen flex flex-col items-center justify-center p-4">
            
            <!-- Top Navigation (Optional) -->
            <nav class="w-full max-w-md mb-8 flex justify-between items-center">
                <a href="{{ route('home') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200 transition">
                    ← Back to home
                </a>
                
                <!-- Dark Mode Toggle -->
                <button
                    x-data
                    @click="$store.darkMode.toggle()"
                    class="p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition">
                    <svg x-show="!$store.darkMode.on" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                    <svg x-show="$store.darkMode.on" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </button>
            </nav>

            <!-- Logo -->
            <div x-show="loaded" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform scale-95"
                 x-transition:enter-end="opacity-100 transform scale-100"
                 class="mb-8">
                <a href="/" class="transition duration-300 hover:opacity-75">
                    <x-application-logo class="w-24 h-24 fill-current text-gray-500 dark:text-gray-400" />
                </a>
            </div>

            <!-- Main Content -->
            <main x-show="loaded" 
                  x-transition:enter="transition ease-out duration-300 delay-150"
                  x-transition:enter-start="opacity-0 transform translate-y-4"
                  x-transition:enter-end="opacity-100 transform translate-y-0"
                  class="w-full sm:max-w-md">
                <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg overflow-hidden">
                    <div class="p-6 sm:p-8">
                        {{ $slot }}
                    </div>
                </div>

                <!-- Footer Links -->
                <div class="mt-8 text-center text-sm text-gray-600 dark:text-gray-400 space-x-4">
                    <a href="{{ route('terms') }}" class="hover:text-gray-900 dark:hover:text-gray-200 transition">Terms</a>
                    <a href="{{ route('privacy') }}" class="hover:text-gray-900 dark:hover:text-gray-200 transition">Privacy</a>
                    <a href="{{ route('contact') }}" class="hover:text-gray-900 dark:hover:text-gray-200 transition">Contact</a>
                </div>
            </main>
        </div>

        <!-- Session Status -->
        @if (session('status'))
        <div x-data="{ show: true }"
             x-show="show"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform translate-y-2"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100 transform translate-y-0"
             x-transition:leave-end="opacity-0 transform translate-y-2"
             class="fixed bottom-4 right-4 bg-white dark:bg-gray-800 text-sm text-gray-600 dark:text-gray-300 px-4 py-3 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <svg class="h-4 w-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ session('status') }}
                <button @click="show = false" class="ml-4 text-gray-400 hover:text-gray-500">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
        @endif
    </body>
</html>