<x-app-layout>
    <x-slot name="breadcrumb">
        <x-admin.breadcrumb>
            @foreach (config('theme.cdata.breadcrumb') as $i )
            <x-admin.bread-item href="{{ $i['link'] }}" class="{{ $i['link']?'':'active' }}">
                {{ $i['name'] }}
            </x-admin.bread-item>
            @endforeach
            <x-slot name="title">
                {{ config('theme.cdata.title') }}
            </x-slot>
        </x-admin.breadcrumb>
    </x-slot>

    <div class="container">
        <div name="title">
            <div class="d-sm-flex justify-content-end">
                <div>

                    @if (config('theme.cdata.back'))
                    <a href="{{ config('theme.cdata.back') }}"
                        class="btn btn-info btn-rounded waves-effect waves-light">
                        <i class="bx bx-share"></i> Back
                    </a>
                    @endif
                </div>
            </div>
        </div>

        <div class="row pt-4">
            <div class="col-md-5 mx-auto">
                <div class="card">
                    <div class="card-header bg-white">
                        <h5 class="m-0">Attributes Update</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.attributes-values.update', $data->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group py-1">
                                <label for="attribute_id" class="font-black">Attribute</label>
                                <select name="attribute_id" id="attribute_id" class="js-example-basic-single form-control" data-width="100%">
                                    <option disabled selected>-- Select Attribute --</option>
                                    @foreach ($attributes as $key=>$value)
                                        <option value="{{ $value->id }}" {{ selected($value->id, $data->attribute_id) }}>
                                            {{ $value->title }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('attribute_id')
                                <p class="text-danger pt-2">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="value">Value</label>
                                <input type="text" name="value" class="form-control" placeholder="Enter Value" value="{{ $data->value }}" required>
                                @error('value')
                                <p class="text-danger pt-2">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group pt-1 pb-1">
                                <label for="status" class="font-black">Status</label>
                                <select name="status" class="js-example-basic-single form-control" required>
                                    <option value="1" {{ $data->status==true ? 'selected':null }}>Active</option>
                                    <option value="0" {{ $data->status==false ? 'selected':null }}>Inactive</option>
                                </select>
                                @error('status')
                                <p class="text-danger pt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="justify-content-right text-right">
                                <button class="btn btn-success btn-lg py-2 px-4">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('extra-styles')
        <link rel="stylesheet" href="{{ admin_asset('libs/select2/css/select2.min.css') }}">
    @endpush
    @push('extra-scripts')
        <script src="{{ admin_asset('libs/select2/js/select2.min.js') }}"></script>
        <script src="{{ admin_asset('js/select2.js') }}"></script>
    @endpush
</x-app-layout>
