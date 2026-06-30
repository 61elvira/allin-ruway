<nav class="dashboard-nav">

    <div class="dashboard-nav-container">

        <a href="{{ route('dashboard') }}" class="dashboard-logo">
            ALLIN RUWAY
        </a>

        <div class="dashboard-user">

            <x-dropdown align="right" width="48">

                <x-slot name="trigger">
                    <button class="dashboard-user-btn">

                        {{ Auth::user()->name }}

                        <span>▼</span>

                    </button>
                </x-slot>

                <x-slot name="content">

                    <x-dropdown-link :href="route('profile.edit')">
                        Mi Perfil
                    </x-dropdown-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-dropdown-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">

                            Cerrar sesión

                        </x-dropdown-link>
                    </form>

                </x-slot>

            </x-dropdown>

        </div>

    </div>

</nav>