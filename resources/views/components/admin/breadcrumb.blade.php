<div class="row">
    <div class="col-sm-12">
        <div class="float-right page-breadcrumb">
            <ol class="breadcrumb m-0">
                {{ $slot }}
            </ol>
        </div>
        @isset($title)
        <h5 class="page-title my-3">{{ $title }}</h5>
        @endisset
    </div>
</div>
