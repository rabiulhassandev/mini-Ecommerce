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

            @if(config('theme.cdata.edit'))
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-white">
                        <h5 class="m-0">Product Images</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">


                            @forelse ($data->productImages as $image)
                            <div class="col-4 px-2 mt-2 text-center">
                                <img src="{{ image_url($image->url, admin_asset('images/no-image/800x800.png')) }}" alt="Product Img" class="w-100 rounded">
                                <div>
                                    <a href="{{ route('admin.products.product-image-delete', $image->id) }}"><span class="badge bg-danger text-white w-100"> Remove </span></a>
                                </div>
                            </div>
                            @empty
                            <div class="col-md-12">
                                <p class="py-2 text-center text-danger"><b>No Photo Available!</b></p>
                            </div>
                            @endforelse
                            <div class="col-md-12 mt-2 px-0">
                                <div class="card overflow-hidden">
                                    <div class="card-body" style="background: #cdc9c98a;">
                                        <form action="{{ route('admin.products.product-image-store', $data->id) }}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group mb-0">
                                                <label for="product_image" class="font-black mb-1">Product Image (800x800)</label>
                                                <input type="file" class="form-control" name="product_image" id="product_image"
                                                    onchange="get_img_url(this, '#product_image_url');" placeholder="Select product_image">
                                                <img id="product_image_url" src="{{ config('theme.cdata.edit')?image_url($data->product_image):null }}" width="80px"
                                                    class="mt-1">
                                                @error('product_image')
                                                <p class="text-danger pt-2">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <button class="btn btn-success"> Submit </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endisset

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

                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#basic_tab" role="tab">Basic</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#details_tab" role="tab">Details</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#meta_info_tab" role="tab">Meta Info</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#status_tab" role="tab">Status</a>
                                </li>
                                {{-- <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#others_tab" role="tab">Others</a>
                                </li> --}}
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane active p-3" id="basic_tab" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">Name</label>
                                                <input type="text" name="name" id="name" class="form-control slug-input" placeholder="Enter Product Name" value="{{ config('theme.cdata.edit')?$data->name:old('name') }}" onkeyup="slugGen(this.val())" required>
                                                @error('name')
                                                <p class="text-danger pt-2">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="slug">Slug</label>
                                                <input type="text" name="slug" id="slug" placeholder="Enter product slug" class="form-control slug-output" value="{{ config('theme.cdata.edit')?$data->slug:old('slug') }}" required>
                                                @error('slug')
                                                <p class="text-danger pt-2">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group py-1">
                                                <label for="category_id" class="font-black">Category</label>
                                                <select name="category_id" id="category_id" class="js-example-basic-single form-control" data-width="100%">
                                                    <option selected disabled>-- Select Category --</option>
                                                    @foreach ($categories as $key=>$value)
                                                        <option value="{{ $value->id }}" {{ config('theme.cdata.edit')?selected( $data->category_id,$value->id):null}}>
                                                            {{ $value->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('category_id')
                                                <p class="text-danger pt-2">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="unit">Unit</label>
                                                <input type="text" name="unit" id="unit" placeholder="Unit (e.g kg. pc. etc)" class="form-control" value="{{ config('theme.cdata.edit')?$data->unit:old('unit') }}" required>
                                                @error('unit')
                                                <p class="text-danger pt-2">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="min_order_qty">Min. Order Quantity</label>
                                                <input type="number" name="min_order_qty" id="min_order_qty" placeholder="Min. Order Quantity" class="form-control" value="{{ config('theme.cdata.edit')?$data->min_order_qty:old('min_order_qty') }}" required>
                                                @error('min_order_qty')
                                                <p class="text-danger pt-2">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="unit_price">Unit Price</label>
                                                <input type="text" name="unit_price" id="unit_price" placeholder="Unit Price" class="form-control" value="{{ config('theme.cdata.edit')?$data->unit_price:old('unit_price') }}" required>
                                                @error('unit_price')
                                                <p class="text-danger pt-2">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="sku">SKU</label>
                                                <input type="text" name="sku" id="sku" placeholder="SKU" class="form-control" value="{{ config('theme.cdata.edit')?$data->sku: Str::random(15) }}" required>
                                                @error('sku')
                                                <p class="text-danger pt-2">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="shipping_days">Shipping Days</label>
                                                <input type="number" name="shipping_days" id="shipping_days" placeholder="Shipping Days" class="form-control" value="{{ config('theme.cdata.edit')?$data->shipping_days:old('shipping_days') }}" required>
                                                @error('shipping_days')
                                                <p class="text-danger pt-2">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-0">
                                                <label for="thumbnail" class="font-black">Thumbnail (800x800)</label>
                                                <input type="file" class="form-control" name="thumbnail" id="thumbnail"
                                                    onchange="get_img_url(this, '#thumbnail_url');" placeholder="Select Thumbnail">
                                                <img id="thumbnail_url" src="{{ config('theme.cdata.edit')?image_url($data->thumbnail):null }}" width="80px"
                                                    class="mt-1">
                                                @error('thumbnail')
                                                <p class="text-danger pt-2">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane p-3" id="details_tab" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="short_desc">Short Description</label>
                                                <textarea name="short_desc" id="short_desc" class="form-control elm1" style="min-height: 80px;" placeholder="Write a short description (Less than 200 word)">{{ config('theme.cdata.edit')?$data->short_desc:old('short_desc') }}</textarea>
                                                @error('short_desc')
                                                <p class="text-danger pt-2">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="long_desc">Long Description</label>
                                                <textarea name="long_desc" id="long_desc" class="form-control elm1" style="min-height: 80px;" placeholder="Write a long description...">{{ config('theme.cdata.edit')?$data->long_desc:old('long_desc') }}</textarea>
                                                @error('long_desc')
                                                <p class="text-danger pt-2">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        {{-- <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="additional_info">Additional Description</label>
                                                <textarea name="additional_info" id="additional_info" class="form-control elm1" style="min-height: 80px;" placeholder="Additional Description">{{ config('theme.cdata.edit')?$data->additional_info:old('additional_info') }}</textarea>
                                                @error('additional_info')
                                                <p class="text-danger pt-2">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                                <div class="tab-pane p-3" id="meta_info_tab" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="meta_keywords">Meta Keywords</label>
                                                <input type="text" name="meta_keywords" class="form-control" placeholder="Meta Keywords (e.g iPhone, mobile, brand)" value="{{ config('theme.cdata.edit')?$data->meta_keywords:old('meta_keywords') }}" required>
                                                @error('meta_keywords')
                                                <p class="text-danger pt-2">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="meta_title">Meta title</label>
                                                <input type="text" name="meta_title" class="form-control" placeholder="Enter meta title" value="{{ config('theme.cdata.edit')?$data->meta_title:old('meta_title') }}" required>
                                                @error('meta_title')
                                                <p class="text-danger pt-2">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="meta_desc">Meta Description</label>
                                                <textarea name="meta_desc" id="meta_desc" class="form-control" style="min-height: 80px;" placeholder="Write a meta description">{{ config('theme.cdata.edit')?$data->meta_desc:old('meta_desc') }}</textarea>
                                                @error('meta_desc')
                                                <p class="text-danger pt-2">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane p-3" id="status_tab" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="featured_status" class="font-black">Featured Status</label>
                                                <select name="featured_status" class="form-control" required>
                                                    <option value="0" {{ config('theme.cdata.edit')?selected( $data->featured_status,false):null }}>Inactive</option>
                                                    <option value="1" {{ config('theme.cdata.edit')?selected( $data->featured_status,true):null }}>Active</option>
                                                </select>
                                                @error('featured_status')
                                                <p class="text-danger pt-2">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="todays_deal_status" class="font-black">Today's Deal Status</label>
                                                <select name="todays_deal_status" class="form-control" required>
                                                    <option value="0" {{ config('theme.cdata.edit')?selected( $data->todays_deal_status,false):null }}>Inactive</option>
                                                    <option value="1" {{ config('theme.cdata.edit')?selected( $data->todays_deal_status,true):null }}>Active</option>
                                                </select>
                                                @error('todays_deal_status')
                                                <p class="text-danger pt-2">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="stock_status" class="font-black">stock_status</label>
                                                <select name="stock_status" class="form-control" required>
                                                    <option value="1" {{ config('theme.cdata.edit')?selected( $data->stock_status,true):null }}>In Stock</option>
                                                    <option value="0" {{ config('theme.cdata.edit')?selected( $data->stock_status,false):null }}>Out Of Stock</option>
                                                </select>
                                                @error('stock_status')
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
                                    </div>
                                </div>
                                {{-- <div class="tab-pane p-3" id="others_tab" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group py-1">
                                                <label for="attribute_id" class="font-black">Attribute</label>
                                                <select id="attribute_id" class="js-example-basic-single form-control" data-width="100%">
                                                    <option selected disabled>-- Select Attribute --</option>
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
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group py-1">
                                                <label for="attribute_value_id" class="font-black">Attribute Value</label>
                                                <select id="attribute_value_id" class="js-example-basic-single form-control" data-width="100%"></select>
                                                @error('attribute_value_id')
                                                <p class="text-danger pt-2">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group py-1">
                                                <div class="pt-2" id="selected_values_area">
                                                    @if(isset($data) && $data->attr_value_id != null)
                                                    @foreach (json_decode ($data->attr_values) as $attr_value)
                                                    <span class="selected_attr_value_item selected_attr_value_item_{{ $attr_value->id }} border-success rounded py-1 pr-2">
                                                        <input type="text" name="attr_value_id[]" class="attr_value_input" value="{{ $attr_value->id }}">
                                                        <span>{{ $attr_value->value }}</span>
                                                        <span class="text-danger  selected_attr_value_item_remove selected_attr_value_item_remove_{{ $attr_value->id }}" onclick="elementRemove('{{ $attr_value->id }}')"><i class="bx bx-trash"></i></span>
                                                    </span>
                                                    @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>

                            <div class="text-center">
                                <button class="btn btn-success btn-lg py-2 px-4">Submit</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('extra-styles')
        <link rel="stylesheet" href="{{ admin_asset('libs/select2/css/select2.min.css') }}">

        <style>
            .attr_value_input{
                visibility: hidden;
                width: 0px;
                height: 0px;
            }
            .selected_attr_value_item{
                border: 1px solid;
                margin: 3px;
            }
            .selected_attr_value_item_remove{
                cursor: pointer;
            }
        </style>
    @endpush
    @push('extra-scripts')
        <script src="{{ admin_asset('libs/select2/js/select2.min.js') }}"></script>
        <script src="{{ admin_asset('js/select2.js') }}"></script>
        <script src="{{ admin_asset('plugins/tinymce/tinymce.min.js') }}"></script>

        <script>
            $(document).ready(function () {
                if($(".elm1").length > 0){
                    tinymce.init({
                        selector: "textarea.elm1",
                        theme: "modern",
                        height:200,
                        plugins: [
                            "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                            "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                            "save table contextmenu directionality emoticons template paste textcolor"
                        ],
                        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",
                        style_formats: [
                            {title: 'Bold text', inline: 'b'},
                            {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
                            {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
                            {title: 'Example 1', inline: 'span', classes: 'example1'},
                            {title: 'Example 2', inline: 'span', classes: 'example2'},
                            {title: 'Table styles'},
                            {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
                        ]
                    });
                }
            });


            // load attribute values
            $('#attribute_id').on('change', function (e) {
                var attribute_id = $('#attribute_id').val();

                if(attribute_id != ''){
                    $('#attribute_value_id').html('<option value="">Loading...</option>');

                    axios.post('{{ route('home.attribute-values') }}', {
                        id: attribute_id
                    })
                    .then(res => {
                        if(res.data.length > 0){
                            $('#attribute_value_id').html('<option disabled selected>-- Select Attribute Value --</option>');
                            res.data.forEach(element => {
                                var newOption = new Option(element.value, element.id, false, false);
                                $('#attribute_value_id').append(newOption).trigger('change');
                            });
                        }else{
                            $('#attribute_value_id').html('<option disabled selected>No Data Found!</option>');
                        }
                    })
                    .catch(err => {
                        console.error(err);
                    })
                }
            });

            // load attribute values
            $('#attribute_value_id').on('change', function (e) {
                var attribute_value_id = $('#attribute_value_id').val();

                if(attribute_value_id != null){
                    axios.post('{{ route('home.attribute-value-details') }}', {
                        id: attribute_value_id
                    })
                    .then(res => {
                        if(res.data.status){
                            $('#selected_values_area').append('<span class="selected_attr_value_item selected_attr_value_item_'+res.data.data.id+' border-success rounded py-1 pr-2"><input type="text" name="attr_value_id[]" class="attr_value_input" value="'+res.data.data.id+'"><span>'+res.data.data.value+'</span><span class="text-danger  selected_attr_value_item_remove selected_attr_value_item_remove_'+res.data.data.id+'" onclick="elementRemove('+res.data.data.id+')"><i class="bx bx-trash"></i></span></span>');
                        }else{
                            alert("No Data Found");
                        }
                    })
                    .catch(err => {
                        console.error(err);
                    })
                }
            });

            // element remove
            function elementRemove(id){
                $('.selected_attr_value_item_remove_' + id).parent('.selected_attr_value_item_' + id).remove();
            }

        </script>
    @endpush

</x-app-layout>
