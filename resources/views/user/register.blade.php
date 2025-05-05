<x-guest-layout>
    <form method="post" action="{{ route('ajoutEmployee') }}" id="formAjoutEmploye">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nom')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Courriel')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
        </div>

        <!-- Role -->
        <div class="mt-4">
            <x-input-label for="roles" :value="__('Role')" />
            <select name="roles" class="w-full" id="roles">
                @foreach ($roles as $role)
                    <option value="{{ $role->id_role }}">{{ $role->role }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('roles')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Mot de passe')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirmation du mot de passe')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-4">
                {{ __('Ajouter l\'employé') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
