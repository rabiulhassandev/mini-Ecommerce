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
                        <h5>Colors</h5>
                        <div class="card-header-form">

                            <form action="{{ route('admin.colors.index') }}">
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
                                    <th>Name</th>
                                    <th>Color Code</th>
                                    <th class="noExport">Action</th>
                                </tr>
                                @forelse ($collection as $key=>$item)
                                <td>
                                    {{ ++$key }}
                                </td>
                                <td>
                                    {{ $item->name }}
                                </td>
                                <td>
                                    <span style="color: {{ $item->color_code }};">{{ $item->color_code }}</span>
                                </td>
                                <td class="py-1">
                                    <x-btn.action :edit="[route('admin.colors.edit',$item->id)]"
                                        :delete="[route('admin.colors.delete',$item->id)]" />
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
                        <h5 class="m-0">Add Color</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.colors.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter Color Name" value="{{ old('name') }}" required>
                                @error('name')
                                <p class="text-danger pt-2">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="color_code">Color Code</label>
                                <input type="text" name="color_code" placeholder="Enter Color Code" class="form-control" value="{{ old('color_code') }}" required>
                                @error('color_code')
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
