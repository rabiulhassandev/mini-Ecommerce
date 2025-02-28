<footer {{ $attributes->merge(['class'=>'text-center']) }}>
    <x-visitor />

    <div>
        {{ date('Y') }} © {{ config('app.name') }}.
    </div>
    <div>
        Crafted with <i class="mdi mdi-heart text-danger"></i> by <a {{ $attributes->merge(['class'=>'text-center']) }}
            href="https://rabiulhassan.dev/"
            target="_blank">RABIUL
            HASSAN</a>
    </div>
    </div>
</footer>
