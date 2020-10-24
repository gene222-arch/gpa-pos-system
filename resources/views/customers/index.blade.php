@extends('layouts.admin')

@section('tite', 'customer')
    
@section('css')
    <style>
        .customer__avatar__container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 0 1rem;
        }
    </style>
@endsection

{{-- Page Content Header --}}
@section('content-header', 'Customer List')

{{-- Page Content Actions --}}
@section('content-actions')
    <a href="{{ route('customers.create') }}" class="btn btn-success" title="Create Customer">
        <i class="fas fa-user-plus fa-2x p-1"></i>
    </a>
@endsection
@section('content')

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Customer Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="customer__avatar__container" style="width: 100%">
                        <img src="" alt="" class="customer-avatar" style="width: 10rem;">
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="customer-first_name" class="col-form-label">Firstname:</label>
                                <p class="customer-first_name"></p>
                            </div>
                            <div class="form-group">
                                <label for="customer-last_name" class="col-form-label">Lastname:</label>
                                <p class="customer-last_name"></p>
                            </div>
                            <div class="form-group">
                                <label for="customer-email" class="col-form-label">Email:</label>
                                <p class="customer-email"></p>
                            </div>
                            <div class="form-group">
                                <label for="customer-address" class="col-form-label">Address:</label>
                                <p class="customer-address"></p>
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

    <div class="customer-data">
        @include('customers.customer_data')
    </div>

@endsection


@section('js')
    <script src="{{ asset('js/customerScript/customer.js') }}"></script>
@endsection