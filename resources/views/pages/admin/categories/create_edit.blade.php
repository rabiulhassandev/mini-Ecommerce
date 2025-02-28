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
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header bg-white">
                        <h5 class="m-0">{{ config('theme.cdata.title') }}</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ config('theme.cdata.edit')?config('theme.cdata.update'):config('theme.cdata.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @if(config('theme.cdata.edit'))
                            @method('PUT')
                            @endif

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" id="name" class="form-control slug-input" placeholder="Enter Category Name" value="{{ config('theme.cdata.edit')?$data->name:old('name') }}" onkeyup="slugGen(this.val())" required>
                                        @error('name')
                                        <p class="text-danger pt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="slug">Slug</label>
                                        <input type="text" name="slug" id="slug" placeholder="Enter category slug" class="form-control slug-output" value="{{ config('theme.cdata.edit')?$data->slug:old('slug') }}" required>
                                        @error('slug')
                                        <p class="text-danger pt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group py-1">
                                        <label for="parent_id" class="font-black">Root Category</label>
                                        <select name="parent_id" id="parent_id" class="js-example-basic-single form-control" data-width="100%">
                                            <option value="0">-- Select Category --</option>
                                            @foreach ($categories as $key=>$value)
                                                @if ($value->id != (config('theme.cdata.edit')?$data->id:0))
                                                <option value="{{ $value->id }}" {{ config('theme.cdata.edit')?selected( $data->parent_id,$value->id):null}}>
                                                    {{ $value->name }}
                                                </option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('parent_id')
                                        <p class="text-danger pt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="order">Order</label>
                                        <input type="number" name="order" id="order" placeholder="Category Order" class="form-control order-output" value="{{ config('theme.cdata.edit')?$data->order:old('order') }}" required>
                                        @error('order')
                                        <p class="text-danger pt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-0">
                                        <label for="thumbnail" class="font-black">Thumbnail (150x150)</label>
                                        <input type="file" class="form-control" name="thumbnail" id="thumbnail"
                                            onchange="get_img_url(this, '#thumbnail_url');" placeholder="Select Thumbnail">
                                        <img id="thumbnail_url" src="{{ config('theme.cdata.edit')?image_url($data->thumbnail):null }}" width="80px"
                                            class="mt-1">
                                        @error('thumbnail')
                                        <p class="text-danger pt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-0">
                                        <label for="banner" class="font-black">Banner (835x200)</label>
                                        <input type="file" class="form-control" name="banner" id="banner"
                                            onchange="get_img_url(this, '#banner_url');" placeholder="Select Banner">
                                        <img id="banner_url" src="{{ config('theme.cdata.edit')?image_url($data->banner):null }}" width="120px"
                                            class="mt-1">
                                        @error('banner')
                                        <p class="text-danger pt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status" class="font-black">Status</label>
                                        <select name="status" class="form-control" required>
                                            <option value="1" {{ config('theme.cdata.edit')?selected( $data->status,true):null }}>Active</option>
                                            <option value="0" {{ config('theme.cdata.edit')?selected( $data->status,false):null }}>Inactive</option>
                                        </select>
                                        @error('status')
                                        <p class="text-danger pt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="meta_title">Meta title</label>
                                        <input type="text" name="meta_title" class="form-control" placeholder="Enter meta title" value="{{ config('theme.cdata.edit')?$data->meta_title:old('meta_title') }}" required>
                                        @error('meta_title')
                                        <p class="text-danger pt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="meta_desc">Meta Description</label>
                                        <textarea name="meta_desc" id="meta_desc" class="form-control" style="min-height: 80px;" placeholder="Write a meta description">{{ config('theme.cdata.edit')?$data->meta_desc:old('meta_desc') }}</textarea>
                                        @error('meta_desc')
                                        <p class="text-danger pt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="justify-content-left text-left pt-2">
                                        <button class="btn btn-success btn-lg py-2 px-4 mt-4">Submit</button>
                                    </div>
                                </div>
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
