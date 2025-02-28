<x-front-layout>
    <div class="container mt-50">
        @isset($page)
            @foreach ($page as $data)
            {!! $data->body !!}
            @endforeach
        @endisset
    </div>
</x-front-layout>
