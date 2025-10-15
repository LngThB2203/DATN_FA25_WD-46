@extends('layouts.website')

@section('title', 'Thanh toán')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Thanh toán</h2>
    
    <form action="{{ route('orders.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Thông tin giao hàng</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="shipping_name" class="form-label">Họ và tên *</label>
                                <input type="text" class="form-control @error('shipping_name') is-invalid @enderror" 
                                       id="shipping_name" name="shipping_name" value="{{ old('shipping_name', Auth::user()->name) }}" required>
                                @error('shipping_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="shipping_phone" class="form-label">Số điện thoại *</label>
                                <input type="tel" class="form-control @error('shipping_phone') is-invalid @enderror" 
                                       id="shipping_phone" name="shipping_phone" value="{{ old('shipping_phone') }}" required>
                                @error('shipping_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="shipping_address" class="form-label">Địa chỉ *</label>
                            <textarea class="form-control @error('shipping_address') is-invalid @enderror" 
                                      id="shipping_address" name="shipping_address" rows="3" required>{{ old('shipping_address') }}</textarea>
                            @error('shipping_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="shipping_city" class="form-label">Thành phố *</label>
                            <select class="form-select @error('shipping_city') is-invalid @enderror" 
                                    id="shipping_city" name="shipping_city" required>
                                <option value="">Chọn thành phố</option>
                                <option value="Hồ Chí Minh" {{ old('shipping_city') == 'Hồ Chí Minh' ? 'selected' : '' }}>Hồ Chí Minh</option>
                                <option value="Hà Nội" {{ old('shipping_city') == 'Hà Nội' ? 'selected' : '' }}>Hà Nội</option>
                                <option value="Đà Nẵng" {{ old('shipping_city') == 'Đà Nẵng' ? 'selected' : '' }}>Đà Nẵng</option>
                                <option value="Khác" {{ old('shipping_city') == 'Khác' ? 'selected' : '' }}>Khác</option>
                            </select>
                            @error('shipping_city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="notes" class="form-label">Ghi chú</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3" 
                                      placeholder="Ghi chú thêm cho đơn hàng...">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </div>
                
                <div class="card mt-3">
                    <div class="card-header">
                        <h5 class="mb-0">Phương thức thanh toán</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="payment_method" 
                                   id="cash_on_delivery" value="cash_on_delivery" 
                                   {{ old('payment_method', 'cash_on_delivery') == 'cash_on_delivery' ? 'checked' : '' }}>
                            <label class="form-check-label" for="cash_on_delivery">
                                <strong>Thanh toán khi nhận hàng (COD)</strong>
                                <br><small class="text-muted">Thanh toán bằng tiền mặt khi nhận được hàng</small>
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="payment_method" 
                                   id="bank_transfer" value="bank_transfer" 
                                   {{ old('payment_method') == 'bank_transfer' ? 'checked' : '' }}>
                            <label class="form-check-label" for="bank_transfer">
                                <strong>Chuyển khoản ngân hàng</strong>
                                <br><small class="text-muted">Chuyển khoản trước khi giao hàng</small>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Đơn hàng của bạn</h5>
                    </div>
                    <div class="card-body">
                        @foreach($cartItems as $item)
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <h6 class="mb-0">{{ $item['product']->name }}</h6>
                                <small class="text-muted">{{ $item['product']->brand }} - {{ $item['product']->volume }}</small>
                            </div>
                            <div class="text-end">
                                <div>{{ $item['quantity'] }}x</div>
                                <div class="text-muted">{{ number_format($item['subtotal']) }}đ</div>
                            </div>
                        </div>
                        @endforeach
                        
                        <hr>
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span>Tạm tính:</span>
                            <span>{{ number_format($subtotal) }}đ</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Thuế (10%):</span>
                            <span>{{ number_format($taxAmount) }}đ</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Phí vận chuyển:</span>
                            <span>{{ number_format($shippingAmount) }}đ</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <strong>Tổng cộng:</strong>
                            <strong class="text-primary">{{ number_format($total) }}đ</strong>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100 btn-lg">
                            <i class="fas fa-credit-card me-2"></i>Đặt hàng
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
