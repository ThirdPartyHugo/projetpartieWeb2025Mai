<x-guest-layout>
    <form method="POST" action="{{ route('updatePassword') }}">
        @csrf

        <input type="hidden" name="id_user" id="id_user" value="{{ $compte->id }}"/>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Nouveau mot de passe')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirmation du nouveau mot de passe')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-3">
                {{ __('Réinitialisé le mot de passe') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
