<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight w-1/3">
            {{ __('Ajouter un nouveau magasin') }}
        </h2>
    </x-slot>
    <div class="py-2">
        <form class="" id="formMagasins" method="post" action="{{ route('storeMagasin') }}">
            @csrf
            <div class="bg-sky-500 w-1/2 m-auto p-4 flex flex-col h-full">
                <p class="w-full text-center text-white font-semibold text-xl pb-4 border-white border-b-2">
                    {{ __('Nouveau magasin') }}</p>
                <div class="w-full grid grid-cols-2 p-5 content-between">
                    <p class=" h-fit w-full text-white font-semibold mb-2 place-self-center">{{ __('Nom') }}</p>
                    <input class="my-2" type="text" name="nom" value="{{ old('nom') }}">

                    <p class=" h-fit w-full text-white font-semibold mb-2 place-self-center ">{{ __('Adresse') }}</p>
                    <input class="my-2" type="text" name="adresse" value="{{ old('adresse') }}">

                    <p class=" h-fit w-full text-white font-semibold mb-2 place-self-center">{{ __('Telephone') }}</p>
                    <input class="my-2" type="text" name="Longitude" value="{{ old('telephone') }}">

                    <p class=" h-fit w-full text-white font-semibold mb-2 place-self-center">{{ __('Nom de l\'image') }}</p>
                    <input class="my-2" type="text" name="image" value="{{ old('image') }}">

                    <div class="flex flex-row flex-wrap col-span-2 justify-around">
                        <p class=" h-fit w-2/5 text-white font-semibold mb-2 place-self-center">{{ __('Longitude') }}</p>
                        <p class=" h-fit w-2/5 text-white font-semibold mb-2 place-self-center ">{{ __('Latitude') }}</p>
                        <input class="my-2 w-2/5" type="text" name="telephone" value="{{ old('longitude') }}">
                        <input class="my-2 w-2/5" type="text" name="Latitude" value="{{ old('latitude') }}">
                    </div>
                </div>
            </div>
            <div class="mt-2 w-1/2 m-auto flex justify-between">
                <a class=" bg-sky-800 w-fit text-white p-3 rounded-lg place-self-center"
                    href="{{ route('produits') }} ">
                    <button type="button" class="">{{ __('Retour vers articles') }}</button> </a>

                <button type="submit"
                    class="bg-sky-800 w-fit text-white p-3 rounded-lg place-self-center">{{ __('Enregistrer') }}</button>
            </div>
        </form>

    </div>
</x-app-layout>
