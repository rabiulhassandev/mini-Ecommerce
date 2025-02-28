@props(['view'=>false,'edit'=>false,'delete'=>false])

@if ($view)
@if (isset($delete[1]) and can($delete[1]))
<a href="{{ $view[0] }}" class="btn btn-primary btn-sm btn-circle waves-effect waves-light">
    <i class='bx bx-show' ></i>
</a>
@else
<a href="{{ $view[0] }}" class="btn btn-primary btn-sm btn-circle waves-effect waves-light">
    <i class='bx bx-show' ></i>
</a>
@endif
@endif
@if ($edit)
@if (isset($delete[1]) and can($delete[1]))
<a href="{{ $edit[0] }}" class="btn btn-success btn-sm btn-circle waves-effect waves-light">
    <i class='bx bx-edit-alt' ></i>
</a>
@else
<a href="{{ $edit[0] }}" class="btn btn-success btn-sm btn-circle waves-effect waves-light">
    <i class='bx bx-edit-alt' ></i>
</a>
@endif
@endif
@if ($delete)

@if(isset($delete[1]) and can($delete[1]))
<button onclick="delete_action('{{ $delete[0] }}')" class="btn btn-danger btn-sm btn-circle waves-effect waves-light">
    <i class='bx bx-trash' ></i>
</button>
@else
<button onclick="delete_action('{{ $delete[0] }}')" class="btn btn-danger btn-sm btn-circle waves-effect waves-light">
    <i class='bx bx-trash' ></i>
</button>
@endif
@endif
