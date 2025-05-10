<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modifier un magasin') }}
        </h2>
    </x-slot>
    <div class="py-2">
        <form id="formMagasin" method="post" action="{{ route('enregistrementMagasin') }}">
            @csrf
            <div class="bg-sky-500 w-xl mx-10 p-4 flex flex-row grid grid-cols-6 gap-4">
                <div class="bg-blue-300 flex flex-row col-span-1 w-full">
                    <p class="min-w-fit text-white self-center pl-2 font-semibold">{{ 'ID : ' }}</p>
                    <input class="text-white text-left bg-blue-300  container border-0" type="text" name="id"
                        value="{{ $magasin->id }}" disabled>
                </div>
                <div class="bg-blue-300 flex flex-row col-span-3 w-full">
                    <p class="min-w-fit text-white pl-2 self-center font-semibold">{{ 'Nom : ' }}</p>
                    <input class="text-white text-left bg-blue-300 border-0 container " type="text" name="nom"
                        value="{{old('nom',$magasin->nom) }}">
                </div>
                <div class="bg-blue-300 flex flex-row col-span-2">
                    <p class="min-w-fit text-white pl-2 self-center font-semibold">{{ 'Tel : ' }}</p>
                    <input class="text-white text-left bg-blue-300 container border-0" type="text" name="telephone"
                        value="{{old('telephone', $magasin->telephone )}}">
                </div>
                <div class="col-span-6 bg-blue-300 p-4">
                    <img class="h-80" src="{{ asset('images/' . $magasin->image) }}" alt="image">
                </div>
                <div class="bg-blue-300 flex flex-row col-span-2">
                    <p class="min-w-fit text-white pl-2 self-center font-semibold">{{ 'Nom d\'image : ' }}</p>
                    <input class="text-white text-left bg-blue-300 container border-0" type="text" name="image"
                        value="{{old('image', $magasin->image)}}">
                </div>
                <div class="bg-blue-300 flex flex-row col-span-4">
                    <p class="min-w-fit text-white pl-2 self-center font-semibold">{{ 'Adresse : ' }}</p>
                    <input class="text-white text-left bg-blue-300 container border-0" type="text" name="adresse"
                        value="{{old('adresse', $magasin->adresse)}}">
                </div>
            </div>
            <div class="flex flex-row place-content-between mx-10 mt-4">
                <a class=" w-fit bg-sky-800 text-white p-3 px-4 rounded-lg place-self-center"
                    href="{{ route('magasins') }} ">
                    <button type="button" class="">{{ __('Retour vers magasins') }}</button> </a>
                <button class="w-1/6 bg-sky-800 text-white p-3 px-4 rounded-lg place-self-center m-0" value={{$magasin->id}} name="id">{{ 'Enregistrer' }}</button>
            </div>
        </form>
    </div>
</x-app-layout>
