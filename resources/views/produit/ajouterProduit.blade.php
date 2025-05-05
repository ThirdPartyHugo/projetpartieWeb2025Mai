<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight w-1/3">
            {{ __('Ajouter un nouveau produit') }}
        </h2>
    </x-slot>
    <div class="py-2">
        <form class="" id="formProduits" method="post" action="{{ route('storeProduit') }}">
            @csrf
            <div class="bg-sky-500 w-1/2 m-auto p-4 flex flex-col h-full">
                <p class="w-full text-center text-white font-semibold text-xl pb-4 border-white border-b-2">{{ __('Nouveau produit') }}</p>
                <div class="w-full grid grid-cols-2 p-5 content-between">
                    <p class=" h-fit w-full text-white font-semibold mb-2 place-self-center">{{ __('Nom') }}</p>
                    <input class="my-2" type="text" name="nom" value="{{ old('nom')}}">
                    <p class=" h-fit w-full text-white font-semibold mb-2 place-self-center ">{{ __('Prix') }}</p>
                    <input class="my-2" type="text" name="prix" value="{{ old('prix')}}">
                    <p class=" h-fit w-full text-white font-semibold mb-2 place-self-center">{{ __('Nom d\'image') }}</p>
                    <input class="my-2" type="text" name="image" value="{{ old('image')}}">
                    <p class="w-full text-white font-semibold place-self-center col-span-2">{{ __('Description') }}</p>
                    <textarea class="my-2 col-span-2" name="description" id="" rows="5" value="">{{ old('description')}}</textarea>
                </div>
            </div>
            <div class="mt-2 w-1/2 m-auto flex justify-between">
                <a class=" bg-sky-800 w-fit text-white p-3 rounded-lg place-self-center"
                    href="{{ route('produits') }} ">
                    <button type="button" class="">{{ __('Retour vers articles') }}</button> </a>

                <button type="submit" class="bg-sky-800 w-fit text-white p-3 rounded-lg place-self-center">{{ __('Enregistrer') }}</button>
            </div>
        </form>

    </div>
</x-app-layout>
