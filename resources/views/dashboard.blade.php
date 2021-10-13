<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex flex-col-2">
            {{ __('Dashboard') }}
            @if (Auth()->user()->isEmployee())  
                <div class="sm:flex space-x-2 pl-4">
                    @if (Auth()->user()->isAdmin())  
                        <a 
                            href="#"
                            class="bg-blue-500 uppercase text-xs text-gray-100
                            font-extrabold py-2 px-5 rounded-3xl">
                            {{ __('lang.usrmgt') }}
                        </a>  
                    @endif

                    <a 
                        href="#"
                        class="bg-blue-500 uppercase text-xs text-gray-100
                        font-extrabold py-2 px-5 rounded-3xl">
                        {{ __('lang.postmgt') }}
                    </a>  

                    <a 
                        href="#"
                        class="bg-blue-500 uppercase text-xs text-gray-100
                        font-extrabold py-2 px-5 rounded-3xl">
                        {{ __('lang.invmgt') }}
                    </a>  
                </div>
            @endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    You're logged in!
                </div>
            </div>
        </div>
        {{-- this is admin or moderator --}}
        @if (Auth()->user()->isEmployee())  
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        Admin panel
                    </div>
                </div>
            </div>
        @endif
    </div>
    {{-- @php
        dd(Auth()->user()->roles());
    @endphp --}}
    
    
</x-app-layout>
