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
        <div id="printSection" class="row" style="overflow: auto;">
            <div class="col-12 mx-auto pt-2" style="min-width: 800px;">
                <div class="card p-0">
                    <div class="card-header p-2 px-3 bg-light">
                        <h5 class="float-left mb-0">Invoice #{{ $data->order_id }}</h5>
                        <div class="float-right">{{ $data->created_at->format('d M Y') }}</div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-8">
                                <img src="{{ image_url(setting('site.logo'), admin_asset('images/logo.png')) }}" class="my-1 rounded" style="max-height: 80px; max-width: 150px;">
                                <h5>{{ setting('site.title') ?? null }}</h5>
                                <p class="m-0">{{ setting('contact.address') }}</p>
                                <p>{{ setting('contact.phone') }}, {{ setting('contact.email') }}</p>
                            </div>
                            <div class="col-4">
                                <h5 class="pb-2">Invoice To:</h5>
                                <p class="m-0">{{ $data->name }}</p>
                                <p class="m-0">{{ $data->addr }}</p>
                                <p class="m-0">Phone: {{ $data->phone }}</p>
                            </div>
                        </div>

                        <table class="table table-bordered table-striped text-center">
                            <thead>
                                <tr>
                                    <th style="width: 50px;">#</th>
                                    <th style="max-width: 100px;">Product</th>
                                    <th style="width: 100px;">Quantity</th>
                                    <th>Rate</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data->orderItems as $key=>$item)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td class="text-left">
                                        <p>{{ $item->product->name }}</p>
                                        <p class="p-0 m-0 d-flex" style="align-items: center">
                                            @if ($item->color_id != null)
                                                <small>Color:</small> <span class="color-area" style="background: {{ $item->color->color_code }};"></span>
                                            @endif
                                            @if ($item->size_id != null)
                                                <small>Size:</small> <span class="badge bg-secondary text-white mx-1">{{ $item->size->value }}</span>
                                            @endif
                                        </p>
                                    </td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ $item->rate }}</td>
                                    <td>{{ $item->total }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="100%">
                                        <h5 class="text-center text-danger">No Item Found..!</h5>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="row">
                            <div class="col-6"></div>
                            <div class="col-6">
                                <div class="text-right">
                                    <div class="mb-1">Sub Total: {{ $data->sub_total }}</div>
                                    <div class="mb-1">Shipping Fee: {{ $data->shipping_fee }}</div>
                                    <div class="mb-1">Total: {{ $data->total }}</div>
                                    <br><br><br>
                                    <h5><span class="px-2 border-top">Signature</span></h5>
                                </div>
                            </div>
                            <div class="col-md-12 pt-3 text-center">
                                <p>Invoice created by: Admin</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center">
            <button id="print" class="btn btn-info btn-lg py-2 mt-2"><span class="btn-label"><i class='bx bx-printer bx_large' ></i></span> Print Now</button>
        </div>
    </div>

    @push('extra-styles')
        <style>
            .color-area{
                height: 20px;
                width: 20px;
                margin: 0px 3px;
                border-radius: 50%;
            }

        </style>
    @endpush
    @push('extra-scripts')
        <script type="text/javascript" src="{{ admin_asset('js/printJs/printThis.js') }}"></script>
        <script>

            $(function () {
                //your code here
                $("#print").on("click", function () {
                    $("#printSection").printThis({
                        // importCSS: admin_asset("fonts/SolaimanLipi/font.css"),
                        // loadCSS: admin_asset("css/nid-server-copy/print-view.css"),
                        importStyle: "<style></style>",
                    });
                });
            });

        </script>
    @endpush
</x-app-layout>
