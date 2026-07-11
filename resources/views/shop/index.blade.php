@extends('layouts.shop.app')

@section('content')
    <!-- Categories Section Begin -->
    <!-- <section class="categories">
            <div class="container">
                <div class="row">
                    <div class="categories__slider owl-carousel">
                        <div class="col-md-12 px-1">
                            <div class="categories__item set-bg"
                                data-setbg=" {{ asset('frontend/shop/img/categories/cat-1.jpg ') }}">
                                <h5><a href="#">Fresh Fruit</a></h5>
                            </div>
                        </div>
                        <div class="col-md-12 px-1">
                            <div class="categories__item set-bg"
                                data-setbg="{{ asset('frontend/shop/img/categories/cat-2.jpg ') }}">
                                <h5><a href="#">Dried Fruit</a></h5>
                            </div>
                        </div>
                        <div class="col-md-12 px-1">
                            <div class="categories__item set-bg"
                                data-setbg="{{ asset('frontend/shop/img/categories/cat-3.jpg ') }}">
                                <h5><a href="#">Vegetables</a></h5>
                            </div>
                        </div>
                        <div class="col-md-12 px-1">
                            <div class="categories__item set-bg"
                                data-setbg="{{ asset('frontend/shop/img/categories/cat-4.jpg ') }}">
                                <h5><a href="#">drink fruits</a></h5>
                            </div>
                        </div>
                        <div class="col-md-12 px-1">
                            <div class="categories__item set-bg"
                                data-setbg="{{ asset('frontend/shop/img/categories/cat-5.jpg ') }}">
                                <h5><a href="#">drink fruits</a></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section> -->
    <!-- Categories Section End -->

    <!-- Featured Section Begin -->
    <section class="featured spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>Sản Phẩm Nổi Bật</h2>
                    </div>
                  <div class="featured__controls">
    <ul>

        <li class="{{ request('parent_id') == null ? 'active' : '' }}">
            <a href="{{ route('shop.shop') }}">All</a>
        </li>

        @foreach ($parentCategoryProductFillter as $itemNameParent)

            <li class="{{ request('parent_id') == $itemNameParent->parent_id ? 'active' : '' }}">
                <a href="{{ route('shop.shop', ['parent_id' => $itemNameParent->parent_id]) }}">
                    {{ $itemNameParent->name }}
                </a>
            </li>

        @endforeach

    </ul>
</div>
                </div>
            </div>
           <div class="row featured__filter">

    @foreach ($products as $product)

        <div class="col-lg-3 col-md-4 col-sm-6 ">

            <div class="featured__item">

                <div class="featured__item__pic set-bg"
                    data-setbg="{{ isset($product->imgName) 
                        ? asset('storage/uploads/products/' . $product->imgName) 
                        : asset('frontend/shop/img/image.jpg') }}">

                    <ul class="featured__item__pic__hover">

                        <li>
                            <a href="{{ route('shop.shop-details', $product->product_id) }}">
                                <i class="fa fa-eye"></i>
                            </a>
                        </li>
<li>

    <form action="{{ route('shop.addProductTocart', $product->product_id) }}"
          method="POST"
          class="add-to-cart-form">

        @csrf

        <input type="hidden" name="quantity" value="1">

        <button type="submit" class="btn-add-to-cart">

            <i class="fa fa-shopping-cart"></i>

        </button>

    </form>

</li>
                    </ul>

                </div>

                <div class="featured__item__text">

                    <h6>
                        <a href="{{ route('shop.shop-details', $product->product_id) }}">
                            {{ $product->name }}
                        </a>
                    </h6>

                    <h5>
                        {{ Number::currency($product->price, 'VND', 'vi') }}
                    </h5>

                </div>

            </div>

        </div>

    @endforeach

