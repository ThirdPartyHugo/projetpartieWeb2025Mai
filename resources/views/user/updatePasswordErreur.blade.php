<x-guest-layout>
    <div class="grid place-content-center animate-pulse">
        <img class="h-6 " name="iconErreur" src="{{ asset('images/erreur_icon.png') }}" alt="imageErreur">
    </div>

    <p class="grid place-content-center mt-5">La modification du mot de passe a échoué.</p>

    <form method="get" action="{{ route('formResetPassword', $user->id) }}">
        @csrf
        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-3">
                {{ __('Retour vers la modification du mot de passe') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
