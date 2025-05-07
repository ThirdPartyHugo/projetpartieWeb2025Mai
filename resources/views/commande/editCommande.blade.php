<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight w-1/3">
            {{ __('Commandes') }}
        </h2>
    </x-slot>
    <div class="py-2">

        <div class="flex flex-row w-xl mr-20">
            <div class="w-full flex flex-row m-5 ml-10">
                <div class="bg-sky-800 w-5/6 flex justify-center items-center">
                    <form class="w-4/6 my-5" method="post" action="{{ route('commande.update') }}">
                        @csrf
                        <label class = "text-white"for="statut_id">Modifier l'état de la commande no {{ $commande->commande_id}}</label>
                        <div class="flex flex-row">
                            <input type="hidden" name="commande_id" id="commande_id" value={{$commande->commande_id}}>
                            <select class="w-full" name="statut_id" id="statut_id">
                            @foreach ($statuts as $statut)
                                <option value={{ $statut->statut_id }}>{{ $statut->statut_nom }}</option>
                            @endforeach
                            </select>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mx-3">
                                Modifier
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
