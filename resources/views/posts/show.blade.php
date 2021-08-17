<x-app-layout>
    <x-slot name="header">
        <div class="space-x-8 sm:-my-px sm:ml-10 sm:flex">    
            <h2 class="font-semibold text-xl text-indigo-800 leading-tight w-full">
                {{$post->shortTitle()}}
            </h2>
            @if (Auth::user()->id == $post->user_id)
                <div class="w-full">

                </div>
                <div class="sm:flex space-x-2 ">
                    <a 
                        href="/posts/edit"
                        class="bg-blue-500 uppercase text-xs text-gray-100
                        font-extrabold py-2 px-5 rounded-3xl">
                        {{ __('lang.edit') }}
                    </a>  
                    <a 
                        href="/posts/delete"
                        class="bg-red-500 uppercase text-xs text-gray-100
                        font-extrabold py-2 px-5 rounded-3xl">
                        {{ __('lang.delete') }}
                    </a>  
                </div>
            @endif
        </div>
    </x-slot>

   

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200" >
                    <p class="text-gray-800 font-bold">
                        {{$post->title}}
                    </p>
                    <span class="text-gray-500 text-xs">
                        By <span class="font-bold italic text-gray-800">
                            {{ $post->user->name }}</span>
                            {{ '@'.$post->user->username }}, Created on {{ date(DATE_RFC2822, strtotime($post->updated_at)) }}
                    </span>

                    <p class="text-xl text-gray-700 pt-1 pb-5 leading-8 font-light">
                        {!! html_entity_decode( $post->article) !!}
                    </p>

                </div>    
            </div>            
        </div>
    </div>

    {{-- @section('scripts')
        @include('admin.ckeditor')
    @endsection --}}
</x-app-layout>