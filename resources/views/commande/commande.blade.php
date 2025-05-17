<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight w-1/3">
            {{ __('Commande '.$commande->commande_id) }}
        </h2>
    </x-slot>
    <div class="py-2">

        <div class="flex flex-row w-xl mr-20">
            <div class="w-full flex flex-row m-5 ml-10">
                <div class="w-full flex flex-row justify-between items-center text-xl ">
                    <div class="flex flex-col m-5 w-1/4">
                        <div class = "w-full flex justify-between">
                            <h2 class = "font-bold">{{__("ID")}}</h2>
                            <h2>{{$commande->commande_id}}</h2>
                        </div>
                        <div class = " w-full flex justify-between">
                            <h2 class = "font-bold">{{__("CLIENT")}}</h2>
                            <h2>{{$user->name}}</h2>
                        </div>
                        <div class = "w-full flex justify-between">
                            <h2 class = "font-bold">{{__("ETAT")}}</h2>
                            <h2>{{$state->statut_nom}}</h2>
                        </div>
                        <div class = "w-full flex justify-between">
                            <h2 class = "font-bold">{{__("TOTAL")}}</h2>
                            <h2>{{$commande->commande_total."$"}}</h2>
                        </div>






                    </div>
                    <div class="flex flex-col w-min-1/3 max-h-80 overflow-y-auto">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight w-1/3 mb-6">
                            {{ __('Produits ')}}
                        </h2>
                            @foreach ($collection as $produit)
                            <div class="w-full flex border-black mb-3 justify-between">
                                <h2 class = "mx-3">{{  $produit->produit->produit_nom }}</h2>
                                <h2>{{  "quantité: ".$produit->qte }}</h2>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>