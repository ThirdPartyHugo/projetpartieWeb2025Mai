<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight w-1/3">
            {{ __('Gestion des articles') }}
        </h2>
    </x-slot>
    <div class="flex flex-row w-xl mr-20">
        <div class="w-full flex flex-row m-5 ml-10">
            <div class="bg-sky-800 w-5/6 flex flex-row flex-wrap">
                <div class="flex w-full">

                    <p class="bg-blue-300 p-2 w-1/2 m-2 text-white font-semibold">{{ __('Trier par :') }}</p>
                    <p class="bg-blue-300 p-2 w-1/2 m-2 text-white font-semibold">
                        {{ __('Recherche par nom / Code') }}
                    </p>
                </div>
                <form class="flex w-full">
                    <select class="bg-white w-1/2 p-2 m-2 mt-0" id="triProduit" name="triProduit">
                        <option value="Code" selected="selected">Code</option>
                        <option value="Nom">Nom</option>
                        <option value="Prix">Prix</option>
                    </select>
                    <input id="searchInput" class="bg-white w-1/2 p-2 m-2 mt-0" placeholder="{{ __('Search') }}"
                        type="text">
                </form>

            </div>
            <div class="w-1/6 flex flex-col  mx-6">
                <button id="btnEffacer" class="w-full bg-red-700 text-white p-3 px-4 rounded-lg place-self-center mb-2"
                    value="Code">
                    {{ __('Effacer') }}
                </button>
                <button id="btnFiltre" class=" w-full bg-sky-800 text-white p-3 px-4 rounded-lg place-self-center"
                    value="Code">
                    {{ __('Filtre') }}
                </button>
            </div>

        </div>
    </div>
    <div class="bg-sky-500 w-xl mr-10 ml-10 p-4">
        <table class=" w-full">
            <tr class="font-semibold text-m">
                <td class=""></td>
                <td class="bg-blue-300 text-white p-2 border-sky-500 border-4">{{ 'Id' }}</td>
                <td class="bg-blue-300 text-white p-2 border-sky-500 border-4">{{ 'Nom' }}</td>
                <td class="bg-blue-300 text-white p-2 border-sky-500 border-4">{{ 'Adresse' }}</td>
                <td class="bg-blue-300 text-white p-2 border-sky-500 border-4">{{ 'Telephone' }}</td>
                <td class=""></td>
            </tr>
            @foreach ($magasins as $magasin)
                <tr name="{{ $magasin->id }}">
                    <td><input class="self-center justify-self-center" type="checkbox" name="checkBox"></td>
                    <td class="bg-blue-300 text-white p-2 border-sky-500 border-4">{{ $magasin->id }}</td>
                    <td class="bg-blue-300 text-white p-2 border-sky-500 border-4">{{ $magasin->nom }}</td>
                    <td class="bg-blue-300 text-white p-2 border-sky-500 border-4">{{ $magasin->adresse }}</td>
                    <td class="bg-blue-300 text-white p-2 border-sky-500 border-4">{{ $magasin->telephone }}</td>
                    <td><img class="h-6 " src="{{ asset('images/edit-icon.png') }}" alt="image"></td>
                </tr>
            @endforeach
        </table>
    </div>
    <div class="flex flex-row ">
        <button>{{"Retour vers Accueil"}}</button>
        <div>
            <button>{{"Ajouter"}}</button>
            <button>{{"Supprimer"}}</button>

        </div>
    </div>
</x-app-layout>
