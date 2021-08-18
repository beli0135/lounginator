<x-app-layout>
    <x-slot name="header">
        <div class="space-x-8 sm:-my-px sm:ml-10 sm:flex">    
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('lang.EditArticle') }}
                
            </h2>
            
        </div>
    </x-slot>

    @if ($errors->any())
        <div class="w-4/5 m-auto">
            <ul>
                <li><strong>Errors:</strong></li>
                @foreach ($errors->all() as $error)
                    <li class="text-red-500 ">
                        {{ $error }}
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200" >
                   

                    <form 
                        action="/posts/{{ $post->slug }}"
                        method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="block mt-4">
                            <label for="isNSFW" class="inline-flex items-center">
                                <input id="isNSFW" type="checkbox" class="rounded border-gray-300 text-indigo-600 
                                shadow-sm focus:border-indigo-300 
                                focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="nsfw">
                                <span class="ml-2 text-sm text-red-600 font-extrabold" >{{ __('lang.NSFWcontent') }}</span>
                            </label>
                        </div>

                        <div class="pb-4 pt-2">
                            <input 
                                type="text"
                                name="title"
                                value="{{ $post->title }}"
                                class="bg-gray-0 block border-b-1 w-full pb-4
                                h-10 text-xl outline-none">
                        </div>

                        <div>
                            <textarea name="article-textarea" id="article-textarea"
                                class="w-full">
                                {{ $post->article }}
                            </textarea>
                        </div>

                        <div class="bg-white-lighter pt-2 flex flex-col-3">
                            <label class="w-44 h-10 flex flex-col items-center
                             px-1 py-1  bg-blue-600 rounded-3xl shadow-lg 
                             tracking-wide border border-blue cursor-pointer">
                                <span class="mt-1 text-base leading-normal 
                                text-small text-gray-200">
                                    Cover Image
                                </span>
                                <input type="file" name="cvrimg" class="hidden">
                            </label>
                            
                            <div class="w-full"></div>

                            <button
                            type="submit"
                            class="w-44 h-10 mt-0 flex flex-col items-center
                            px-1 py-2  bg-blue-600 rounded-3xl shadow-lg 
                            tracking-wide border text-base leading-normal 
                            text-small text-gray-200
                           border-blue cursor-pointer">
                            Save Article
                        </button>
                        </div>

                        
                        
                    </form>

                   
            
        </div>
    </div>

    @section('scripts')
        @include('admin.ckeditor')
    @endsection
</x-app-layout>