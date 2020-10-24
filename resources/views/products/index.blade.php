@extends('layouts.admin')

{{-- Page Title --}}
@section('title', 'Products')

@section('css')

    <style>

        .product-links {
            margin: 1.5rem 0;
        }

        .product__image__container {
            display: flex;
            justify-content: center;
            align-items: center;
        }


    </style>

@endsection 

{{-- Page Content Header --}}
@section('content-header', 'Product List')

{{-- Page Content Actions --}}
@section('content-actions')
    <a href="{{ route('products.create') }}" class="btn btn-success" title="Add Product">
        <i class="fas fa-cart-plus fa-2x p-1"></i>
    </a>
@endsection


{{-- Page Main Content --}}
@section('content')

        <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="product__image__container">
                            <img src="" alt="" class="product-image" style="width: 10rem;">
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="product-name" class="col-form-label">Product:</label>
                                    <p class="product-name"></p>
                                </div>
                                <div class="form-group">
                                    <label for="product-barcode" class="col-form-label">Barcode:</label>
                                    <p class="product-barcode"></p>
                                </div>
                                <div class="form-group">
                                    <label for="product-barcode" class="col-form-label">Price:</label>
                                    <p class="product-price"></p>
                                </div>
                                <div class="form-group">
                                    <label for="product-barcode" class="col-form-label">Quantity:</label>
                                    <p class="product-quantity"></p>
                                </div>
                                <div class="form-group">
                                    <label for="product-status" class="col-form-label">Status:</label>
                                    <p class="product-status"></p>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Send message</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Around table overflow-x auto --}}
        <div class="product-data"> 
            @include('products.pagination_product_page')
        </div> 
@endsection


@section('js')
    <script src="{{ asset('js/productsScript/custom.js') }}"></script>
@endsection

