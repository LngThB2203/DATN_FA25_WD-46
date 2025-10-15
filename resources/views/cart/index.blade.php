@extends('layouts.website')

@section('title', 'Giỏ hàng')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Giỏ hàng của bạn</h2>
    
    @if(count($cartItems) > 0)
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        @foreach($cartItems as $item)
                        <div class="row align-items-center border-bottom py-3">
                            <div class="col-md-2">
                                <img src="https://via.placeholder.com/100x100/6f42c1/ffffff?text={{ urlencode($item['product']->name) }}" 
                                     class="img-fluid rounded" alt="{{ $item['product']->name }}">
                            </div>
                            <div class="col-md-4">
                                <h6 class="mb-1">{{ $item['product']->name }}</h6>
                                <p class="text-muted small mb-0">{{ $item['product']->brand }} - {{ $item['product']->volume }}</p>
                            </div>
                            <div class="col-md-2">
                                <div class="price">
                                    @if($item['product']->sale_price)
                                        <span class="sale-price">{{ number_format($item['product']->sale_price) }}đ</span>
                                    @else
                                        <span class="text-dark">{{ number_format($item['product']->price) }}đ</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-2">
                                <form action="{{ route('cart.update') }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="product_id" value="{{ $item['product']->id }}">
                                    <div class="input-group input-group-sm">
                                        <input type="number" class="form-control" name="quantity" 
                                               value="{{ $item['quantity'] }}" min="1" max="{{ $item['product']->stock_quantity }}">
                                        <button type="submit" class="btn btn-outline-secondary">Cập nhật</button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-1">
                                <div class="text-end">
                                    <strong>{{ number_format($item['subtotal']) }}đ</strong>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <form action="{{ route('cart.remove') }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="product_id" value="{{ $item['product']->id }}">
                                    <button type="submit" class="btn btn-outline-danger btn-sm" 
                                            onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                
                <div class="mt-3">
                    <form action="{{ route('cart.clear') }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger" 
                                onclick="return confirm('Bạn có chắc muốn xóa tất cả sản phẩm trong giỏ hàng?')">
                            <i class="fas fa-trash me-2"></i>Xóa tất cả
                        </button>
                    </form>
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
                            <span>{{ number_format($total) }}đ</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Thuế (10%):</span>
                            <span>{{ number_format($total * 0.1) }}đ</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Phí vận chuyển:</span>
                            <span>50,000đ</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <strong>Tổng cộng:</strong>
                            <strong class="text-primary">{{ number_format($total + $total * 0.1 + 50000) }}đ</strong>
                        </div>
                        
                        @auth
                            <a href="{{ route('orders.checkout') }}" class="btn btn-primary w-100 btn-lg">
                                <i class="fas fa-credit-card me-2"></i>Thanh toán
                            </a>
                        @else
                            <div class="alert alert-info">
                                <p class="mb-2">Bạn cần đăng nhập để thanh toán</p>
                                <a href="{{ route('login') }}" class="btn btn-primary btn-sm me-2">Đăng nhập</a>
                                <a href="{{ route('register') }}" class="btn btn-outline-primary btn-sm">Đăng ký</a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-5">
            <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
            <h4>Giỏ hàng trống</h4>
            <p class="text-muted mb-4">Bạn chưa có sản phẩm nào trong giỏ hàng</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary">Tiếp tục mua sắm</a>
        </div>
    @endif
</div>
@endsection
