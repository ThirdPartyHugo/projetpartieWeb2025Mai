<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h1 class="font-bold text-3xl">{{__('Bonjour ')}}{{ $compte->name }}</h1>
                <p>{{__('Vous voulez réinitialisé votre mot de passe pour ce faire veuillez cliquez sur le lien ci-dessous :')}}</p>
                <a class=" h-6 self-center col-span-1 " href="{{ route('formResetPassword', $compte->id) }} ">Cliquez sur le lien</a>
            </div>
        </div>
    </div>
</div>
