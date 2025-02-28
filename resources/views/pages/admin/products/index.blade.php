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

                    @if (config('theme.cdata.add'))
                    <a href="{{ config('theme.cdata.add') }}"
                        class="btn btn-success btn-rounded waves-effect waves-light">
                        <i class="bx bx-plus"></i> Add New
                    </a>
                    @endif
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
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-white d-flex justify-content-between pb-1">
                        <h5>Products</h5>
                        <div class="card-header-form">

                            <form action="{{ route('admin.products.index') }}">
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
                                    <th>Thumbnail</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Category</th>
                                    <th>Featured</th>
                                    <th>Today's Deal</th>
                                    <th>Stock</th>
                                    <th>Status</th>
                                    <th class="noExport">Action</th>
                                </tr>
                                @forelse ($collection as $key=>$item)
                                <td>
                                   {{ $item->id }}
                                </td>
                                <td class="py-1">
                                    <img src="{{ image_url($item->thumbnail, admin_asset('images/no-image/800x800.png')) }}" alt="thumbnail" style="height: 40px;" class="rounded">
                                </td>
                                <td>
                                    {{ $item->name }}
                                </td>
                                <td>
                                    {{ $item->unit_price }}{{ setting('site.currency')??'TK' }}
                                </td>
                                <td>
                                    {{ $item->category_id != null ? $item->category->name : null  }}
                                </td>
                                <td>
                                    @if ($item->featured_status==true)
                                        <span class="badge bg-success text-white">Active</span>
                                    @else
                                    <span class="badge bg-danger text-white">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($item->todays_deal_status==true)
                                        <span class="badge bg-success text-white">Active</span>
                                    @else
                                    <span class="badge bg-danger text-white">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($item->stock_status==true)
                                        <span class="badge bg-success text-white">In Stock</span>
                                    @else
                                    <span class="badge bg-danger text-white">Out of Stock</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($item->status==true)
                                        <span class="badge bg-success text-white">Active</span>
                                    @else
                                    <span class="badge bg-danger text-white">Inactive</span>
                                    @endif
                                </td>
                                <td class="py-1">
                                    <x-btn.action :edit="[route('admin.products.edit',$item->id)]"
                                        :delete="[route('admin.products.delete',$item->id)]" />
                                </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10">
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
        </div>
    </div>

</x-app-layout>
