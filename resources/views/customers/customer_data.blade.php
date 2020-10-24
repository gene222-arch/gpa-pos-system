<table class="table table-striped table-responsive">
    <thead>
        <tr>
            <th>ID</th>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Avatar</th>
            <th>Email</th>
            <th>Address</th>
            <th colspan="3" class="text-center">Actions</th>
        </tr>
    </thead>
{{-- customer Data --}}
    <tbody class="data-table">

        @foreach ($customers as $customer)

            <tr>
                {{-- customer ID --}}
                            <td>{{ $customer->id }}</td>  
                
                {{-- customer Firstname --}}
                            <td>
                                <p class="customer-first_name-text{{ $customer->id }}">{{ $customer->first_name }}</p>
                                <input type="text" name="first_name" class="form-control first_name first_name{{ $customer->id }}" value="{{ $customer->first_name }}" required autocomplete="first_name" autofocus >
                                <div class="invalid-feedback first_name-error-{{ $customer->id }}"></div>
                            </td>
                {{-- customer Lastname --}}
                        <td>
                            <p class="customer-last_name-text{{ $customer->id }}">{{ $customer->last_name }}</p>
                            <input type="text" name="last_name" class="form-control last_name last_name{{ $customer->id }}" value="{{ $customer->last_name }}" required autocomplete="last_name" autofocus >
                            <div class="invalid-feedback last_name-error-{{ $customer->id }}"></div>
                        </td>

                {{-- customer Avatar --}}    
                <td>
                    <img style="width: 10rem;" src="{{ asset('storage/customers/avatars/' . $customer->avatar) ?? '' }}" class="customer-avatar-text{{ $customer->id }}">
                    <input type="file" name="avatar" class="form-control avatar avatar{{ $customer->id }} p-1" value="{{ $customer->avatar }}">                               
                    <div class="invalid-feedback avatar-error-{{ $customer->id }}"></div>
                </td>                
                
                {{-- customer Email --}}
                            <td>
                                <p class="customer-email-text{{ $customer->id }}">{{ $customer->email }}</p>
                                <input type="email" name="email" class="form-control email email{{ $customer->id }}" value="{{ $customer->email }}" required autocomplete="email" autofocus >
                                <div class="invalid-feedback email-error-{{ $customer->id }}"></div>
                            </td>
                
                {{-- customer Address --}}
                            <td>
                                <p class="customer-address-text{{ $customer->id }}">{{ $customer->address }}</p>
                                <input type="text" name="address" class="form-control address address{{ $customer->id }}" value="{{ $customer->address }}" required autocomplete="address" autofocus >
                                <div class="invalid-feedback address-error-{{ $customer->id }}"></div>
                            </td>
                
                {{-- Actions (C.R.U.D)
                
                {{-- Show customer --}}
                            <td>
                                <a data-target="#exampleModal" data-toggle="modal" class="btn btn-info show-customer show-customer{{ $customer->id }}" id="{{ $customer->id }}">
                                    <i class="far fa-eye"></i>
                                </a>
                            </td>
                {{-- Edit customer --}}
                            <td>
                                <a class="btn btn-warning edit-customer edit-customer{{ $customer->id }}" id="{{ $customer->id }}"> 
                                    <i class="far fa-edit"></i> 
                                </a>
                                <a class="btn btn-warning update-customer update-customer{{ $customer->id }}" id="{{ $customer->id }}"> 
                                    Update
                                </a>
                            </td>
                {{-- Delete customer --}}
                            <td>
                                <a class="btn btn-danger delete-customer delete-customer{{ $customer->id }}" id="{{ $customer->id }}"> <i class="far fa-trash-alt"></i> </a>
                                <a class="btn btn-danger btn-cancel btn-cancel{{ $customer->id }}" id="{{ $customer->id }}">
                                    Cancel
                                </a>
                            </td> 
                        </tr>        


        @endforeach

    </tbody>
</table>  

<div class="customer-links" > 
    {!! $customers->render() !!} 
</div>

{{-- after an error on request, old('key') will not have any value because this is only applicable with non ajax request  --}}