</div>
        </div>
    </section>
    <!-- Featured Section End -->

    <!-- Latest Product Section Begin -->
    <section class="latest-product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="latest-product__text">
                        <h4>Sản Phẩm mới</h4>
                        <div class="latest-product__slider owl-carousel">
                            @foreach ($chunkedProductsNew as $chunkNew)
                                <div class="latest-prdouct__slider__item row">
                                    @foreach ($chunkNew as $productNewItem)
                                        <a href="{{ route('shop.shop-details', $productNewItem->product_id) }}"
                                            class="latest-product__item d-flex justify-content-between align-items-center p-2 mb-3">

                                            <div class="col-3">
                                                <div
                                                    class=" latest-product__item__pic d-flex justify-content-center align-items-center">
                                                    <img src="{{ isset($productNewItem->imgName) ? asset('storage/uploads/products/' . $productNewItem->imgName) : asset('frontend/shop/img/image.jpg') }}"
                                                        class="w-auto" alt="">
                                                </div>
                                            </div>
                                            <div class="col-9 latest-product__item__text">
                                                <h6 class="mb-1">{{ $productNewItem->name }}</h6>
                                                <span>
                                                    @php
                                                        $priceNewProduct = $productNewItem->price;
                                                        $discountedPriceNewProduct = $priceNewProduct; // Default to the original price if no discount
                                                        if ($productNewItem->discount_code) {
                                                            $percentNewProduct = $productNewItem->percent;
                                                            $discountedPriceNewProduct =
                                                                $priceNewProduct -
                                                                ($priceNewProduct * $percentNewProduct) / 100;
                                                        }
                                                    @endphp

                                                    @if ($discountedPriceNewProduct < $priceNewProduct)
                                                        {{ Number::currency($discountedPriceNewProduct, 'VND', 'vi') }}
                                                        <span class="text-muted text-decoration-line-through"
                                                            style="font-size: 14px;">
                                                            {{ Number::currency($priceNewProduct, 'VND', 'vi') }}
                                                        </span>
                                                    @else
                                                        {{ Number::currency($discountedPriceNewProduct, 'VND', 'vi') }}
                                                    @endif
                                                </span>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6">
                    <div class="latest-product__text">
                        <h4>Sản Phẩm Giảm Giá</h4>
                        <div class="latest-product__slider owl-carousel">
                            @foreach ($chunkedProductsSale as $chunk)
                                <div class="latest-prdouct__slider__item row">
                                    @foreach ($chunk as $productSales)
                                        <a href="{{ route('shop.shop-details', $productSales->product_id) }}"
                                            class="latest-product__item d-flex justify-content-between align-items-center p-2 mb-3">

                                            <div class="col-3">
                                                <div
                                                    class="latest-product__item__pic d-flex justify-content-center align-items-center">
                                                    <img src="{{ isset($productSales->imgName) ? asset('storage/uploads/products/' . $productSales->imgName) : asset('frontend/shop/img/latest-product/lp-1.jpg') }}"
                                                        class="w-auto" alt="">
                                                </div>
                                            </div>
                                            <div class="col-9 latest-product__item__text">
                                                <h6 class="mb-1">{{ $productSales->name }}</h6>
                                                <span>
                                                    @php
                                                        $price = $productSales->price;
                                                        $discountedPrice = $price;
                                                        if ($productSales->discount_code) {
                                                            $percent = $productSales->percent;
                                                            $discountedPrice = $price - ($price * $percent) / 100;
                                                        }
                                                    @endphp
                                                    {{ Number::currency($discountedPrice, 'VND', 'vi') }}
                                                    @if ($discountedPrice < $price)
                                                        <span class="text-muted text-decoration-line-through"
                                                            style="font-size: 14px;">
                                                            {{ Number::currency($price, 'VND', 'vi') }}
                                                        </span>
                                                    @endif
                                                </span>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

<script>
document.querySelectorAll('.btn-add-to-cart').forEach(button => {

    button.addEventListener('click', function(e) {

        e.preventDefault();

        const form = this.closest('form');

        const formData = new FormData(form);

        fetch(form.action, {

            method: 'POST',

            headers: {
                'X-CSRF-TOKEN': document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute('content')
            },

            body: formData

        })

        .then(response => response.json())

        .then(data => {

            if (data.status === 'success') {

                toastr.success(data.message);

                // update số lượng icon cart realtime
                const cartCount = document.getElementById('cart-count');

                if (cartCount) {
                    cartCount.innerText = data.cartCount;
                }

            } else {

                toastr.error(data.message);

            }

        })

        .catch(error => {

            console.log(error);

            toastr.error('Có lỗi xảy ra');

        });

    });

});
</script>
    <!-- Latest Product Section End -->
@endsection
