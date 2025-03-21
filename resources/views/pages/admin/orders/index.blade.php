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
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-white d-flex justify-content-between pb-1">
                        <h5>Orders</h5>
                        <div class="card-header-form">

                            <form action="{{ route('admin.orders.index') }}">
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
                                    <th>Order ID</th>
                                    <th>Details</th>
                                </tr>
                                @forelse ($collection as $key=>$item)
                                <tr>
                                    <td> #{{ $item->order_id }}</td>
                                    <td>
                                        Name:
                                        @if(can('orders_all'))
                                            <a href="{{ route('admin.user.show', $item->user_id) }}">{{ $item->name }}</a>
                                        @else
                                            {{ $item->name }}
                                        @endif
                                        <br>
                                        Phone: {{ $item->phone }} <br>
                                        Is_paid: {!! $item->getPaymentStatus() !!} <br>
                                        Total: {{ $item->total }}{{ setting('site.currency')??null }} <br>
                                        Status: {!! $item->getStatus() !!} <br>
                                        Created At: {{ $item->created_at->format('d M Y') }} <br>

                                        <a href="{{ route('admin.orders.details',$item->order_id) }}" class="btn btn-primary btn-sm rounded-0">Order Details</a>
                                        <a href="{{ route('admin.orders.invoice',$item->order_id) }}" class="btn btn-primary btn-sm rounded-0">Invoice</a>
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
