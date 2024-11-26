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
                Users (List)
            </h2>
            <div class="order-first">
                <i class="fa-solid fa-user min-w-8 text-white"></i>
            </div>

            <form action="{{ route('users.search')  }}"
                  method="POST" class="block mx-5">
                @csrf
                @method("POST")

                <x-text-input type="text" name="keywords" placeholder="User search..." value=""
                              class="w-full h-1/5 mr-2  md:w-auto px-4 py-2 focus:outline-none text-black"/>

                <x-primary-button type="submit"
                                  class="w-full md:w-auto
                           bg-sky-500 hover:bg-sky-600
                           text-white
                           px-4 py-2
                           focus:outline-none transition ease-in-out duration-500">
                    <i class="fa fa-search"></i> {{ __('Search') }}
                </x-primary-button>
            </form>

            <x-primary-link-button href="{{ route('users.create') }}"
                                   class="bg-zinc-200 hover:bg-zinc-900 text-zinc-800 hover:text-white">
                <i class="fa-solid fa-user-plus "></i>
                <span class="pl-4">Add User</span>
            </x-primary-link-button>

            <x-primary-link-button href="{{ route('users.trash') }}"
                                   class="bg-zinc-200 hover:bg-zinc-900 text-zinc-800 hover:text-white ml-4
                       @if($trashedCount>0)
                            text-slate-200 hover:text-slate-600 bg-slate-600 hover:bg-slate-500
                       @else
                            text-slate-600 hover:text-slate-200 bg-slate-200 hover:bg-slate-500
                       @endif
                       duration-300 ease-in-out transition-all space-x-2">
                <i class="fa fa-trash"></i>
                {{ $trashedCount ?? 0 }}{{ __('Deleted') }}
            </x-primary-link-button>
        </header>

        @auth
            <x-flash-message :data="session()"/>
        @endauth

        <div class="flex flex-col flex-wrap my-4 mt-8">
            <section class="grid grid-rows-1 gap-4 px-4 mt-4 sm:px-8">

                <section class="min-w-full items-center bg-zinc-50 border border-zinc-600 rounded overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-left text-sm font-light text-surface dark:text-white">
                            <thead
                                class="w-full border-b border-neutral-200 bg-zinc-800 font-medium text-white dark:border-white/10">
                            <tr>
                                <th scope="col" class="px-6 py-4">#</th>
                                <th scope="col" class="px-6 py-4">Nickname</th>
                                <th scope="col" class="px-6 py-4">eMail</th>
                                <th scope="col" class="px-6 py-4">Verified and registration date</th>
                                <th scope="col" class="px-6 py-4">Role</th>
                                <th scope="col" class="px-6 py-4">Actions</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($users as $user)
                                <tr class="border-b border-zinc-300 dark:border-white/10">
                                    <td class="whitespace-nowrap px-6 py-4 font-medium">{{ $users->firstItem() + $loop->index}}</td>
                                    <td class="whitespace-nowrap px-6 py-4">{{ $user->nickname }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">{{ $user->email }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">{{ $user->created_at  }}</td>


                                    <td class="px-2">
                                        @if(!empty($user->getRoleNames()))
                                            @foreach($user->getRoleNames() as $v)
                                                <label
                                                    class="text-xs text-white bg-zinc-500 px-3 rounded-full min-w-12 inline-block text-center">{{ $v }}</label>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td class="whitespace-nowrap px-0 py-4">
                                        <form action="{{ route('users.destroy', $user) }}"
                                              method="POST"
                                              class="flex gap-4">
                                            @csrf
                                            @method('DELETE')

                                            @auth
                                                <x-primary-link-button href="{{ route('users.show', $user) }}"
                                                                       class="bg-zinc-800">
                                                    <span>Show </span>
                                                    <i class="fa-solid fa-eye pr-2 order-first"></i>
                                                </x-primary-link-button>
                                                <x-primary-link-button href="{{ route('users.edit', $user) }}"
                                                                       class="bg-zinc-800">
                                                    <span>Edit </span>
                                                    <i class="fa-solid fa-edit pr-2 order-first"></i>
                                                </x-primary-link-button>

                                                <x-secondary-button type="submit"
                                                                    class="bg-zinc-200">
                                                    <span>Delete</span>
                                                    <i class="fa-solid fa-times pr-2 order-first"></i>
                                                </x-secondary-button>
                                            @endauth
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>

                            <tfoot>
                            <tr class="bg-zinc-100">
                                <td colspan="7" class="px-6 py-2">
                                    @if( $users->hasPages() )
                                        {{ $users->links() }}
                                    @elseif( $users->total() === 0 )
                                        <p class="text-xl">No users found</p>
                                    @else
                                        <p class="py-2 text-zinc-800 text-sm">All users shown</p>
                                    @endif
                                </td>
                            </tr>
                            </tfoot>

                        </table>

                </section>

            </section>

        </div>

    </article>
</x-app-layout>
