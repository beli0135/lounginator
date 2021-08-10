<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <x-auth-validation-errors class="mb-4" :errors="$errors" />
                    <x-success-message  />

                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        
                        @if (auth()->user()->profile->nsfw == 0)
                        <div class="inline-flex space-x-4 pb-4"  >
                            <x-input id="nsfw" class="block w-4" type="checkbox" name="nsfw" value="0" />
                            <x-label for="name" class="inline" :value="__('lang.seeNSFW')" />
                         </div>    
                        @endif

                        @if (auth()->user()->profile->nsfw == 1)
                        <div class="inline-flex space-x-4 pb-4"  >
                            <x-input id="nsfw" class="block w-4" type="checkbox" name="nsfw" value="0" checked="checked"/>
                            <x-label for="name" class="inline" :value="__('lang.seeNSFW')" />
                         </div>    
                        @endif
                        
                        <div class="grid gird-cols-2 gap-6">
                            
                            <div class="grid grid-rows-2 gap-6">
                                
                                <div>
                                    <x-label for="name" :value="__('lang.Name')" />
                                    <x-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ auth()->user()->name }}"/>
                                </div>
                                <div>
                                    <x-label for="bio" :value="__('lang.Biography')" />
                                    <x-input id="bio" class="block mt-1 w-full" type="text" name="bio" value="{{ auth()->user()->profile->bio }}"/>
                                </div>
                                <div>
                                    <x-label for="url" :value="__('lang.Site')" />
                                    <x-input id="url" class="block mt-1 w-full" type="text" name="url" value="{{ auth()->user()->profile->url }}"/>
                                </div>
                                <div>
                                    <x-label for="location" :value="__('lang.Location')" />
                                    <x-input id="location" class="block mt-1 w-full" type="text" name="location" value="{{ auth()->user()->profile->location }}"/>
                                </div>
                                <div>
                                    <x-label for="birthday" :value="__('lang.Birthdate')" />
                                    <x-input id="birthday" class="block mt-1 w-full" type="date" name="birthday" value="{{ auth()->user()->profile->birthday }}"/>
                                </div>
                                <div>
                                    <x-label for="image" :value="__('lang.ProfileImage')" />
                                    <x-input id="image" class="block mt-1 w-full" type="file" name="image"/>
                                    @if ($errors->has('image'))
                                      <strong>{{ $errors->first('image')}}</strong>
                                    @endif

                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-3">
                                {{ __('Update') }}
                            </x-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
