<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modifier un produit') }}
        </h2>
    </x-slot>
    <div class="py-2">
        <form id="formProduits" method="post" action="{{ route('enregistrementProduit') }}">
            @csrf
            <div class="bg-sky-500 w-xl mx-10 p-4 flex flex-row h-full">
                <img class="w-1/3 rounded-2xl border-solid border-2 border-black m-10 ml-5 mb-20 "
                    src="{{ asset('images/coffee_machine.jpg') }}" alt="image">
                <div class="w-2/3 grid grid-cols-3  m-10 py-10 content-between">
                    <div class="flex flex-column col-span-2 flex-wrap">
                        <p class=" h-fit w-full text-white font-semibold mb-2">{{ __('Display name') }}</p>
                        <input
                            class="w-full bg-sky-500 border-0 border-b-2 border-r-2 p-0 text-white border-white text-left h-fit mr-20"
                            type="text" name="produit_nom" value="{{ $produit->produit_nom }}">
                    </div>
                    <div class="flex flex-column flex-wrap w-16">
                        <p class=" h-fit w-full text-white font-semibold mb-2 text-center">{{ __('Price') }}</p>
                        <input
                            class="w-full bg-sky-500 border-0 border-b-2 border-r-2 p-0 text-white border-white text-center h-fit"
                            type="text" name="produit_prix" value={{ $produit->produit_prix }}>
                    </div>
                    <div class="flex flex-column flex-wrap w-fit">
                        <p class=" h-fit w-full text-white font-semibold mb-2 text-center">{{ __('Code') }}</p>
                        <p
                            class=" w-full bg-sky-500 border-0 border-b-2 border-r-2 p-0 text-white border-white text-center h-fit" name="produit_id">
                            {{ $produit->produit_id }}</p>
                    </div>
                    <div class="flex flex-column flex-wrap w-16">
                        <p class=" h-fit w-full text-white font-semibold mb-2 text-center">{{ __('Stock') }}</p>
                        <input
                            class="w-full bg-sky-500 border-0 border-b-2 border-r-2 p-0 text-white border-white text-center h-fit"
                            name="produit_stock"
                            type="text" value={{ '25' }}>
                    </div>
                    <div class="flex flex-column flex-wrap w-16">
                        <p class=" h-fit w-full text-white font-semibold mb-2 text-center">{{ __('Site ') }}</p>
                        <input
                            class="w-full bg-sky-500 border-0 border-b-2 border-r-2 p-0 text-white border-white text-center h-fit"
                            name="produit_site" type="text" value={{ '3' }}>
                    </div>
                    <div class="flex flex-col flex-wrap col-span-3">
                        <p class=" h-fit w-full text-white font-semibold mb-2 text-left">{{__('Description')}}</p>
                        <textarea class="my-2 col-span-2" name="produit_description" id="" rows="3" value="">{{ $produit->produit_description}}</textarea>
                    </div>
                </div>
            </div>
            <div class="w-xl mt-2 mr-10 ml-10 flex justify-between">
                <a class=" bg-sky-800 w-fit text-white p-3 rounded-lg place-self-center"
                    href="{{ route('produits') }} ">
                    <button type="button" class="">{{ __('Retour vers articles') }}</button> </a>
                <button type="submit" class="bg-sky-800 w-1/6 text-white p-3 rounded-lg place-self-center"
                    name="produit_id" value={{ $produit->produit_id }}>{{ __('Sauvegarder') }}</button>


            </div>
        </form>
    </div>
</x-app-layout>
