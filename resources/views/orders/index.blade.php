@extends('layouts.website')

@section('title', 'Đơn hàng của tôi')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Đơn hàng của tôi</h2>
    
    @if($orders->count() > 0)
        <div class="row">
            @foreach($orders as $order)
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Đơn hàng #{{ $order->order_number }}</h6>
                            <small class="text-muted">{{ $order->created_at->format('d/m/Y H:i') }}</small>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-{{ $order->status == 'pending' ? 'warning' : ($order->status == 'processing' ? 'info' : ($order->status == 'shipped' ? 'primary' : ($order->status == 'delivered' ? 'success' : 'danger'))) }}">
                                {{ ucfirst($order->status) }}
                            </span>
                            <div class="mt-1">
                                <strong class="text-primary">{{ number_format($order->total_amount) }}đ</strong>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="row">
                                    @foreach($order->orderItems as $item)
                                    <div class="col-md-6 mb-2">
                                        <div class="d-flex align-items-center">
                                            <img src="https://via.placeholder.com/50x50/6f42c1/ffffff?text={{ urlencode($item->product->name) }}" 
                                                 class="rounded me-2" alt="{{ $item->product->name }}">
                                            <div>
                                                <h6 class="mb-0 small">{{ $item->product->name }}</h6>
                                                <small class="text-muted">{{ $item->quantity }}x {{ number_format($item->unit_price) }}đ</small>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-md-4 text-end">
                                <div class="mb-2">
                                    <small class="text-muted">Phương thức thanh toán:</small><br>
                                    <span>{{ $order->payment_method == 'cash_on_delivery' ? 'Thanh toán khi nhận hàng' : 'Chuyển khoản ngân hàng' }}</span>
                                </div>
                                <div class="mb-2">
                                    <small class="text-muted">Trạng thái thanh toán:</small><br>
                                    <span class="badge bg-{{ $order->payment_status == 'paid' ? 'success' : 'warning' }}">
                                        {{ $order->payment_status == 'paid' ? 'Đã thanh toán' : 'Chưa thanh toán' }}
                                    </span>
                                </div>
                                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-outline-primary btn-sm">
                                    Xem chi tiết
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $orders->links() }}
        </div>
    @else
        <div class="text-center py-5">
            <i class="fas fa-shopping-bag fa-3x text-muted mb-3"></i>
            <h4>Chưa có đơn hàng nào</h4>
            <p class="text-muted mb-4">Bạn chưa có đơn hàng nào. Hãy bắt đầu mua sắm!</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary">Mua sắm ngay</a>
        </div>
    @endif
</div>
@endsection
