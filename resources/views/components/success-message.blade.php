@if (session('message'))
    <div {{ $attributes }}>
        <div class="font-medium text-blue-600">
            <strong>{{ __('Success') }}</strong>
        </div>

        <ul class="mt-3 list-disc list-inside text-sm text-blue-600 pb-4">
            {{ session('message') }}
        </ul>
    </div>
@endif
