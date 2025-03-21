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
            <div class="col-md-12 pb-4">
                <div class="card">
                    <div class="card-header bg-white d-flex justify-content-between pb-1">
                        <h5>Delivery Information</h5>
                    </div>
                    <div class="card-body p-1">
                        <div class="table-responsive">
                            <table class="table table-borderless mb-0">
                                <tr>
                                    <td>Name</td>
                                    <td>{{ $item->name }}</td>
                                </tr>
                                <tr>
                                    <td>Phone</td>
                                    <td>{{ $item->phone }}</td>
                                </tr>
                                <tr>
                                    <td>Address</td>
                                    <td>{{ $item->addr }}</td>
                                </tr>
                                <tr>
                                    <td>City:</td>
                                    <td>
                                        @if ($item->is_inside_area)
                                            <span class="badge badge-success">Inside Jeddah</span>
                                        @else
                                            <span class="badge badge-danger">Outside Jeddah</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 pb-4">
                <div class="card">
                    <div class="card-header bg-white d-flex justify-content-between pb-1">
                        <h5>Order Details</h5>
                    </div>
                    <div class="card-body p-1">
                        <div class="table-responsive">
                            <table class="table table-borderless mb-0">
                                <tr>
                                    <td>OrderID</td>
                                    <td>#{{ $item->order_id }}</td>
                                </tr>
                                @can('orders_all')
                                <tr>
                                    <td>User</td>
                                    <td><a href="{{ route('admin.user.show', $item->user_id) }}">{{ $item->user->name ?? $item->name }}</a></td>
                                </tr>
                                @endcan
                                <tr>
                                    <td>Payment Method</td>
                                    <td>{{ $item->payment_method }}</td>
                                </tr>
                                <tr>
                                    <td>Subtotal</td>
                                    <td>{{ $item->subtotal }}{{ setting('site.currency')??null }}</td>
                                </tr>
                                <tr>
                                    <td>Shipping Fee</td>
                                    <td>{{ $item->shipping_fee }}{{ setting('site.currency')??null }}</td>
                                </tr>
                                <tr>
                                    <td>Total</td>
                                    <td>{{ $item->total }}{{ setting('site.currency')??null }}</td>
                                </tr>
                                <tr>
                                    <td>Payment Status</td>
                                    <td>{!! $item->getPaymentStatus() !!}</td>
                                </tr>
                                <tr></tr>
                                    <td>Status</td>
                                    <td>{!! $item->getStatus() !!}</td>
                                </tr>
                                <tr>
                                    <td>Date</td>
                                    <td>{{ $item->created_at->format('d M Y, H:m') }}</td>
                                </tr>
                                @can('orders_all')
                                <tr>
                                    <td></td>
                                    <td>
                                        @if (!$item->is_paid)
                                            <form action="{{ route('admin.orders.payment-confirmed', $item->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')

                                                <button type="submit" class="btn btn-success">
                                                    <i class="bx bx-credit-card"></i> Confirm Payment
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        @if (!$item->is_paid == 'pending' || $item->status == 'processing')
                                        <form action="{{ route('admin.orders.status-update', $item->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')

                                            <div style="max-width: 200px">
                                                <label class="fw-semibold">Order Status:</label>
                                                <select name="status" class="form-control form-select w-100" onchange="this.form.submit()">
                                                    <option value="pending" {{ $item->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="processing" {{ $item->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                                    <option value="completed" {{ $item->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                                    <option value="cancelled" {{ $item->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                </select>
                                                <button type="submit" class="btn btn-primary mt-2">
                                                    <i class="bx bx-check-circle"></i> Update
                                                </button>
                                            </div>
                                        </form>
                                    @endif
                                    </td>
                                </tr>
                                @endcan
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
