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
                        <h5 class="m-0">Update Slider</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.sliders.update', $data->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" name="title" id="title" class="form-control" placeholder="Enter title" value="{{ $data->title }}" required>
                                @error('title')
                                <p class="text-danger pt-2">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="order">order</label>
                                <input type="number" name="order" id="order" placeholder="Enter order" class="form-control" value="{{ $data->order }}" required>
                                @error('order')
                                <p class="text-danger pt-2">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="image" class="font-black">Image (970x400)</label>
                                <input type="file" class="form-control" name="image" id="image"
                                    onchange="get_img_url(this, '#image_url');" placeholder="Select image">
                                <img id="image_url" src="{{ image_url($data->image) }}" width="120px" class="mt-1">
                                @error('image')
                                <p class="text-danger pt-2">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group pt-1 pb-1">
                                <label for="status" class="font-black">Status</label>
                                <select name="status" class="form-control" required>
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
</x-app-layout>
