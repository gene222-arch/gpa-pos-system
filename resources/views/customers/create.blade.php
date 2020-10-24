@extends('layouts.admin')

@section('title', 'Create Customer')

@section('content')
    

    <form action="{{ route('customers.store') }}" method="post" enctype="multipart/form-data">

        @csrf
        <div class="form-group">
            <label for="avatar">Avatar</label>
            <input type="file" name="avatar" class="form-control @error('avatar') is-invalid @enderror p-1" id="avatar" placeholder="Your Avatar" value="{{ old('avatar') }}"  autocomplete autofocus>
            @error('avatar')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="first_name">Firstname</label>
            <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" id="first_name" placeholder="Your Firstname" value="{{ old('first_name') }}"  autocomplete autofocus>
            @error('first_name')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="last_name">Lastname</label>
            <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" id="last_name" placeholder="Your Lastname" value="{{ old('last_name') }}"  autocomplete autofocus>
            @error('last_name')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Your Email" value="{{ old('email') }}"  autocomplete autofocus>
            @error('email')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" id="address" placeholder="Your Address" value="{{ old('address') }}"  autocomplete autofocus>
            @error('address')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Create</button>

    </form>

@endsection
