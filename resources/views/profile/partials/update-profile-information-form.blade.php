<section class="profile-card">
    <div class="profile-card__header">
        <div class="profile-card__header-left">
            <h2 class="profile-card__title">Mi Perfil Profesional</h2>
            @if($user->rol === 'trabajador')
                <span class="profile-card__badge">Perfil de trabajador activo</span>
            @endif
            <p class="profile-card__subtitle">Completa tu información para que los clientes puedan conocerte mejor.</p>
        </div>
        <div class="profile-card__header-actions">
            <button type="button" id="editProfileBtn" class="btn btn--primary">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Editar Perfil
            </button>
            @if(auth()->user()->rol === 'cliente')
                <form action="/convertirse-trabajador" method="POST">
                    @csrf
                    <button type="submit" class="btn btn--outline">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><polyline points="17 11 19 13 23 9"/></svg>
                        Convertirme en trabajador
                    </button>
                </form>
            @endif
        </div>
    </div>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">@csrf</form>

    <form method="post" action="{{ route('profile.update') }}" class="profile-card__form">
        @csrf
        @method('patch')

        <div class="form-row">
            <div class="form-group">
                <label for="name" class="form-label">Nombre</label>
                <input id="name" name="name" type="text" class="form-input profile-input" value="{{ old('name', $user->name) }}" required autocomplete="name" disabled>
            </div>
            <div class="form-group">
                <label for="apellido" class="form-label">Apellido</label>
                <input id="apellido" name="apellido" type="text" class="form-input profile-input" value="{{ old('apellido', $user->apellido) }}" disabled>
            </div>
        </div>

        <div class="form-group">
            <label for="email" class="form-label">Correo electrónico</label>
            <input id="email" name="email" type="email" class="form-input profile-input" value="{{ old('email', $user->email) }}" required autocomplete="username" disabled>
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div class="verify-banner">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                    <span>Tu correo electrónico no está verificado.</span>
                    <button form="send-verification" class="verify-link">Haz clic aquí para reenviar el correo de verificación.</button>
                </div>
                @if (session('status') === 'verification-link-sent')
                    <p class="verify-success">Se ha enviado un nuevo enlace de verificación a tu correo.</p>
                @endif
            @endif
        </div>

        @if ($user->rol == 'trabajador')
            <div class="form-divider"></div>
            <p class="form-section-title">Información profesional</p>

            <div class="form-row">
                <div class="form-group">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input id="telefono" name="telefono" type="text" class="form-input profile-input" value="{{ old('telefono', $user->telefono) }}" disabled>
                </div>
                <div class="form-group">
                    <label for="distrito" class="form-label">Distrito</label>
                    <select id="distrito" name="distrito" class="form-input form-select profile-input" disabled>
                        <option value="">Seleccione un distrito</option>
                        @foreach(config('allinruway.distritos') as $distrito)
                            <option value="{{ $distrito }}" {{ old('distrito', $user->distrito) == $distrito ? 'selected' : '' }}>{{ $distrito }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="especialidad" class="form-label">Especialidad</label>
                    <select id="especialidad" name="especialidad" class="form-input form-select profile-input" disabled>
                        <option value="">Seleccione una especialidad</option>
                        @foreach($servicios as $servicio)
                            <option value="{{ $servicio->nombre }}" {{ old('especialidad', $user->especialidad) == $servicio->nombre ? 'selected' : '' }}>{{ $servicio->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="experiencia" class="form-label">Experiencia</label>
                    <select id="experiencia" name="experiencia" class="form-input form-select profile-input" disabled>
                        <option value="">Seleccione experiencia</option>
                        @foreach(config('allinruway.experiencias') as $valor => $texto)
                            <option value="{{ $valor }}" {{ old('experiencia', $user->experiencia) == $valor ? 'selected' : '' }}>{{ $texto }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea id="descripcion" name="descripcion" rows="4" class="form-input form-textarea profile-input" disabled>{{ old('descripcion', $user->descripcion) }}</textarea>
            </div>
        @endif

        <div class="profile-card__actions" id="saveContainer" style="display:none;">
            <button type="submit" class="btn btn--primary btn--lg">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                Guardar cambios
            </button>
            @if (session('status') === 'profile-updated')
                <span class="save-feedback">✓ Cambios guardados correctamente.</span>
            @endif
        </div>
    </form>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const editBtn = document.getElementById('editProfileBtn');
        const saveContainer = document.getElementById('saveContainer');
        const inputs = document.querySelectorAll('.profile-input');

        editBtn.addEventListener('click', function () {
            inputs.forEach(input => { input.disabled = false; });
            saveContainer.style.display = 'flex';
            editBtn.style.display = 'none';
        });
    });
</script>
