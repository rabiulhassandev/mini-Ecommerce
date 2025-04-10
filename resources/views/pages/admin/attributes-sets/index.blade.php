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
                        <h5>Attributes</h5>
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
                                    <th>Title</th>
                                    <th>Values</th>
                                    <th>Status</th>
                                    <th class="noExport">Action</th>
                                </tr>
                                @forelse ($collection as $key=>$item)
                                <td>
                                    {{ ++$key }}
                                </td>
                                <td>
                                    {{ $item->title }}
                                </td>
                                <td>
                                    @foreach ($item->attributeValues as $value)
                                        <span class="badge badge-primary">{{ $value->value }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    @if ($item->status==true)
                                        <span class="badge bg-success text-white">Active</span>
                                    @else
                                    <span class="badge bg-danger text-white">Inactive</span>
                                    @endif
                                </td>
                                <td class="py-1">
                                    <x-btn.action :edit="[route('admin.attributes-sets.edit',$item->id)]"
                                        :delete="[route('admin.attributes-sets.delete',$item->id)]" />
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
                        <h5 class="m-0">Set Attribute</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.attributes-sets.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="title">title</label>
                                <input type="text" name="title" class="form-control" placeholder="Enter title" value="{{ old('title') }}" required>
                                @error('title')
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
</x-app-layout>
