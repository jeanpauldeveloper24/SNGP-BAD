<x-guest-layout>
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <h2 class="text-center text-3xl font-extrabold text-gray-900 font-cabinet">
            Créer un compte d'Autorité
        </h2>
        <p class="mt-2 text-center text-sm text-gray-600 font-inter">
            Espace d'enregistrement réservé aux Administrateurs Système et Ordonnateurs.
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow-xl sm:rounded-xl sm:px-10 border border-gray-100">
            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="space-y-6" x-data="{ photoPreview: null }">
                @csrf

                <!-- Photo de profil -->
                <div class="flex flex-col items-center justify-center space-y-3">
                    <x-input-label for="photo" value="Photo de profil (Optionnelle)" class="font-inter font-semibold text-gray-700" />
                    
                    <div class="relative">
                        <!-- Aperçu image par défaut -->
                        <template x-if="!photoPreview">
                            <div class="w-24 h-24 rounded-full bg-gray-100 border-2 border-gray-300 flex items-center justify-center text-gray-400 overflow-hidden shadow-inner">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                        </template>

                        <!-- Aperçu nouvelle image téléchargée -->
                        <template x-if="photoPreview">
                            <div class="w-24 h-24 rounded-full border-2 border-[#27AE60] overflow-hidden shadow-md">
                                <img :src="photoPreview" class="w-full h-full object-cover">
                            </div>
                        </template>

                        <!-- Bouton d'upload -->
                        <label for="photo" class="absolute bottom-0 right-0 bg-[#27AE60] hover:bg-[#219653] text-white p-2 rounded-full cursor-pointer shadow-lg transition duration-150">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h0.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </label>
                        <input type="file" id="photo" name="photo" accept="image/*" class="hidden" 
                               @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => { photoPreview = e.target.result; }; reader.readAsDataURL(file); }" />
                    </div>
                    <x-input-error :messages="$errors->get('photo')" class="mt-2" />
                </div>

                <!-- Nom Complet -->
                <div>
                    <x-input-label for="name" value="Nom complet" class="font-inter font-semibold text-gray-700" />
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <x-text-input id="name" class="block w-full pl-4 pr-10 py-3 border-gray-300 focus:border-[#27AE60] focus:ring-[#27AE60] rounded-lg shadow-sm font-inter" 
                                      type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Ex: Jean Dupont" />
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                    </div>
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Adresse Email -->
                <div>
                    <x-input-label for="email" value="Adresse Email" class="font-inter font-semibold text-gray-700" />
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <x-text-input id="email" class="block w-full pl-4 pr-10 py-3 border-gray-300 focus:border-[#27AE60] focus:ring-[#27AE60] rounded-lg shadow-sm font-inter" 
                                      type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="exemple@domaine.com" />
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                            </svg>
                        </div>
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Téléphone -->
                <div>
                    <x-input-label for="phone" value="Numéro de Téléphone" class="font-inter font-semibold text-gray-700" />
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <x-text-input id="phone" class="block w-full pl-4 pr-10 py-3 border-gray-300 focus:border-[#27AE60] focus:ring-[#27AE60] rounded-lg shadow-sm font-inter" 
                                      type="text" name="phone" :value="old('phone')" required placeholder="+225 07 00 00 00 00" />
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                    </div>
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>

                <!-- Sélection du Rôle d'Autorité (Filtré dynamiquement selon quotas) -->
                <div>
                    <x-input-label for="role_id" value="Rôle d'Autorité" class="font-inter font-semibold text-gray-700" />
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <select id="role_id" name="role_id" required
                            class="block w-full pl-4 pr-10 py-3 border-gray-300 focus:border-[#27AE60] focus:ring-[#27AE60] rounded-lg shadow-sm font-inter text-gray-700 appearance-none bg-white">
                            <option value="" disabled selected>Sélectionnez votre niveau d'autorité</option>
                            
                            @php
                                $roles = \App\Models\Role::whereIn('name', ['administrateur_systeme', 'ordonnateur'])->get();
                            @endphp

                            @foreach($roles as $role)
                                @php
                                    $count = \App\Models\User::where('role_id', $role->id)->count();
                                    $isFull = ($role->name === 'ordonnateur' && $count >= 1) || ($role->name === 'administrateur_systeme' && $count >= 2);
                                @endphp
                                
                                @if(!$isFull)
                                    <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                        {{ $role->name === 'administrateur_systeme' ? 'Administrateur Système' : 'Ordonnateur' }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                    <x-input-error :messages="$errors->get('role_id')" class="mt-2" />
                </div>

                <!-- Mot de passe -->
                <div>
                    <x-input-label for="password" value="Mot de passe" class="font-inter font-semibold text-gray-700" />
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <x-text-input id="password" class="block w-full pl-4 pr-10 py-3 border-gray-300 focus:border-[#27AE60] focus:ring-[#27AE60] rounded-lg shadow-sm font-inter"
                                        type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirmation du mot de passe -->
                <div>
                    <x-input-label for="password_confirmation" value="Confirmer le mot de passe" class="font-inter font-semibold text-gray-700" />
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <x-text-input id="password_confirmation" class="block w-full pl-4 pr-10 py-3 border-gray-300 focus:border-[#27AE60] focus:ring-[#27AE60] rounded-lg shadow-sm font-inter"
                                        type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                    </div>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <!-- Bouton de soumission & Lien connexion -->
                <div class="pt-2">
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-md text-sm font-bold text-white bg-[#27AE60] hover:bg-[#219653] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#27AE60] transition duration-150 ease-in-out font-inter">
                        Créer mon compte
                    </button>
                </div>

                <div class="text-center pt-2">
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-[#27AE60] hover:text-[#219653] font-inter">
                        Déjà inscrit ? Connectez-vous
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>