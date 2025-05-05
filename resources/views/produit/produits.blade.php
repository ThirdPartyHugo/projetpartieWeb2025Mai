<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight w-1/3">
            {{ __('Gestion des articles') }}
        </h2>
    </x-slot>
    <div class="py-2">

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
                        <input id="searchInput" class="bg-white w-1/2 p-2 m-2 mt-0" placeholder="{{ __('Search') }}" type="text" >
                    </form>

                </div>
                <div class="w-1/6 flex flex-col  mx-6">
                    <button id="btnEffacer" class="w-full bg-red-700 text-white p-3 px-4 rounded-lg place-self-center mb-2" value="Code">
                        {{ __('Effacer') }}
                    </button>
                    <button id="btnFiltre" class=" w-full bg-sky-800 text-white p-3 px-4 rounded-lg place-self-center" value="Code">
                        {{ __('Filtre') }}
                    </button>
                </div>

            </div>
        </div>
        <div id="formProduits">
            <div class="bg-sky-500 w-xl mr-10 ml-10 grid grid-cols-12 gap-2 p-4 pb-8">
                <p class="pl-2 py-1 text-white font-semibold bg-blue-300 col-start-3 col-span-2"> {{ __('Code') }}
                </p>
                <p class="pl-2 py-1 text-white font-semibold bg-blue-300 col-span-5">{{ __('Nom') }}</p>
                <div class="col-span-3 grid grid-cols-subgrid gap-2">
                    <p class="pl-2 py-1 text-white font-semibold bg-blue-300 col-span-2">{{ __('Prix') }}</p>
                </div>
                @foreach ($produits as $produit)
                <div id="{{ $produit->produit_id }}" class="grid grid-cols-subgrid col-span-12 gap-2">
                    <input class="self-center justify-self-center" type="checkbox" name="checkBox">
                    <img class="h-10 col-span-1 col-start-2" src="{{ asset('images/coffee_machine.jpg') }}"
                        alt="image">
                    <p  class="content-center pl-2 py-1 text-white font-semibold bg-blue-300 col-start-3 col-span-2">
                        {{ $produit->produit_id }}</p>
                    <p class="pl-2 content-center py-1 text-white font-semibold bg-blue-300 col-span-5">
                        {{ $produit->produit_nom }}</p>
                    <p class="pl-2 content-center py-1 text-white font-semibold bg-blue-300 col-span-2">
                        {{ $produit->produit_prix . '$' }}
                    </p>
                    <a class=" h-6 self-center col-span-1 "
                        href="{{ route('modificationProduit', $produit->produit_id) }} ">
                        <img class="h-6 " name="{{ $produit->produit_id }}"
                            src="{{ asset('images/edit-icon.png') }}" alt="image">
                    </a>
                </div>
                @endforeach
            </div>
            <div class="w-xl mt-2 mr-10 ml-10 flex flex-row-reverse">
                <button type="button" id="btnSupprimer" class="bg-red-700 ml-2 w-1/6 text-white p-3 rounded-lg place-self-center">{{ __('Supprimer') }}</button>
                    <form method="get" action="{{ route('ajouterProduit') }}" class="w-1/6 place-self-center ">
                        <button type="submit"
                        class="bg-sky-800 w-full text-white p-3 rounded-lg" >{{ __('Ajouter') }}</button>
                    </form>

            </div>
            </div>
    </div>
</x-app-layout>
