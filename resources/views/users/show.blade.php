<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            YUI's {{ __('Joke DB') }}
        </h2>
    </x-slot>


    <article class="-mx-4">
        <header
            class="bg-zinc-700 text-zinc-200 rounded-t-lg -mx-4 -mt-8 p-8 text-2xl font-bold flex flex-row items-center">
            <h2 class="grow">
                User (Show)
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

                    <div class="min-w-full text-left text-sm font-light text-surface dark:text-white">
                        <header
                            class="grid grid-cols-6 border-b border-neutral-200 bg-zinc-800 font-medium text-white dark:border-white/10">
                            <p class="col-span-2 px-6 py-4 border-b border-zinc-200 dark:border-white/10">Item</p>
                            <p class="col-span-4 px-6 py-4 border-b border-zinc-200 dark:border-white/10">Content</p>
                        </header>

                        <section
                            class="grid grid-cols-6 border-b border-neutral-200 bg-white font-medium text-zinc-800 dark:border-white/10">
                            <p class="col-span-2 bg-zinc-300 whitespace-nowrap px-6 py-4 border-b border-zinc-200 dark:border-white/10">
                                Nickname</p>
                            <p class="col-span-4 whitespace-nowrap px-6 py-4 border-b border-zinc-200 dark:border-white/10">{{ $user->nickname }}</p>
                            <p class="col-span-2 bg-zinc-300 whitespace-nowrap px-6 py-4 border-b border-zinc-200 dark:border-white/10">
                                Given Name</p>
                            <p class="col-span-4 whitespace-nowrap px-6 py-4 border-b border-zinc-200 dark:border-white/10">{{ $user->given_name }}</p>
                            <p class="col-span-2 bg-zinc-300 whitespace-nowrap px-6 py-4 border-b border-zinc-200 dark:border-white/10">
                                Family Name</p>
                            <p class="col-span-4 whitespace-nowrap px-6 py-4 border-b border-zinc-200 dark:border-white/10">{{ $user->family_name }}</p>
                            <p class="col-span-2 bg-zinc-300 whitespace-nowrap px-6 py-4 border-b border-zinc-200 dark:border-white/10">
                                Email</p>
                            <p class="col-span-4 whitespace-nowrap px-6 py-4 border-b border-zinc-200 dark:border-white/10">{{ $user->email }}</p>
                            <p class="col-span-2 bg-zinc-300 whitespace-nowrap px-6 py-4 border-b border-zinc-200 dark:border-white/10">
                                Registration Date</p>
                            <p class="col-span-4 whitespace-nowrap px-6 py-4 border-b border-zinc-200 dark:border-white/10">{{ $user->created_at }}</p>
                            <p class="col-span-2 bg-zinc-300 whitespace-nowrap px-6 py-4 border-b border-zinc-200 dark:border-white/10">
                                Role</p>
                            @if(!empty($user->getRoleNames()))
                                @foreach($user->getRoleNames() as $v)
                                    <p class="col-span-4 whitespace-nowrap px-6 py-4 border-b border-zinc-200 dark:border-white/10 ">{{ $v }}</p>
                                @endforeach
                            @endif
                        </section>

                        <footer
                            class="grid gid-cols-1 px-6 py-4 border-b border-neutral-200 font-medium text-zinc-800 dark:border-white/10">

                            <form action="{{ route('users.destroy', $user) }}"
                                  method="POST"
                                  class="flex gap-4">
                                @csrf
                                @method('DELETE')

                                <x-primary-link-button href="{{ route('users.index', $user) }}" class="bg-zinc-800">
                                    <span>Back</span>
                                </x-primary-link-button>
                                @auth
                                    @if(auth()->user()->id === $user->id || auth()->user()->id === $user->user_id || auth()->user()->hasRole('Superuser') || auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Staff') )
                                        <x-primary-link-button href="{{ route('users.edit', $user) }}"
                                                               class="bg-zinc-800">
                                            <span>Edit</span>
                                        </x-primary-link-button>
                                        <x-secondary-button type="submit" class="bg-zinc-200">
                                            <span>Delete</span>
                                        </x-secondary-button>
                                    @endif
                                @endauth
                            </form>
                        </footer>
                    </div>

                </section>

            </section>

        </div>

    </article>
</x-app-layout>
