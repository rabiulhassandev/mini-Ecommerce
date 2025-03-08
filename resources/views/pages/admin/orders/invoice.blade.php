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
                        <h5 class="float-left mb-0">Invoice #{{ $item->order_id }}</h5>
                        <div class="float-right">{{ $item->created_at->format('d M Y') }}</div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-8">
                                <img src="assets/images/logo.png" class="my-1 rounded" style="max-height: 80px; max-width: 150px;">
                                <h5>{{ setting('site.title') ?? null }}</h5>
                                <p class="m-0">{{ setting('contact.address') }}</p>
                                <p>{{ setting('contact.phone') }}, {{ setting('contact.email') }}</p>
                            </div>
                            <div class="col-4">
                                <h5 class="pb-2">Invoice To:</h5>
                                <p class="m-0">{{ $item->name }}</p>
                                <p class="m-0">{{ $item->addr }}</p>
                                <p class="m-0">Phone: {{ $item->phone }}</p>
                            </div>
                        </div>
        
                        <table class="table table-bordered table-striped text-center">
                            <thead>
                                <tr>
                                    <th style="width: 50px;">SL NO</th>
                                    <th style="max-width: 100px;">Product</th>
                                    <th style="width: 100px;">Quantity</th>
                                    <th>Rate</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($item->orderItems as $key=>$product)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td class="text-left">
                                        {{ $product->product->name }}
                                    </td>
                                    <td>{{ $product->quantity }}</td>
                                    <td>{{ $product->rate }}</td>
                                    <td>{{ $product->total }}</td>
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
                                    <div class="mb-1">Sub Total: {{ $item->sub_total }}</div>
                                    <div class="mb-1">Shipping Fee: {{ $item->shipping_fee }}</div>
                                    <div class="mb-1">Total: {{ $item->total }}</div>
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
            <button onclick="printSection()" class="btn btn-info btn-lg py-2 mt-2"><span class="btn-label"><i class='bx bx-printer bx_large' ></i></span> Print Now</button>
        </div>
    </div>

    @push('extra-scripts')
        <script>
            function printSection() {
                var divContents = document.getElementById("printSection").innerHTML;
                var a = window.open('', '', 'height=1000px, width=1000px');
                a.document.write('<html><head>');
                a.document.write("<meta name='author' content='codedthemes'><link rel='icon' href='assets/images/favicon.ico' type='image/x-icon'><link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600' rel='stylesheet'><link rel='stylesheet' type='text/css' href='assets/css/bootstrap/css/bootstrap.min.css'><link rel='stylesheet' type='text/css' href='assets/icon/themify-icons/themify-icons.css'><link rel='stylesheet' type='text/css' href='assets/icon/font-awesome/css/font-awesome.min.css'><link rel='stylesheet' type='text/css' href='assets/icon/icofont/css/icofont.css'><link rel='stylesheet' type='text/css' href='assets/css/style.css'><link rel='stylesheet' type='text/css' href='assets/css/jquery.mCustomScrollbar.css'>");
                a.document.write("<style>.pcoded-main-container{background: white;} body{background-color: white;}</style>");
                a.document.write('</head><body>');
                a.document.write(divContents);
                a.document.write('</body></html>');
                a.document.close();
                a.print();
            }
        </script>
    @endpush
</x-app-layout>
