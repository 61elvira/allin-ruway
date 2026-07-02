<section class="profile-card">
    <div class="profile-card__header">
        <div class="profile-card__header-left">
            <h2 class="profile-card__title">Actualizar contraseña</h2>
            <p class="profile-card__subtitle">Asegúrate de usar una contraseña larga y aleatoria para mantener tu cuenta segura.</p>
        </div>
    </div>

    <form method="post" action="{{ route('password.update') }}" class="profile-card__form">
        @csrf
        @method('put')

        <div class="form-group">
            <label for="update_password_current_password" class="form-label">Contraseña actual</label>
            <input id="update_password_current_password" name="current_password" type="password" class="form-input" autocomplete="current-password">
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="update_password_password" class="form-label">Nueva contraseña</label>
                <input id="update_password_password" name="password" type="password" class="form-input" autocomplete="new-password">
                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
            </div>
            <div class="form-group">
                <label for="update_password_password_confirmation" class="form-label">Confirmar contraseña</label>
                <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-input" autocomplete="new-password">
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <div class="profile-card__actions">
            <button type="submit" class="btn btn--primary">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                Guardar contraseña
            </button>
            @if (session('status') === 'password-updated')
                <span class="save-feedback">✓ Contraseña actualizada correctamente.</span>
            @endif
        </div>
    </form>
</section>
