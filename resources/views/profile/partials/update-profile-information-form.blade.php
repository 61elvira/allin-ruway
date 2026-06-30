<section>
    <header class="profile-header">

        <div class="profile-title-container">

            <h2 class="profile-title">
                Mi Perfil Profesional
            </h2>

            <div class="profile-buttons">

                <button type="button" id="editProfileBtn" class="edit-btn">
                    Editar Perfil
                </button>

                @if(auth()->user()->rol === 'cliente')
                    <form action="/convertirse-trabajador" method="POST">
                        @csrf

                        <button type="submit" class="edit-btn">
                            Convertirme en trabajador
                        </button>
                    </form>
                @endif

            </div>

        </div>
        @if($user->rol === 'trabajador')

            <span>
                Perfil de trabajador activo
            </span>

        @endif

        <p class="profile-subtitle">
            Completa tu información para que los clientes puedan conocerte mejor.
        </p>

    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- Nombre -->
        <div class="mt-4">
            <x-input-label for="name" :value="__('Nombre')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full profile-input" :value="old('name', $user->name)" required autofocus autocomplete="name" disabled />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>
        <!-- Apellido -->
        <div class="mt-4">
            <x-input-label for="apellido" value="Apellido" />

            <x-text-input id="apellido" name="apellido" type="text" class="mt-1 block w-full profile-input"
                :value="old('apellido', $user->apellido)" disabled />

        </div>
        @if ($user->rol == 'trabajador')
            <!-- Teléfono -->
            <div class="mt-4">
                <x-input-label for="telefono" value="Teléfono" />

                <x-text-input id="telefono" name="telefono" type="text" class="mt-1 block w-full profile-input"
                    :value="old('telefono', $user->telefono)" disabled />
            </div>
            <!-- Distrito -->
            <select id="distrito" name="distrito" class="mt-1 block w-full profile-input" disabled>

                <option value="">Seleccione un distrito</option>

                @foreach(config('allinruway.distritos') as $distrito)

                    <option value="{{ $distrito }}" {{ old('distrito', $user->distrito) == $distrito ? 'selected' : '' }}>
                        {{ $distrito }}
                    </option>

                @endforeach

            </select>
            <!-- Especialidad -->
            <select id="especialidad" name="especialidad" class="mt-1 block w-full profile-input" disabled>

                <option value="">Seleccione una especialidad</option>

                @foreach($servicios as $servicio)

                    <option value="{{ $servicio->nombre }}" {{ old('especialidad', $user->especialidad) == $servicio->nombre ? 'selected' : '' }}>
                        {{ $servicio->nombre }}
                    </option>

                @endforeach

            </select>
            <!-- Experiencia -->
            <select id="experiencia" name="experiencia" class="mt-1 block w-full profile-input" disabled>

                <option value="">Seleccione experiencia</option>

                @foreach(config('allinruway.experiencias') as $valor => $texto)

                    <option value="{{ $valor }}" {{ old('experiencia', $user->experiencia) == $valor ? 'selected' : '' }}>
                        {{ $texto }}
                    </option>

                @endforeach

            </select>
            <!-- Descripción -->
            <div class="mt-4">
                <x-input-label for="descripcion" value="Descripción" />

                <textarea id="descripcion" name="descripcion" rows="4"
                    class="mt-1 block w-full border-gray-300 rounded-md profile-input"
                    disabled>{{ old('descripcion', $user->descripcion) }}</textarea>
            </div>

        @endif

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full profile-input"
                :value="old('email', $user->email)" required autocomplete="username" disabled />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification"
                            class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4" id="saveContainer" style="display:none;">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const editBtn =
                document.getElementById('editProfileBtn');

            const saveContainer =
                document.getElementById('saveContainer');

            const inputs =
                document.querySelectorAll('.profile-input');

            editBtn.addEventListener('click', function () {

                inputs.forEach(input => {

                    input.disabled = false;

                });

                saveContainer.style.display = 'flex';

                editBtn.style.display = 'none';

            });

        });

    </script>
</section>