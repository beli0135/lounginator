<x-app-layout>
  
    <x-slot name="header">

        <div class="space-x-4 -my-px ml-8 flex w-full">    
            <h2 class="font-semibold text-xl text-gray-800 leading-tight ">
                {{ __('lang.usrmgt') }}                
            </h2>
            
            <div class="pl-4">
                {{-- <a 
                    href="#"
                    class="bg-blue-500 uppercase text-xs text-gray-100
                    font-extrabold py-3 px-5 rounded-3xl">
                    {{ __('lang.tweet') }}
                </a>     --}}
                <a href="{{route('admin.userindex')}}" title="{{ __('lang.refresh') }}">
                    <img class="pl-1" src="{{ asset('/images/refresh.png') }}" alt="{{ __('lang.refresh') }}" width="24">
                </a>
            </div>
            <div>
                {{-- <a class="modal-open cursor-pointer" title="{{ __('lang.createTweet') }}">
                        <img class="pl-1" src="{{ asset('/images/writing.png') }}" alt="{{ __('lang.tweet') }}" width="24">
                </a>         --}}
            </div>
            
        </div>
    </x-slot>

    <div>
        <div>

        </div>
        <br>
        <table class="table-auto">
            <thead class="bg-gray-50">
              <tr>
                <th class="mr-1 px-1 py-2 text-xs text-gray-500 text-left w-10">Id</th>
                <th class="px-1 py-2 text-xs text-gray-500 text-left">Username</th>
                <th class="px-1 py-2 text-xs text-gray-500 text-left">Name</th>
                <th class="px-1 py-2 text-xs text-gray-500 text-left">E-mail</th>
                <th class="px-1 py-2 text-xs text-gray-500 text-left">Invited by</th>
                <th class="px-1 py-2 text-xs text-gray-500 text-left">Active</th>
                <th class="px-1 py-2 text-xs text-gray-500 text-left">Reactivate</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="px-1 py-2 text-xs text-gray-500">
                        <td class="">{{ $user->id }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->invited_by }}</td>
                        <td class="text-center">{{ $user->active }}</td>
                        <td>{{ ($user->reactivate_at == "0000-00-00 00:00:00")?"":$user->reactivate_at; }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</x-app-layout>
