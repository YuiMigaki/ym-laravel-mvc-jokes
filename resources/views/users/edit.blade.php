<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            Yui's {{ __('Joke DB') }}
        </h2>
    </x-slot>


    <article class="-mx-4">
        <header
            class="bg-zinc-700 text-zinc-200 rounded-t-lg -mx-4 -mt-8 p-8 text-2xl font-bold flex flex-row items-center">
            <h2 class="grow">
                User (Edit)
            </h2>
            <div class="order-first">
                <i class="fa-solid fa-user min-w-8 text-white"></i>
            </div>
            <x-primary-link-button href="{{ route('users.create') }}"
                                   class="bg-zinc-200 hover:bg-zinc-900 text-zinc-800 hover:text-white">
                <i class="fa-solid fa-user-plus "></i>
                <span class="pl-4">Add User</span>
            </x-primary-link-button>
        </header>

        @auth
            <x-flash-message :data="session()"/>
        @endauth

        <div class="flex flex-col flex-wrap my-4 mt-8">
            <section class="grid grid-cols-1 gap-4 px-4 mt-4 sm:px-8">

                <section class="min-w-full items-center bg-zinc-50 border border-zinc-600 rounded overflow-hidden">
                    <form action="{{ route('users.update', $user) }}"
                          method="POST"
                          class="flex gap-4">

                        @csrf
                        @method("PATCH")


                        <div class="min-w-full text-left text-sm font-light text-surface dark:text-white">
                            <header
                                class="border-b border-neutral-200 bg-zinc-800 font-medium text-white dark:border-white/10">
                                <p class="col-span-1 px-6 py-4 border-b border-zinc-200 dark:border-white/10">

                                </p>
                            </header>

                            <section
                                class="py-4 px-6 border-b border-neutral-200 bg-white font-medium text-zinc-800 dark:border-white/10">

                                <div class="flex flex-col my-2 mt-2">
                                    <x-input-label for="nickname">
                                        Nickname
                                    </x-input-label>
                                    <x-text-input id="nickname" name="nickname"
                                                  value="{{ old('nickname') ?? $user->nickname ?? $user->given_name  }}"/>
                                    <x-input-error :messages="$errors->get('nickname')" class="mt-2"/>
                                </div>

                                <div class="flex flex-col my-2">
                                    <x-input-label for="given_name">
                                        Given Name
                                    </x-input-label>
                                    <x-text-input id="given_name" name="given_name"
                                                  value="{{ old('given_name') ?? $user->given_name }}"/>
                                    <x-input-error :messages="$errors->get('given_name')" class="mt-2"/>
                                </div>

                                <div class="flex flex-col my-2">
                                    <x-input-label for="family_name">
                                        Family Name
                                    </x-input-label>
                                    <x-text-input id="family_name" name="family_name"
                                                  value="{{ old('family_name') ?? $user->family_name }}"/>
                                    <x-input-error :messages="$errors->get('family__name')" class="mt-2"/>
                                </div>

                                <div class="flex flex-col my-2">
                                    <x-input-label for="email">
                                        Email
                                    </x-input-label>
                                    <x-text-input id="email" name="email" value="{{ old('email') ?? $user->email }}"/>
                                    <x-input-error :messages="$errors->get('email')" class="mt-2"/>
                                </div>

                                <div class="flex flex-col my-2">
                                    <x-input-label for="role">
                                        Role
                                    </x-input-label>

                                    <select class="form-control multiple" multiple name="roles[]">
                                        @foreach ($selectedRoles as $role)
                                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('roles')" class="mt-2"/>
                                </div>

                                <div class="flex flex-col my-2">
                                    <x-input-label for="password">
                                        Password
                                    </x-input-label>
                                    <x-text-input type="password" id="password" name="password"/>
                                    <x-input-error :messages="$errors->get('password')" class="mt-2"/>
                                </div>

                                <div class="flex flex-col my-2">
                                    <x-input-label for="password_confirmation">
                                        Confirm password
                                    </x-input-label>
                                    <x-text-input type="password" id="password_confirmation"
                                                  name="password_confirmation"/>
                                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2"/>
                                </div>
                            </section>

                            <footer
                                class="flex gap-4 px-6 py-4 border-b border-neutral-200 font-medium text-zinc-800 dark:border-white/10">

                                <x-primary-link-button href="{{ route('users.show', $user) }}" class="bg-zinc-800">
                                    {{ __('Cancel') }}
                                </x-primary-link-button>

                                <x-primary-button type="submit" class="bg-zinc-800">
                                    {{ __('Save') }}
                                </x-primary-button>
                            </footer>
                        </div>
                    </form>

                </section>

            </section>

        </div>

    </article>
</x-app-layout>
