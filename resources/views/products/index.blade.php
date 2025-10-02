@extends('layouts.website')

@section('title', 'Sản phẩm')

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Bộ lọc</h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('products.index') }}">
                        <!-- Search -->
                        <div class="mb-3">
                            <label for="search" class="form-label">Tìm kiếm</label>
                            <input type="text" class="form-control" id="search" name="search" value="{{ request('search') }}" placeholder="Tên sản phẩm, thương hiệu...">
                        </div>

                        <!-- Category Filter -->
                        <div class="mb-3">
                            <label for="category" class="form-label">Danh mục</label>
                            <select class="form-select" id="category" name="category">
                                <option value="">Tất cả danh mục</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Gender Filter -->
                        <div class="mb-3">
                            <label for="gender" class="form-label">Giới tính</label>
                            <select class="form-select" id="gender" name="gender">
                                <option value="">Tất cả</option>
                                <option value="men" {{ request('gender') == 'men' ? 'selected' : '' }}>Nam</option>
                                <option value="women" {{ request('gender') == 'women' ? 'selected' : '' }}>Nữ</option>
                                <option value="unisex" {{ request('gender') == 'unisex' ? 'selected' : '' }}>Unisex</option>
                            </select>
                        </div>

                        <!-- Sort -->
                        <div class="mb-3">
                            <label for="sort" class="form-label">Sắp xếp</label>
                            <select class="form-select" id="sort" name="sort">
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Mới nhất</option>
                                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Giá thấp đến cao</option>
                                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Giá cao đến thấp</option>
                                <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Tên A-Z</option>
                            </select>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Lọc</button>
                            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Xóa bộ lọc</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Products -->
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Sản phẩm</h2>
                <span class="text-muted">{{ $products->total() }} sản phẩm</span>
            </div>

            @if($products->count() > 0)
                <div class="row">
                    @foreach($products as $product)
                    <div class="col-md-6 col-lg-4 mb-4">
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
                                <p class="card-text small">{{ Str::limit($product->description, 80) }}</p>
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

                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $products->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-search fa-3x text-muted mb-3"></i>
                    <h4>Không tìm thấy sản phẩm</h4>
                    <p class="text-muted">Hãy thử thay đổi bộ lọc hoặc từ khóa tìm kiếm</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary">Xem tất cả sản phẩm</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
