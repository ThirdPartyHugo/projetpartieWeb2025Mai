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
                    <form class="w-4/6 my-5" method="get" action="{{ route('commande.show') }}">
                        <label class = "text-white"for="searchCommande">Recherche d'une commande par ID</label>
                        <div class="flex flex-row">
                            <select class="w-full" name="id" id="searchCommande">
                                @foreach ($commandes as $element)
                                    <option value={{$element->commande->commande_id}}>{{ $element->commande->commande_id }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mx-3">
                                Rechercher
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <div class="bg-sky-500 w-xl mr-10 ml-10 w-9/10 h-80 overflow-y-scroll">
                <table class="m-6 w-3/4">
                    <thead>
                        <tr class="font-semibold text-lg">
                            <td class="bg-black text-white p-2 border">ID</td>
                            <td class="bg-black text-white p-2 border">Etat</td>
                            <td class="bg-black text-white p-2 border">Nom</td>
                            <td class="bg-black text-white p-2 border">Total ($)</td>
                        </tr>
                    </thead>
                    <tbody>
                @foreach ($commandes as $element)
                        <tr>
                            <td class="p-2 border">{{ $element->commande->commande_id }}</td>
                            <td class="p-2 border">{{ $element->commande->statut->statut_nom }}</td>
                            <td class="p-2 border">{{ $element->user->name }}</td>
                            <td class="p-2 border">{{ $element->commande->commande_total }}</td>
                            <td class="p-2 border">
                                <form method="get" action="{{ route('commande.edit') }}" class="grid place-content-center">
                                    @csrf
                                    <button type="submit" name="commande_id" value="{{ $element->commande->commande_id }}" class="w-5 mx-2">
                                        <img src="{{ asset('images/edit-icon.png') }}" alt="Modifier une commande" />
                                    </button>
                                </form>
                            </td>
                            <td class="p-2 border">
                                <form method="post" action="{{ route('commande.destroy') }}" class="grid place-content-center">
                                    @csrf
                                    <button type="submit" name="command_id" value="{{ $element->commande->commande_id }}" class="w-5">
                                        <img type="image" src="{{ asset('images/delete-icon.png') }}" alt="Supprimer une commande" />
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
        </div>
    </div>
</x-app-layout>
