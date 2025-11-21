<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400..700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}">
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/auth/index.js'])
    <script src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('js/toastr.min.js') }}"></script>


    <!-- Styles -->
    @livewireStyles

    <script>
        if (localStorage.getItem('dark-mode') === 'false' || !('dark-mode' in localStorage)) {
            document.querySelector('html').classList.remove('dark');
            document.querySelector('html').style.colorScheme = 'light';
        } else {
            document.querySelector('html').classList.add('dark');
            document.querySelector('html').style.colorScheme = 'dark';
        }
    </script>
</head>

<body class="font-inter antialiased bg-gray-100 dark:bg-gray-900 text-gray-600 dark:text-gray-400">

    <main class="bg-white dark:bg-gray-900">
        <div class="relative flex">
            <!-- Content -->
            <div class="w-full md:w-1/2">
                <div class="min-h-[100dvh] h-full flex flex-col after:flex-1">
                    <!-- Header -->
                    <div class="flex-1">
                        <div class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8">
                            <a class="block" href="{{ route('dashboard') }}">
                                <svg class="fill-violet-500" xmlns="http://www.w3.org/2000/svg" width="32"
                                    height="32">
                                    <path
                                        d="M31.956 14.8C31.372 6.92 25.08.628 17.2.044V5.76a9.04 9.04 0 0 0 9.04 9.04h5.716ZM14.8 26.24v5.716C6.92 31.372.63 25.08.044 17.2H5.76a9.04 9.04 0 0 1 9.04 9.04Zm11.44-9.04h5.716c-.584 7.88-6.876 14.172-14.756 14.756V26.24a9.04 9.04 0 0 1 9.04-9.04ZM.044 14.8C.63 6.92 6.92.628 14.8.044V5.76a9.04 9.04 0 0 1-9.04 9.04H.044Z" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    <div class="max-w-sm mx-auto w-full px-4 py-8">
                        @if (Request::is('signin'))
                            <!-- Login Form -->
                            <div class="mb-8">
                                <h1 class="text-2xl md:text-3xl font-bold text-gray-800 dark:text-gray-200 mb-2">Welcome
                                    back! ✨</h1>
                                <p class="text-gray-500">Please sign in to your account</p>
                            </div>

                            <form id="signinForm" method="POST">
                                @csrf
                                <!-- Email Input -->
                                <div class="space-y-4">
                                    <div>
                                        <label for="email"
                                            class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">
                                            Email Address / user name
                                        </label>
                                        <input id="email" name="email" type=""
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm
                              focus:outline-none focus:ring-violet-500 focus:border-violet-500
                              dark:bg-gray-800 dark:text-gray-200"
                                            placeholder="your@email.com" required autofocus>
                                    </div>

                                    <!-- Password Input -->
                                    <div>
                                        <div class="flex justify-between items-center">
                                            <label for="password"
                                                class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">
                                                Password
                                            </label>
                                            <a href="{{ route('password.request') }}"
                                                class="text-sm text-violet-500 hover:text-violet-700">
                                                Forgot Password?
                                            </a>
                                        </div>
                                        <input id="password" name="password" type="password"
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm
                              focus:outline-none focus:ring-violet-500 focus:border-violet-500
                              dark:bg-gray-800 dark:text-gray-200"
                                            placeholder="••••••••" required>
                                    </div>

                                    <!-- Remember Me Checkbox -->
                                    <div class="flex items-center">
                                        <input id="remember_me" name="remember_me" type="checkbox" value="1"
                                            class="h-4 w-4 text-violet-600 focus:ring-violet-500 border-gray-300 dark:border-gray-700 rounded">
                                        <label for="remember_me"
                                            class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                            Remember me
                                        </label>
                                    </div>

                                    <!-- Submit Button -->
                                    <div>
                                        <button type="button" id="signinButton"
                                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm
                               text-sm font-medium text-white bg-violet-600 hover:bg-violet-700
                               focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-violet-500">
                                            Sign In
                                        </button>
                                    </div>
                                </div>
                            </form>

                            <!-- Footer Links -->
                            <div class="pt-5 mt-6 border-t border-gray-200 dark:border-gray-800">
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    Don't have an account? <a href="{{ route('signup') }}"
                                        class="text-violet-600 hover:text-violet-700">Sign up</a>
                                </div>
                            </div>
                        @elseif(Request::is('signup'))
                            <!-- Register Form -->
                            <div class="mb-8">
                                <h1 class="text-2xl md:text-3xl font-bold text-gray-800 dark:text-gray-200 mb-2">Create
                                    your account</h1>
                                <p class="text-gray-500">Start your journey with us</p>
                            </div>

                            <form id="signupForm">
                                @csrf
                                <div class="space-y-4">
                                    <!-- Name Input -->
                                    <div>
                                        <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300"
                                            for="name">Full Name</label>
                                        <input id="name" name="name" type="text"
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-violet-500 focus:border-violet-500 dark:bg-gray-800 dark:text-gray-200"
                                            placeholder="John Doe" required autofocus>
                                        {{-- @error('name')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror --}}
                                    </div>

                                    <!-- Email Input -->
                                    <div>
                                        <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300"
                                            for="email">Email Address</label>
                                        <input id="email" name="email" type="email"
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-violet-500 focus:border-violet-500 dark:bg-gray-800 dark:text-gray-200"
                                            placeholder="your@email.com" required>
                                        {{-- @error('email')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror --}}
                                    </div>

                                     <!-- User Name Input -->
                                     <div>
                                        <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300"
                                            for="user_name">User Name</label>
                                        <input id="user_name" name="user_name" type="text"
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-violet-500 focus:border-violet-500 dark:bg-gray-800 dark:text-gray-200"
                                            placeholder="john_doe" required>
                                        {{-- @error('user_name')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror --}}
                                    </div>

                                    <!-- Password Input -->
                                    <div>
                                        <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300"
                                            for="password">Password</label>
                                        <input id="password" name="password" type="password"
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-violet-500 focus:border-violet-500 dark:bg-gray-800 dark:text-gray-200"
                                            placeholder="••••••••" required>
                                        {{-- @error('password')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror --}}
                                    </div>

                                    <!-- Password Confirmation -->
                                    <div>
                                        <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300"
                                            for="password_confirmation">Confirm Password</label>
                                        <input id="password_confirmation" name="password_confirmation" type="password"
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-violet-500 focus:border-violet-500 dark:bg-gray-800 dark:text-gray-200"
                                            placeholder="••••••••" required>
                                    </div>

                                    <!-- Submit Button -->
                                    <div>
                                        <button type="submit" id="signupButton"
                                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-violet-600 hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-violet-500">
                                            Create Account
                                        </button>
                                    </div>
                                </div>
                            </form>

                            <!-- Footer Links -->
                            <div class="pt-5 mt-6 border-t border-gray-200 dark:border-gray-800">
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    Already have an account? <a href="{{ route('signin') }}"
                                        class="text-violet-600 hover:text-violet-700">Sign in</a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Image -->
            <div class="hidden md:block absolute top-0 bottom-0 right-0 md:w-1/2" aria-hidden="true">
                <img class="object-cover object-center w-full h-full" src="{{ asset('images/auth-image.png') }}"
                    width="760" height="1024" alt="Authentication image" />
            </div>
        </div>
    </main>

    @livewireScriptConfig
</body>

</html>
