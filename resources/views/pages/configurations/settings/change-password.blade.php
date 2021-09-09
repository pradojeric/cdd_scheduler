<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Settings') }}
        </h2>
    </x-slot>
    <div class="max-w-lg mx-auto mt-10 p-6 border bg-white rounded-lg shadow-sm">
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('settings.password.update') }}">
            @csrf


            <!-- Email Address -->
            <div>
                <x-label for="old" :value="__('Old Password')" />

                <x-input id="password" class="block mt-1 w-full" type="password" name="old" required autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-input id="password_confirmation" class="block mt-1 w-full"
                                    type="password"
                                    name="password_confirmation" required />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button>
                    {{ __('Update Password') }}
                </x-button>
            </div>
        </form>
    </div>


</x-app-layout>
