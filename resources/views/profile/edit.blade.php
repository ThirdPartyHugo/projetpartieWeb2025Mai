<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profil') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Information du profil') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                {{ __("Mettez à jour les informations du profil.") }}
                            </p>
                        </header>



                        <form method="post" action="{{ route('updateEmployee') }}" class="mt-6 space-y-6">
                            @csrf

                            <input type="hidden" name="id_user" id="id_user" value="{{ $user->id }}"/>

                            <div>
                                <x-input-label for="name" :value="__('Nom')" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                            </div>

                            <div>
                                <x-input-label for="email" :value="__('Courriel')" />
                                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                            </div>

                            <div class="mt-4">
                                <x-input-label for="roles" :value="__('Role')" />
                                <select name="roles" class="mt-1 block w-full rounded-lg border-gray-300" id="roles">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id_role }}" @if ($role->id_role == $user->id_role)
                                            selected
                                        @endif>{{ $role->role }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('roles')" class="mt-2" />
                            </div>

                            <section>
                                <header>
                                    <h2 class="text-lg font-medium text-gray-900">
                                        {{ __('Mettre à jour le mot de passe') }}
                                    </h2>

                                    <p class="mt-1 text-sm text-gray-600">
                                        {{ __('Assurez-vous que le profil a un long mot de passe sécurisé.') }}
                                    </p>
                                </header>

                                    <div>
                                        <x-input-label for="update_password_password" :value="__('Nouveau mot de passe')" />
                                        <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                                    </div>

                                    <div>
                                        <x-input-label for="update_password_password_confirmation" :value="__('Confirmation du nouveau mot de passe')" />
                                        <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                                    </div>
                            </section>

                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Save') }}</x-primary-button>

                                @if (session('status') === 'profile-updated')
                                    <p
                                        x-data="{ show: true }"
                                        x-show="show"
                                        x-transition
                                        x-init="setTimeout(() => show = false, 2000)"
                                        class="text-sm text-gray-600"
                                    >{{ __('Saved.') }}</p>
                                @endif
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
