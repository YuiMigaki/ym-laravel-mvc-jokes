
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
                Jokes (List)
            </h2>
            <div class="order-first">
                <i class="fa-solid fa-user min-w-8 text-white"></i>
            </div>

            @auth
            <form action="{{ route('jokes.search')  }}"
                  method="POST" class="block mx-5">
                @csrf

                <x-text-input type="text" name="keywords" placeholder="Joke search..." value=""
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
            @else
            <form action="{{ route('search')  }}"
                  method="POST" class="block mx-5">
                @csrf

                <x-text-input type="text" name="keywords" placeholder="Joke search..." value=""
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
            @endauth


            <x-primary-link-button href="{{ route('jokes.create') }}"
                                   class="bg-zinc-200 hover:bg-zinc-900 text-zinc-800 hover:text-white">
                <i class="fa-solid fa-user-plus "></i>
                <span class="pl-4">Add Joke</span>
            </x-primary-link-button>

            @auth
                <x-primary-link-button href="{{ route('jokes.trash') }}"
                                       class="bg-zinc-200 hover:bg-zinc-900 text-zinc-800 hover:text-white ml-4
                           @if($trashedCount > 0)
                               text-slate-200 hover:text-slate-600 bg-slate-600 hover:bg-slate-500
                           @else
                               text-slate-600 hover:text-slate-200 bg-slate-200 hover:bg-slate-500
                           @endif
                           duration-300 ease-in-out transition-all space-x-2">
                    <i class="fa fa-trash"></i>
                    {{ $trashedCount ?? 0 }}{{ __('Deleted') }}
                </x-primary-link-button>
            @endauth
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
                            <th scope="col" class="px-6 py-4">Title</th>
                            <th scope="col" class="px-6 py-4">Content</th>
                            <th scope="col" class="px-6 py-4">Category</th>
                            <th scope="col" class="px-6 py-4">Tags</th>
                            <th scope="col" class="px-6 py-4">Author Role</th>
                            <th scope="col" class="px-6 py-4">Actions</th>


                        </tr>
                        </thead>

                        <tbody>
                        @foreach($jokes as $joke)
                            <tr class="border-b border-zinc-300 dark:border-white/10">
                                <td class="whitespace-nowrap px-6 py-4 font-medium">{{ $jokes->firstItem() + $loop->index }}</td>{{--Reference: https://stackoverflow.com/questions/45400398/laravel-use-loop-iteration-with-pagination--}}
                                <td class="whitespace-nowrap px-6 py-4">{{ $joke->title  }}</td>
                                <td class="whitespace-nowrap px-6 py-4">    {!! nl2br(strip_tags($joke->content, '<b><i><font><u><style>')) !!}</td>{{--reference: https://laracasts.com/discuss/channels/laravel/is-it-safe-to-use-nl2bre-in-blade--}}
                                <td class="whitespace-nowrap px-6 py-4">{{ $joke->category }}</td>

                                <td class="whitespace-nowrap px-6 py-4">
                                    <span
                                        class="text-xs text-white bg-zinc-500 px-3 rounded-full min-w-12 inline-block text-center">{{ $joke->tag  }}</span>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">{{ $joke->role ?? 'Not assigned a role' }}</td>


                                <td class="whitespace-nowrap px-6 py-4">
                                    <form action="{{ route('jokes.destroy', $joke) }}"
                                          method="POST"
                                          class="flex gap-4">
                                        @csrf
                                        @method('DELETE')

                                        <x-primary-link-button href="{{ route('jokes.show', $joke) }}"
                                                               class="bg-zinc-800">
                                            <span>Show</span>
                                            <i class="fa-solid fa-eye pr-2 order-first"></i>
                                        </x-primary-link-button>
                                        @auth
                                            @if (auth()->user()->id === $joke->user_id || auth()->user()->hasRole('Superuser') || auth()->user()->hasRole('Staff') )  {{--Check if the current authenticated user is same as the joke's user_id--}}
                                                <x-primary-link-button href="{{ route('jokes.edit', $joke) }}"
                                                                       class="bg-zinc-800">
                                                    <span>Edit</span>
                                                    <i class="fa-solid fa-edit pr-2 order-first"></i>
                                                </x-primary-link-button>
                                            @endif

                                            @if (auth()->user()->id === $joke->user_id || auth()->user()->hasRole('Superuser') || auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Staff') ||
                                                  auth()->user()->hasRole('Admin') && $joke->user_id === auth()->user()->id ||
                                                    auth()->user()->hasRole('Superuser') && $joke->user_id === auth()->user()->id)
                                                <x-secondary-button type="submit"
                                                                    class="bg-zinc-200">
                                                    <span>Delete</span>
                                                    <i class="fa-solid fa-times pr-2 order-first"></i>
                                                </x-secondary-button>


                                                @endif
                                        @endauth
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>

                        <tfoot>
                        <tr class="bg-zinc-100">
                            <td colspan="7" class="px-6 py-2">
                                @if( $jokes->hasPages() )
                                    {{ $jokes->links() }}
                                @elseif( $jokes->total() === 0 )
                                    <p class="text-xl">No jokes found</p>
                                @else
                                    <p class="py-2 text-zinc-800 text-sm">All jokes shown</p>
                                @endif
                            </td>
                        </tr>
                        </tfoot>

                    </table>
                    </div>

                </section>

            </section>

        </div>

    </article>
</x-app-layout>
