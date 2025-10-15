@extends('layouts.website')

@section('title', 'Trang chủ')

@section('content')
<!-- Hero Section -->
<section class="bg-primary text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">Khám phá thế giới nước hoa</h1>
                <p class="lead mb-4">Tìm kiếm hương thơm hoàn hảo cho bạn với bộ sưu tập nước hoa cao cấp từ các thương hiệu nổi tiếng thế giới.</p>
                <a href="{{ route('products.index') }}" class="btn btn-light btn-lg">Mua sắm ngay</a>
            </div>
            <div class="col-lg-6">
                <img src="https://via.placeholder.com/600x400/6f42c1/ffffff?text=Perfume+Collection" alt="Perfume Collection" class="img-fluid rounded">
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-5">Danh mục sản phẩm</h2>
        <div class="row">
            @foreach($categories as $category)
            <div class="col-md-4 col-lg-2 mb-4">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <i class="fas fa-spray-can fa-3x text-primary mb-3"></i>
                        <h5 class="card-title">{{ $category->name }}</h5>
                        <p class="card-text small">{{ Str::limit($category->description, 50) }}</p>
                        <a href="{{ route('products.index', ['category' => $category->id]) }}" class="btn btn-outline-primary btn-sm">Xem sản phẩm</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Products Section -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-5">Sản phẩm nổi bật</h2>
        <div class="row">
            @foreach($featuredProducts as $product)
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card product-card h-100">
                    <div class="position-relative">
                        <img src="https://via.placeholder.com/300x300/6f42c1/ffffff?text={{ urlencode($product->name) }}" class="card-img-top" alt="{{ $product->name }}">
                        @if($product->sale_price)
                            <span class="badge bg-danger position-absolute top-0 start-0 m-2">
                                -{{ $product->discount_percentage }}%
                            </span>
                        @endif
                        @if($product->is_featured)
                            <span class="badge bg-warning position-absolute top-0 end-0 m-2">Nổi bật</span>
                        @endif
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title">{{ $product->name }}</h6>
                        <p class="card-text small text-muted">{{ $product->brand }} - {{ $product->volume }}</p>
                        <div class="price mb-3">
                            @if($product->sale_price)
                                <span class="sale-price">{{ number_format($product->sale_price) }}đ</span>
                                <span class="original-price ms-2">{{ number_format($product->price) }}đ</span>
                            @else
                                <span class="text-dark">{{ number_format($product->price) }}đ</span>
                            @endif
                        </div>
                        <div class="mt-auto">
                            <a href="{{ route('products.show', $product->slug) }}" class="btn btn-outline-primary btn-sm w-100 mb-2">Xem chi tiết</a>
                            <form action="{{ route('cart.add') }}" method="POST" class="d-inline w-100">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn btn-primary btn-sm w-100">Thêm vào giỏ</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('products.index') }}" class="btn btn-primary">Xem tất cả sản phẩm</a>
        </div>
    </div>
</section>

<!-- Latest Products Section -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-5">Sản phẩm mới nhất</h2>
        <div class="row">
            @foreach($latestProducts as $product)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card product-card h-100">
                    <div class="position-relative">
                        <img src="https://via.placeholder.com/300x300/6f42c1/ffffff?text={{ urlencode($product->name) }}" class="card-img-top" alt="{{ $product->name }}">
                        @if($product->sale_price)
                            <span class="badge bg-danger position-absolute top-0 start-0 m-2">
                                -{{ $product->discount_percentage }}%
                            </span>
                        @endif
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title">{{ $product->name }}</h6>
                        <p class="card-text small text-muted">{{ $product->brand }} - {{ $product->volume }}</p>
                        <div class="price mb-3">
                            @if($product->sale_price)
                                <span class="sale-price">{{ number_format($product->sale_price) }}đ</span>
                                <span class="original-price ms-2">{{ number_format($product->price) }}đ</span>
                            @else
                                <span class="text-dark">{{ number_format($product->price) }}đ</span>
                            @endif
                        </div>
                        <div class="mt-auto">
                            <a href="{{ route('products.show', $product->slug) }}" class="btn btn-outline-primary btn-sm w-100 mb-2">Xem chi tiết</a>
                            <form action="{{ route('cart.add') }}" method="POST" class="d-inline w-100">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn btn-primary btn-sm w-100">Thêm vào giỏ</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-4 mb-4">
                <i class="fas fa-shipping-fast fa-3x text-primary mb-3"></i>
                <h5>Giao hàng nhanh</h5>
                <p>Giao hàng trong 24h tại TP.HCM</p>
            </div>
            <div class="col-md-4 mb-4">
                <i class="fas fa-shield-alt fa-3x text-primary mb-3"></i>
                <h5>Chính hãng 100%</h5>
                <p>Cam kết sản phẩm chính hãng</p>
            </div>
            <div class="col-md-4 mb-4">
                <i class="fas fa-undo fa-3x text-primary mb-3"></i>
                <h5>Đổi trả dễ dàng</h5>
                <p>Đổi trả trong 7 ngày</p>
            </div>
        </div>
    </div>
</section>
@endsection
