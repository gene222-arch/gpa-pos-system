
<table class="table table-striped">

    <thead>
        <tr>
            <th>ID</th>
            <th>Barcode</th>
            <th>Name</th>
            <th>Image</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Status</th>
            <th colspan="3" class="text-center">Actions</th>
        </tr>
    </thead>

{{-- Product Data --}}
    <tbody class="data-table">

        @foreach ($products as $product)
        <form id="productForm{{ $product->id }}" enctype="multipart/form-data">

        <tr>
     {{-- Product ID --}}
            <td> {{ $product->id }} </td>  

    {{-- Product Barcode --}}
    <td class="text-center">
        <p class="product-barcode-text{{ $product->id }}">
            {{-- {!! DNS1D::getBarcodeHTML("GPA-" . $product->barcode, 'C128') !!} --}}
            {!! DNS2D::getBarcodeHTML('GPA-' . $product->barcode, 'QRCODE', 7, 6) !!}
        </p>
        <input type="text" name="barcode" class="form-control barcode barcode{{ $product->id }}" value="{{ $product->barcode }}" required autocomplete="barcode" autofocus>

        <div class="invalid-feedback barcode-error-{{ $product->id }}"></div>
    </td>

    {{-- Product Name --}}
    <td>
        <p class="product-name-text{{ $product->id }}"> {{ $product->product_name }} </p>
        <input type="text" name="product_name" class="form-control product_name product_name{{ $product->id }}" value="{{ $product->product_name }}" required autocomplete="product_name" autofocus>
        <div class="invalid-feedback product_name-error-{{ $product->id }}"></div>
    </td>

    {{-- Product Image --}}    
    <td>
        <img style="width: 10rem;" src="{{ asset('storage/products/images/' . $product->image) ?? '' }}" class="product-image-text{{ $product->id }}">
        <input type="file" name="image" class="form-control image image{{ $product->id }} p-1" value="{{ $product->image }}" required autocomplete="image" autofocus>
        <div class="invalid-feedback image-error-{{ $product->id }}"></div>
    </td>

    {{-- Product Price --}}
            <td>
                <p class="product-price-text{{ $product->id }}"> {{ $product->price }} </p>
                <input type="text" name="price" class="form-control price price{{ $product->id }}" value="{{ $product->price }}" required autocomplete="price" autofocus>
                <div class="invalid-feedback price-error-{{ $product->id }}"></div>
            </td>

    {{-- Product Quantity --}}
        <td>
            <p class="product-quantity-text{{ $product->id }}"> {{ $product->quantity }} </p>
            <input type="text" name="quantity" class="form-control quantity quantity{{ $product->id }}" value="{{ $product->quantity }}" required autocomplete="quantity" autofocus>
            <div class="invalid-feedback quantity-error-{{ $product->id }}"></div>
        </td>

    {{-- Product Status --}}
            <td>
                <p class="product-status-text{{ $product->id }}">
                    <small class="label pull-right {{ $product->status ? 'bg-green' : 'bg-danger' }} p-1">{{ $product->status ? 'Active' : 'Inactive' }}</small>
                </p>
                <input type="text" name="status" class="form-control status status{{ $product->id }}" value="{{ $product->status ? 'Active' : 'Inactive' }}">
                <div class="invalid-feedback status-error-{{ $product->id }}"></div>
            </td>

{{-- Actions (C.R.U.D) --}}

    {{-- Show Product --}}
            <td>
                <a data-target="#productModal" data-toggle="modal" class="btn btn-info show-product show-product{{ $product->id }}" id="{{ $product->id }}">
                    <i class="far fa-eye"></i>
                </a>
            </td>
    {{-- Edit Product --}}
            <td>
                <a class="btn btn-warning edit-product edit-product{{ $product->id }}" id="{{ $product->id }}"> 
                    <i class="far fa-edit"></i> 
                </a>
                <a class="btn btn-warning update-product update-product{{ $product->id }}" id="{{ $product->id }}"> 
                    Update
                </a>
            </td>
    {{-- Delete Product --}}
            <td>
                <a class="btn btn-danger delete-product delete-product{{ $product->id }}" id="{{ $product->id }}"> <i class="far fa-trash-alt"></i> </a>
                <a class="btn btn-danger btn-cancel btn-cancel{{ $product->id }}" id="{{ $product->id }}">
                    Cancel
                </a>
            </td>

        </tr>
        </form>
    @endforeach

    </tbody>
{{-- Product Data --}}
</table>      

<div class="product-links" > {!! $products->render() !!} </div>

