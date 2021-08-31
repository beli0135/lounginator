<x-app-layout>
    <x-slot name="header">
        <div class="space-x-4 -my-px ml-8 flex w-full">    
            <h2 class="font-semibold text-xl text-gray-800 leading-tight ">
                {{ __('lang.timeline') }}                
            </h2>
            
            <div class="">
                <a 
                    href="#"
                    class="bg-blue-500 uppercase text-xs text-gray-100
                    font-extrabold py-3 px-5 rounded-3xl">
                    {{ __('lang.tweet') }}
                </a>    
            </div>
        </div>
    </x-slot>

    

    <div class="flex py-12 flex-col-3 ">
        <div class="bg-gray-300 w-1/4 hidden md:block">
            <p>1</p>
            
            <a href="/tweets/h/hash">hash</a>
        </div>

        <div class="w-4/6 visible " >
            @foreach ($posts as $post)
                @if ($post->tweet == '')
                    @continue
                @endif
                <div class="flex flex-col-2 pt-1" id="{{ $post->id }}">
                    <div class="inline w-20 pr-2 pl-1 align-middle">
                        <img class="rounded-full border border-gray-100 shadow-sm h-14 w-14 flex items-center justify-center" src="{{ $post->user->profile->image }}"  alt="" >
                    </div>
                    <div class="w-full">
                        <div class="flex flex-col-4 align-middle">
                            <small>
                                <span class="text-gray-500 text-s">
                                    <span class="font-bold italic text-gray-800">
                                        {{ $post->user->name }}
                                    </span>
                                    {{ '@'.$post->user->username }} - {{ $post->getPassedTime() }}
                                </span>
                            </small>
                            <div class="w-full"></div>
                            
                            <x-dropdown align="right" width="100" class="pr-3">
                                <x-slot name="trigger">
                                    <div class="ml-1 flex flex-col-2 align-baseline">
                                    <img src="{{ asset('/images/3dots30.png') }}" class="rounded-full border border-gray-100 shadow-sm h-4 w-4 flex items-center justify-center" alt="">
                                    
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </x-slot> 
                                
                                <x-slot name="content">
                                    
                                    <form method="POST" action="{{ route('tweets.makeUserFavorite') }}#anchor">
                                        @csrf
                                        <x-dropdown-link :href="route('tweets.makeUserFavorite')"
                                                onclick="event.preventDefault();
                                                this.closest('form').submit();">

                                            <div class="flex flex-col-2 w-32 space-x-2" >
                                                <img src="{{ asset('/images/heartadd.png') }}" width="24">
                                                <p>Favorite user</p>
                                            </div>
                                            <input type="hidden" name="id" value="{{ $post->id }}">
                                            <input type="hidden" name="user_id" value="{{ $post->user_id }}">
                                            
                                        </x-dropdown-link>
                                    </form>
                                    
                                    <x-dropdown-link :href="route('profile')">
                                        <div class="flex flex-col-2 w-32 space-x-2" >
                                            <img src="{{ asset('/images/mute.png') }}" width="24">
                                            <p>Mute user</p>
                                        </div>
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('profile')">
                                        <div class="flex flex-col-2 w-32 space-x-2" >
                                            <img src="{{ asset('/images/blocked.png') }}" width="24">
                                            <p>Block user</p>
                                        </div>
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('profile')">
                                        <div class="flex flex-col-2 w-32 space-x-2" >
                                            <img src="{{ asset('/images/flag.png') }}" width="24">
                                            <p>Report tweet</p>
                                        </div>
                                    </x-dropdown-link>
                                </x-slot>    
                            </x-dropdown>
                            <div class="w-2"></div>
                        </div>  
                        <div>
                            <p class="text-l text-gray-700 pt-1 pb-5 leading-8 font-light">
                                {!! html_entity_decode( $post->tweet) !!}
                            </p>
                        </div>
                        
                    </div>
                </div>
                <hr>
            @endforeach
            {{$posts->links()}}  {{-- adds pagination links--}}
        </div>

        <div class="pl-3 w-1/5  hidden md:block">
            {{-- <x-auth-validation-errors class="mb-4" :errors="$errors" />
            <x-success-message class="mb-2 text-sm text-blue-700" /> --}}
            @if (session()->has('message'))
                <div class="w-full rounded-2xl bg-green-500  align-middle justify-items-center">
                    <strong><p class="pl-2 text-sm text-gray-200 justify-center">
                        {{ session()->get('message') }}
                    </p></strong>
                </div>
            @endif
            @if (session()->has('error'))
                <div class="w-full rounded-2xl bg-red-500  align-middle justify-items-center">
                    <strong><p class="pl-2 text-sm text-gray-200 justify-center">
                        {{ session()->get('error') }}
                    </p></strong>
                </div>
            @endif
        </div>
    </div>

</x-app-layout>