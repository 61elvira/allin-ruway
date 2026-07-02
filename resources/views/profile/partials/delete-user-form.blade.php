<section class="profile-card profile-card--danger">
    <div class="profile-card__header">
        <div class="profile-card__header-left">
            <h2 class="profile-card__title">Eliminar cuenta</h2>
            <p class="profile-card__subtitle">Una vez que se elimine tu cuenta, todos tus datos se borrarán permanentemente.</p>
        </div>
    </div>

    <div class="profile-card__danger-actions">
        <button type="button" class="btn btn--danger"
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
            Eliminar mi cuenta
        </button>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="modal-form">
            @csrf
            @method('delete')

            <div class="modal-form__body">
                <div class="modal-form__icon">⚠️</div>
                <h2 class="modal-form__title">¿Estás seguro de eliminar tu cuenta?</h2>
                <p class="modal-form__text">Esta acción es irreversible. Todos tus datos, contrataciones y registros serán eliminados permanentemente. Ingresa tu contraseña para confirmar.</p>

                <div class="form-group" style="margin-top: 20px;">
                    <label for="password" class="form-label">Contraseña</label>
                    <input id="password" name="password" type="password" class="form-input" placeholder="Ingresa tu contraseña">
                    <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                </div>
            </div>

            <div class="modal-form__actions">
                <button type="button" class="btn btn--outline" x-on:click="$dispatch('close')">Cancelar</button>
                <button type="submit" class="btn btn--danger">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                    Sí, eliminar mi cuenta
                </button>
            </div>
        </form>
    </x-modal>
</section>
