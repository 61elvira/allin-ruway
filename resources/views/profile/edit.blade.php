<x-app-layout>
    <div class="profile-page">
        <div class="profile-page__inner">
            @include('profile.partials.update-profile-information-form', [
                'servicios' => $servicios
            ])

            @include('profile.partials.update-password-form')

            @include('profile.partials.delete-user-form')
        </div>
    </div>
</x-app-layout>
