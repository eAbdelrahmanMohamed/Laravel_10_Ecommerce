@extends('layouts.base')
@section('content')
    <section class="breadcrumb-section section-b-space" style="padding-top:20px;padding-bottom:20px;">
        <ul class="circles">
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
        </ul>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3>Cart</h3>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('home') }}">
                                    <i class="fas fa-home"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Cart</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <!-- Cart Section Start -->
    <section class="cart-section section-b-space">
        <div class="container">
            @if ($items->Count() > 0)
                <div class="row">
                    <div class="col-md-12 text-center">
                        <table class="table cart-table">
                            <thead>
                                <tr class="table-head">
                                    <th scope="col">image</th>
                                    <th scope="col">product name</th>
                                    <th scope="col">price</th>
                                    <th scope="col">quantity</th>
                                    <th scope="col">total</th>
                                    <th scope="col">action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>
                                            <a href="{{ route('shop.product.detail', ['slug' => $item->model->slug]) }}">
                                                <img src="{{ asset('assets/images/fashion/product/front/' . $item->model->image) }}"
                                                    class="blur-up lazyloaded" alt="">
                                            </a>
                                        </td>
                                        <td>
                                            <a
                                                href="{{ route('shop.product.detail', ['slug' => $item->model->slug]) }}">{{ $item->model->name }}</a>
                                            <div class="mobile-cart-content row">
                                                <div class="col">
                                                    <div class="qty-box">
                                                        <div class="input-group">
                                                            <input type="text" name="quantity"
                                                                class="form-control input-number" value="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <h2>${{ $item->price }}</h2>
                                                </div>
                                                <div class="col">
                                                    <h2 class="td-color">
                                                        <a href="javascript:void(0)">
                                                            <i class="fas fa-times"></i>
                                                        </a>
                                                    </h2>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <h2>${{ $item->price }}</h2>
                                        </td>
                                        <td>
                                            <div class="qty-box">
                                                <div class="input-group">
                                                    <input id="rowholder" type="number" name="quantity" data-rowid="{{ $item->rowId }}"
                                                        class="form-control input-number" onchange="updatecartqty(this)"
                                                        value="{{ $item->qty }}">
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <h2 class="td-color">${{ $item->subtotal() }}</h2>
                                        </td>
                                        <td>
                                            <a href="javascript:void(0)" onclick="event.preventDefault();deletefromcart()">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach


                            </tbody>
                        </table>
                    </div>
                    <div class="col-12 mt-md-5 mt-4">
                        <div class="row">
                            <div class="col-sm-7 col-5 order-1">
                                <div class="left-side-button text-end d-flex d-block justify-content-end">
                                    <a href="javascript:void(0)"
                                        class="text-decoration-underline theme-color d-block text-capitalize">clear
                                        all items</a>
                                </div>
                            </div>
                            <div class="col-sm-5 col-7">
                                <div class="left-side-button float-start">
                                    <a href="{{ route('shop') }}" class="btn btn-solid-default btn fw-bold mb-0 ms-0">
                                        <i class="fas fa-arrow-left"></i> Continue Shopping</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="cart-checkout-section">
                        <div class="row g-4">
                            <div class="col-lg-4 col-sm-6">
                                <div class="promo-section">
                                    <form class="row g-3">
                                        <div class="col-7">
                                            <input type="text" class="form-control" id="number"
                                                placeholder="Coupon Code">
                                        </div>
                                        <div class="col-5">
                                            <button class="btn btn-solid-default rounded btn">Apply Coupon</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="col-lg-4 col-sm-6 ">
                                <div class="checkout-button">
                                    <a href="checkout" class="btn btn-solid-default btn fw-bold">
                                        Check Out <i class="fas fa-arrow-right ms-1"></i></a>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="cart-box">
                                    <div class="cart-box-details">
                                        <div class="total-details">
                                            <div class="top-details">
                                                <h3>Cart Totals</h3>
                                                <h6>Sub Total <span>${{ Cart::instance('cart')->subtotal() }}</span></h6>
                                                <h6>Tax <span>${{ Cart::instance('cart')->tax() }}</span></h6>

                                                <h6>Total <span>${{ Cart::instance('cart')->total() }}</span></h6>
                                            </div>
                                            <div class="bottom-details">
                                                <a href="checkout">Process Checkout</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h2>your cart is empty</h2>
                        <h5 class="mt-3">Add Items To It now</h5>
                        <a href="{{ route('shop') }}" class="btn btn-warning mt-3">Shop Now</a>
                    </div>
                </div>
            @endif
        </div>
        <form action="{{ route('cart.update') }}" id="updateCartQty" method="POST">
            @csrf
            @method('put')
            <input type="hidden" id="rowId" name="rowId">
            <input type="hidden" id="quantity" name="quantity">
        </form>
        <form action="{{ route('cart.delete') }}" id="deleteproduct" method="POST">
            @csrf
            @method('delete')
            <input type="hidden" id="deleterowId" name="rowId">
        </form>
    </section>
@endsection
@push('scripts')
    <script>
        function updatecartqty(qty) {
            $('#rowId').val($(qty).data('rowid'));
            $('#quantity').val($(qty).val());
            $('#updateCartQty').submit();
        }
        function deletefromcart() {
           let rowval= $('#rowholder').data('rowid');
            $('#deleterowId').val(rowval);
            $('#deleteproduct').submit();
        }
    </script>
@endpush
