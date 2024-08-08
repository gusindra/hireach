<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <x-jet-validation-errors class="p-6 mb-4 bg-red-100" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form class="mt-3 p-6" method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Password') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />

            </div>

            <div class="mt-4 hidden">
                <label for="remember_me" class="flex items-center">
                    <x-jet-checkbox id="remember_me" name="remember" checked="checked" />
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">


                <x-jet-button class="ml-4">
                    {{ __('Log in') }}
                </x-jet-button>
            </div>

            <div class="items-center text-center mt-4 pt-4 border-t">
                @if (Route::has('password.request'))
                    <p>
                        <a class="underline text-xs text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    </p>
                @endif

                <span class="text-gray-600 text-xs">
                    Don't have an account?
                    <a class="underline text-xs text-gray-600 hover:text-gray-900" href="{{ route('register') }}">
                        Create free account
                    </a>
                </span>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
