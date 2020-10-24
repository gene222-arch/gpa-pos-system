@extends('layouts.admin')

@section('title', 'Create Product')

@section('css')
    <style>
        .table th, .table td {
            border-top: none;
        }
        .row {
            max-width: 80%;
        }
    </style>
@endsection

@section('content-header', 'Create Product')
    
@section('content')
    
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="product_name"> Product Name</label>
                            <input type="text" name="product_name" class="form-control @error('product_name') is-invalid @enderror" id="product_name" placeholder="Your Product Name" value="{{ old('product_name') }}"  autocomplete autofocus>
                            @error('product_name')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description"> Description </label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description" placeholder="Your Product Details" rows="10" cols="30" value="{{ old('description') }}"  autocomplete autofocus></textarea>
                            @error('description')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="image"> Product Image </label>
                            <div class="input-group">
                              <div class="custom-file">
                                <input type="file" name="image" class="custom-file-input @error('image') is-invalid @enderror" id="image" value="{{ old('image') }}"  autocomplete="" autofocus>
                                <label class="custom-file-label" for="image">Choose file</label>
                              </div>
                            </div>
                            <div class="img-preview-container">
                                <img src="" alt="" class="img-preview">
                            </div>
                            @error('image')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
        
                        <div class="form-group">
                            <label for="barcode"> Barcode </label>
                            <input type="text" name="barcode" class="form-control barcode @error('barcode') is-invalid @enderror" id="barcode" placeholder="GPA-1010" value="{{ old('barcode') }}"  autocomplete autofocus>
                            <img src="" class="barcode-preview" alt="">
                            @error('barcode')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="price"> Price </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-ruble-sign"></i>
                                    </div>
                                </div>
                                <input type="text" name="price" class="form-control @error('price') is-invalid @enderror" id="price" placeholder="Price" value="{{ old('price') }}"  autocomplete autofocus>
                            </div>
                            @error('price')
                                <span class="invalid-feedback" style="display: block;">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="quantity"> Quantity </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-ruble-sign"></i>
                                    </div>
                                </div>
                                <input type="text" name="quantity" class="form-control @error('quantity') is-invalid @enderror" id="quantity" placeholder="Quantity" value="{{ old('quantity') }}"   autocomplete autofocus>
                            </div>
                            @error('quantity')
                                <span class="invalid-feedback" style="display: block;">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="status"> Status </label>
                            <select type="text" name="status" class="form-control @error('status') is-invalid @enderror" id="status"  autocomplete autofocus>
                                <option value="1" {{ old('status') === 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('status') === 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                
                        <button type="submit" class="btn btn-success create-product"> Create Product</button>
                
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5>Generated Product</h5>
                </div>
                <div class="card-body">
                    
                    <center>
                        <img src="" class="product-old-image py-2 my-2" alt="">
                        <h3><strong>{{ old('product_name') }}</strong></h3>
                    </center>
                    <table class="table">
                        <tbody>
                            <tr>
                                <th>Barcode:</th>
                                <td>
                                    @if (old('barcode'))
                                        {!! DNS2D::getBarcodeHTML(old('barcode'), 'QRCODE', 5, 5) !!} 
                                        {{ old('barcode') }} 
                                    @endif
                                </td>
                                <td></td>
                                <th>Product Name:</th>
                                <td>{{ old('product_name') }}</td>

                            </tr>
                            <tr>
                                <th>Quantity:</th>
                                <td>{{ old('quantity') }}</td>
                                <td></td>
                                <th>Product Code :</th>
                                <td>{{ old('barcode') }}</td>
                            </tr>
                            <tr>
                                <th>Created At:</th>
                                <td>
                                    @if (old('barcode'))
                                        {{ Carbon\Carbon::now()->toDateTimeString() }}
                                    @endif
                                </td>
                                <td></td>
                                <th>Minimal Stock:</th>
                                <td>{{ old('quantity') }}</td>
                            </tr>
                            <tr>
                                <th>Price :</th>
                                <td>{{ old('price') }}</td>
                            </tr>
                            <tr>
                                <button 
                                    class="btn btn-block btn-{{ old('status') == 1 ? "success" : "danger" }}">
                                    {{ old('status') == 1 ? 'Active' : 'Inactive' }}
                                </button>
                            </tr>
                        </tbody>
                        <div class="card mt-2">
                            <div class="card-header bg-primary">
                                <small><h5>Product Description</h5></small>
                            </div>
                            <div class="card-body">                    
                                {{ old('description') ?? 'Please define the product'}}        
                            </div>
                        </div>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('js')

    <script>
        document.querySelector('.custom-file-input').addEventListener('change', () => {

            const PRODUCT_IMAGE = document.querySelector('.custom-file-input').files[0];
            const PRODUCT_IMAGE_CONTAINER = document.querySelector('.img-preview');
            const READER = new FileReader();
            localStorage.setItem('oldImage', PRODUCT_IMAGE.name);
            localStorage.setItem('image', PRODUCT_IMAGE);
            if ( PRODUCT_IMAGE ) 
            {
                READER.onload = () => PRODUCT_IMAGE_CONTAINER.src = READER.result;
                READER.readAsDataURL(PRODUCT_IMAGE);                
            }

        });

        if (localStorage.getItem('oldImage') && localStorage.getItem('image')) {
            
            document.querySelector('.product-old-image').src = "../../../storage/products/images/" + localStorage.getItem('oldImage');
            document.querySelector('.custom-file-input').src = "../../../storage/products/images/" + localStorage.getItem('image');
        }

    </script>
@endsection