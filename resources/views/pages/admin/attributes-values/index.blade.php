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

        <div class="row pt-3">
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header bg-white d-flex justify-content-between pb-1">
                        <h5>Attribute Values</h5>
                        <div class="card-header-form">

                            <form action="{{ route('admin.attributes-sets.index') }}">
                                <div class="input-group mb-0">
                                    <input type="text" class="form-control" placeholder="Search Here..." name="search" value="{{ request()->search ?? '' }}" required>
                                    <button class="input-group-append btn btn-primary">
                                        <i class="bx bx-search text-white"></i>
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>
                    <div class="card-body p-1">
                        <div class="table-responsive">
                            <x-data-table>
                                <tr>
                                    <th>#</th>
                                    <th>Attribute</th>
                                    <th>Value</th>
                                    <th>Status</th>
                                    <th class="noExport">Action</th>
                                </tr>
                                @forelse ($collection as $key=>$item)
                                <td>
                                    {{ ++$key }}
                                </td>
                                <td>
                                    {{ $item->attribute->title }}
                                </td>
                                <td>
                                    {{ $item->value }}
                                </td>
                                <td>
                                    @if ($item->status==true)
                                        <span class="badge bg-success text-white">Active</span>
                                    @else
                                    <span class="badge bg-danger text-white">Inactive</span>
                                    @endif
                                </td>
                                <td class="py-1">
                                    <x-btn.action :edit="[route('admin.attributes-values.edit',$item->id)]"
                                        :delete="[route('admin.attributes-values.delete',$item->id)]" />
                                </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6">
                                        <p class="text-danger text-center">No Data Found...</p>
                                    </td>
                                </tr>
                                @endforelse
                            </x-data-table>
                        </div>
                        <div class="mt-2">
                            {{ $collection->links() }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header bg-white">
                        <h5 class="m-0">Add Attribute Value</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.attributes-values.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group py-1">
                                <label for="attribute_id" class="font-black">Attribute</label>
                                <select name="attribute_id" id="attribute_id" class="js-example-basic-single form-control" data-width="100%">
                                    <option disabled selected>-- Select Attribute --</option>
                                    @foreach ($attributes as $key=>$value)
                                        <option value="{{ $value->id }}">
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
                                <input type="text" name="value" class="form-control" placeholder="Enter value" value="{{ old('value') }}" required>
                                @error('value')
                                <p class="text-danger pt-2">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="justify-content-right text-right">
                                <button class="btn btn-success btn-lg py-2 px-4">Save</button>
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
