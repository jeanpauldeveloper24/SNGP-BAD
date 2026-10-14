<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Préférence de Langue') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __("Sélectionnez la langue d'affichage de l'interface de l'application.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- On inclut le nom et l'email pour que la validation du ProfileController ne bloque pas -->
        <input type="hidden" name="name" value="{{ $user->name }}">
        <input type="hidden" name="email" value="{{ $user->email }}">

        <div>
            <x-input-label for="locale" :value="__('Langue de l\'interface / Interface Language')" />
            <select id="locale" name="locale" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                <option value="fr" {{ old('locale', $user->locale) === 'fr' ? 'selected' : '' }}>🇫🇷 Français</option>
                <option value="en" {{ old('locale', $user->locale) === 'en' ? 'selected' : '' }}>🇬🇧 English</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('locale')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Enregistrer') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Enregistré.') }}</p>
            @endif
        </div>
    </form>
</section>