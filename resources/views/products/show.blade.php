@extends('layouts.website')

@section('title', $product->name)

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-6">
            <div class="product-images">
                @if($product->images && count($product->images) > 0)
                    <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach($product->images as $index => $image)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                <img src="https://via.placeholder.com/500x500/6f42c1/ffffff?text={{ urlencode($product->name) }}" class="d-block w-100" alt="{{ $product->name }}">
                            </div>
                            @endforeach
                        </div>
                        @if(count($product->images) > 1)
                        <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                        @endif
                    </div>
                @else
                    <img src="https://via.placeholder.com/500x500/6f42c1/ffffff?text={{ urlencode($product->name) }}" class="img-fluid" alt="{{ $product->name }}">
                @endif
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="product-details">
                <h1 class="h2 mb-3">{{ $product->name }}</h1>
                
                <div class="mb-3">
                    <span class="badge bg-primary">{{ $product->category->name }}</span>
                    <span class="badge bg-secondary">{{ ucfirst($product->gender) }}</span>
                    @if($product->is_featured)
                        <span class="badge bg-warning">Nổi bật</span>
                    @endif
                </div>

                <div class="price mb-4">
                    @if($product->sale_price)
                        <span class="sale-price h3">{{ number_format($product->sale_price) }}đ</span>
                        <span class="original-price h5 ms-2">{{ number_format($product->price) }}đ</span>
                        <span class="badge bg-danger ms-2">-{{ $product->discount_percentage }}%</span>
                    @else
                        <span class="h3 text-dark">{{ number_format($product->price) }}đ</span>
                    @endif
                </div>

                <div class="product-info mb-4">
                    <div class="row">
                        <div class="col-sm-4"><strong>Thương hiệu:</strong></div>
                        <div class="col-sm-8">{{ $product->brand }}</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4"><strong>Dung tích:</strong></div>
                        <div class="col-sm-8">{{ $product->volume }}</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4"><strong>Tồn kho:</strong></div>
                        <div class="col-sm-8">
                            @if($product->stock_quantity > 0)
                                <span class="text-success">{{ $product->stock_quantity }} sản phẩm</span>
                            @else
                                <span class="text-danger">Hết hàng</span>
                            @endif
                        </div>
                    </div>
                    @if($product->fragrance_notes)
                    <div class="row">
                        <div class="col-sm-4"><strong>Hương thơm:</strong></div>
                        <div class="col-sm-8">{{ $product->fragrance_notes }}</div>
                    </div>
                    @endif
                </div>

                <div class="product-description mb-4">
                    <h5>Mô tả sản phẩm</h5>
                    <p>{{ $product->description }}</p>
                </div>

                @if($product->stock_quantity > 0)
                <form action="{{ route('cart.add') }}" method="POST" class="mb-4">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <label for="quantity" class="form-label">Số lượng:</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1" max="{{ $product->stock_quantity }}">
                        </div>
                        <div class="col-md-8">
                            <button type="submit" class="btn btn-primary btn-lg w-100">
                                <i class="fas fa-shopping-cart me-2"></i>Thêm vào giỏ hàng
                            </button>
                        </div>
                    </div>
                </form>
                @else
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>Sản phẩm hiện đang hết hàng
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="mb-4">Sản phẩm liên quan</h3>
            <div class="row">
                @foreach($relatedProducts as $relatedProduct)
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="card product-card h-100">
                        <div class="position-relative">
                            <img src="https://via.placeholder.com/300x300/6f42c1/ffffff?text={{ urlencode($relatedProduct->name) }}" class="card-img-top" alt="{{ $relatedProduct->name }}">
                            @if($relatedProduct->sale_price)
                                <span class="badge bg-danger position-absolute top-0 start-0 m-2">
                                    -{{ $relatedProduct->discount_percentage }}%
                                </span>
                            @endif
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title">{{ $relatedProduct->name }}</h6>
                            <p class="card-text small text-muted">{{ $relatedProduct->brand }} - {{ $relatedProduct->volume }}</p>
                            <div class="price mb-3">
                                @if($relatedProduct->sale_price)
                                    <span class="sale-price">{{ number_format($relatedProduct->sale_price) }}đ</span>
                                    <span class="original-price ms-2">{{ number_format($relatedProduct->price) }}đ</span>
                                @else
                                    <span class="text-dark">{{ number_format($relatedProduct->price) }}đ</span>
                                @endif
                            </div>
                            <div class="mt-auto">
                                <a href="{{ route('products.show', $relatedProduct->slug) }}" class="btn btn-outline-primary btn-sm w-100 mb-2">Xem chi tiết</a>
                                <form action="{{ route('cart.add') }}" method="POST" class="d-inline w-100">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $relatedProduct->id }}">
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
    </div>
    @endif
</div>
@endsection
