@extends('layouts.website')

@section('title', 'Chi tiết đơn hàng #' . $order->order_number)

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Đơn hàng #{{ $order->order_number }}</h5>
                    <span class="badge bg-{{ $order->status == 'pending' ? 'warning' : ($order->status == 'processing' ? 'info' : ($order->status == 'shipped' ? 'primary' : ($order->status == 'delivered' ? 'success' : 'danger'))) }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Thông tin giao hàng</h6>
                            <p class="mb-1"><strong>Tên:</strong> {{ $order->shipping_address['name'] }}</p>
                            <p class="mb-1"><strong>SĐT:</strong> {{ $order->shipping_address['phone'] }}</p>
                            <p class="mb-1"><strong>Địa chỉ:</strong> {{ $order->shipping_address['address'] }}</p>
                            <p class="mb-0"><strong>Thành phố:</strong> {{ $order->shipping_address['city'] }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6>Thông tin đơn hàng</h6>
                            <p class="mb-1"><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                            <p class="mb-1"><strong>Phương thức thanh toán:</strong> 
                                {{ $order->payment_method == 'cash_on_delivery' ? 'Thanh toán khi nhận hàng' : 'Chuyển khoản ngân hàng' }}
                            </p>
                            <p class="mb-0"><strong>Trạng thái thanh toán:</strong> 
                                <span class="badge bg-{{ $order->payment_status == 'paid' ? 'success' : 'warning' }}">
                                    {{ $order->payment_status == 'paid' ? 'Đã thanh toán' : 'Chưa thanh toán' }}
                                </span>
                            </p>
                        </div>
                    </div>
                    
                    @if($order->notes)
                    <div class="mt-3">
                        <h6>Ghi chú</h6>
                        <p class="text-muted">{{ $order->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>
            
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="mb-0">Sản phẩm đã đặt</h5>
                </div>
                <div class="card-body">
                    @foreach($order->orderItems as $item)
                    <div class="row align-items-center border-bottom py-3">
                        <div class="col-md-2">
                            <img src="https://via.placeholder.com/80x80/6f42c1/ffffff?text={{ urlencode($item->product->name) }}" 
                                 class="img-fluid rounded" alt="{{ $item->product->name }}">
                        </div>
                        <div class="col-md-4">
                            <h6 class="mb-1">{{ $item->product->name }}</h6>
                            <p class="text-muted small mb-0">{{ $item->product->brand }} - {{ $item->product->volume }}</p>
                        </div>
                        <div class="col-md-2">
                            <span class="text-muted">{{ number_format($item->unit_price) }}đ</span>
                        </div>
                        <div class="col-md-2">
                            <span class="text-muted">{{ $item->quantity }}</span>
                        </div>
                        <div class="col-md-2 text-end">
                            <strong>{{ number_format($item->total_price) }}đ</strong>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Tổng kết đơn hàng</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tạm tính:</span>
                        <span>{{ number_format($order->subtotal) }}đ</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Thuế (10%):</span>
                        <span>{{ number_format($order->tax_amount) }}đ</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Phí vận chuyển:</span>
                        <span>{{ number_format($order->shipping_amount) }}đ</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-3">
                        <strong>Tổng cộng:</strong>
                        <strong class="text-primary">{{ number_format($order->total_amount) }}đ</strong>
                    </div>
                </div>
            </div>
            
            <div class="mt-3">
                <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary w-100">
                    <i class="fas fa-arrow-left me-2"></i>Quay lại danh sách đơn hàng
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
