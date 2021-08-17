<x-app-layout>
    <x-slot name="header">
        <div class="space-x-8 sm:-my-px sm:ml-10 sm:flex">    
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('lang.Articles') }}
                
            </h2>
            <div class="">
                <a 
                    href="/posts/create"
                    class="bg-blue-500 uppercase text-xs text-gray-100
                    font-extrabold py-3 px-5 rounded-3xl">
                    {{ __('lang.NewArticle') }}
                </a>    
            </div>
        </div>
    </x-slot>

    @if (session()->has('message'))
        <div class="w-4/5 m-auto mt-10 pl-2">
            <p class="w-2/6 mb-4 text-gray-100 bg-green-500 rounded-2xl py-4">
                {{ session()->get('message') }}
            </p>
        </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    @foreach ($posts as $post)
                    <div class="flex bg-gray-200 sm:rounded-lg shadow-sm mt-2">
                        <div class="inline w-20 pr-2 align-middle">
                            <img src="{{ Auth::user()->profile->image }}" width="50" alt="">
                        </div>
                        <div class="inline w-full align-middle pb-0">
                            <h2 class="text-gray-700 font-bold text-l">
                                {{ $post->title }}
                            </h2>
                
                            <small><span class="text-gray-500 text-xs">
                                By <span class="font-bold italic text-gray-800">
                                    {{ $post->user->name }}</span>
                                    {{ '@'.$post->user->username }}, Created on {{ date(DATE_RFC2822, strtotime($post->updated_at)) }}
                            </span></small>
                
                            {{-- <p class="text-xl text-gray-700 pt-8 pb-10 leading-8 font-light">
                                {{ $post->article }}
                            </p> --}}
                        </div>   
                        <div class="w-26 pr-2 pl-2 pt-3 align-middle">
                            <a href="/posts/{{ $post->slug }}" class="uppercase bg-blue-500 text-gray-100 text-sm font-extrabold py-2 px-4 rounded-3xl">
                                Read
                            </a>
                        </div>
                    </div>      
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</x-app-layout>