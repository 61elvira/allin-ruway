<x-guest-layout>
    <div class="forgot-password-page">

        <div class="forgot-password-page__pattern"></div>

        <div class="forgot-password-page__card">


            <h2 class="forgot-password-page__title">
                {{ __('¿Olvidaste tu contraseña?') }}
            </h2>

            <div class="forgot-password-page__description">
                {{ __('No te preocupes, solo dinos tu correo y te enviaremos un enlace para que elijas una nueva contraseña.') }}
            </div>
            <br>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}" class="forgot-password-page__form">
                @csrf

                <!-- Email Address -->
                <div class="forgot-password-page__field">
                    <x-input-label for="email" :value="__('Correo electrónico')" class="forgot-password-page__label" />
                    <x-text-input id="email" class="forgot-password-page__input" type="email" name="email" :value="old('email')" required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="forgot-password-page__actions">
                    <x-primary-button class="forgot-password-page__submit">
                        {{ __('Enviar enlace de recuperación') }}
                    </x-primary-button>
                </div>
            </form>

            <a href="{{ route('login') }}" class="forgot-password-page__back">
                {{ __('Volver a iniciar sesión') }}
            </a>

        </div>
    </div>
</x-guest-layout>