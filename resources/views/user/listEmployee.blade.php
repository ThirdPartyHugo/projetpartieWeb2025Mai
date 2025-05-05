<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight w-1/3">
            {{ __('Gestion des employés') }}
        </h2>
    </x-slot>
    <div class="py-2">

        <div class="flex flex-row w-xl mr-20">
            <div class="w-full flex flex-row m-5 ml-10">
                <div class="bg-sky-800 w-5/6 flex justify-center items-center">
                    <form class="w-4/6 my-5">
                        <input type="text" placeholder="Rechercher un emlpoyé" class="w-full" name="searchEmployee" id="searchEmployee">

                        <input type="submit" name="searchEmploye" id="searchEmploye" class="hidden"/>
                    </form>
                </div>
            </div>
        </div>
        <div class="w-xl mt-2 mr-10 ml-10 flex flex-row-reverse">
            <form method="get" action="{{ route('ajoutUser') }}" class="bg-sky-800 text-white p-3 rounded-lg place-content-center m-5">
                @csrf
                <button type="submit">{{ __('Ajouter') }}</button>
            </form>
        </div>
            <div class="bg-sky-500 w-xl mr-10 ml-10 grid grid-cols-12 gap-2 p-4 pb-8">

                <div class="hidden grid grid-cols-subgrid col-span-12 gap-2" id="zoneInfo"></div>

                <div class="grid grid-cols-subgrid col-span-12 gap-2" id="enTete">
                    <p class="pl-2 py-1 text-white font-semibold bg-blue-300 col-span-5 grid place-content-center text-lg">{{'Nom d\'utilisateur'}}</p>

                    <p class="pl-2 py-1 text-white font-semibold bg-blue-300 col-span-5 grid place-content-center text-lg">{{'Courriel'}}</p>
                </div>

                <div class="grid grid-cols-subgrid col-span-12 gap-2" id="listEmploye">
                    @foreach ($users as $user)
                    <div id="{{ $user->id }}" class="grid grid-cols-subgrid col-span-12 gap-2">
                        <p class="pl-2 py-1 text-white font-semibold bg-blue-300 col-span-5">{{ $user->name }}</p>

                        <p class="pl-2 py-1 text-white font-semibold bg-blue-300 col-span-5">{{ $user->email }}</p>


                        <form method="get" action="{{ route('profile.edit') }}" class="grid place-content-center">
                            @csrf
                            <button type="submit" name="id_user" value="{{ $user->id }}" class="w-5 mx-2 updateEmploye">
                                <img src="{{ asset('images/edit-icon.png') }}" alt="Modifier un employé" />
                            </button>
                        </form>

                        <form method="post" action="{{ route('deleteEmployee') }}" class="grid place-content-center">
                            @csrf
                            <button type="submit" name="id_user" value="{{ $user->id }}" class="w-5 supprimerEmploye">
                                <img type="image" src="{{ asset('images/delete-icon.png') }}" alt="Supprimer un employé" />
                            </button>
                        </form>
                    </div>
                    @endforeach
                </div>
            </div>
    </div>
</x-app-layout>
