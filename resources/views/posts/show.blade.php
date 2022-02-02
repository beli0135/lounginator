<x-app-layout>
    <x-slot name="header">
        <div class="space-x-8 sm:-my-px sm:ml-10 sm:flex">    
            <h2 class="font-semibold text-xl text-indigo-800 leading-tight w-full">
                {{$post->shortTitle()}}
            </h2>
            @if (isset(Auth::user()->id) && (Auth::user()->id == $post->user_id))
                <div class="w-full">

                </div>
                <div class="sm:flex space-x-2 ">
                    
                    <a 
                        href="/posts/{{ $post->slug }}/edit"
                        class="bg-blue-500 uppercase text-xs text-gray-100
                        font-extrabold py-2 px-5 rounded-3xl">
                        {{ __('lang.edit') }}
                    </a>  
                    
                    
                    <form  
                        action="/posts/{{ $post->slug }}" 
                        method="POST">
                        @csrf
                        @method('delete')

                        <button 
                            class="bg-red-500 uppercase text-xs text-gray-100
                                font-extrabold py-2 px-5 rounded-3xl"
                                type="submit" onclick="return confirm({{ __('lang.areyousure') }})">
                            {{ __('lang.delete') }}
                        </button>  
                    
                    </form>
                </div>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex flex-col-2">
                    <div class="inline w-20 pr-2 pl-1 align-middle mt-2 ml-2 justify-center">
                        <img class="rounded-full border border-gray-100 shadow-sm h-14 w-14 flex items-center justify-center" src="{{ $post->user->profile->image }}"  alt="" >
                    </div>
                    <div class="p-2 bg-white border-b border-gray-200" >
                        <p class="text-gray-800 font-bold">
                            {{$post->title}}
                        </p>
                        <span class="text-gray-500 text-xs">
                            By <span class="font-bold italic text-gray-800">
                                {{ $post->user->name }}</span>
                                {{ '@'.$post->user->username }}, {{ __('lang.editedOn') }} {{ date(DATE_RFC2822, strtotime($post->getPassedTime())) }}
                        </span>

                        <p class="text-xl text-gray-700 pt-1 pb-5 leading-8 font-light">
                            @if ($post->title != '' ))
                                {!! html_entity_decode( $post->article) !!}
                            @else
                                {!! html_entity_decode( $post->tweet) !!}
                            @endif
                        </p>

                    </div>    
                </div>

                <div class="p-6 bg-white border-b border-gray-200 pb-4" >
                    <div class="pb-4 flex">
                        <p class="text-gray-800 font-bold">{{ $post->articleCommentCount()}} Comments</p>
                        <div class="w-5"></div>
                        <a class="modal-open" title="{{ __('lang.createcomment') }}">
                                <img class="pl-1 cursor-pointer" src="{{ asset('/images/speech-bubble.png') }}"  width="24">
                        </a>        
                        
                    </div>
                    <div class="">
                        @foreach ($post->articleComments as $mainComment)
                            <div class="flex flex-col-2 pt-2">
                                <div class="inline w-20 pr-2 pl-1 align-middle">
                                    <img class="rounded-full border border-gray-100 shadow-sm h-14 w-14 flex items-center justify-center" 
                                        src="{{ $mainComment->ACM_dssProfileImage }}"  alt="" >
                                </div>
                                <div class="w-full">
                                    <div class="pt-2">
                                        <span class="text-gray-500 text-sm">
                                            <span class="font-bold italic text-gray-800">
                                                {{ $mainComment->ACM_dssUserFullName }}
                                            </span>
                                            {{ '@'.$mainComment->ACM_dssUsername }} - {{ $mainComment->getPassedTime() }}
                                        </span>
                                    </div>
                                    <div>
                                        <p class="ml-2 text-gray-800 text-sm" >
                                            @php
                                            if (is_null($mainComment->ACM_image_path) == false) {
                                                $mainComment->ACM_dssComment = $mainComment->ACM_dssComment . '<br>  <a href="'. env('APP_URL') . '/storage/' . 
                                                    $mainComment->ACM_image_path .'"><img src="'. asset('/storage/'.$mainComment->ACM_image_path) . '" width="300"></a>' ;
                                            }
                                            @endphp
                                            {!! html_entity_decode( $mainComment->ACM_dssComment) !!}
                                        </p>
                                    </div>
                                </div>    
                            </div>
                        @endforeach
                    </div>
                </div>    
            </div>

                        
        </div>
    </div>

    

    {{-- @section('scripts')
        @include('admin.ckeditor')
    @endsection --}}

    @include('posts.commentPopup')
    
</x-app-layout>