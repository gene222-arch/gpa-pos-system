@extends('layouts.admin')
@section('title', 'Cart')
@section('css')
    <style>
        svg {
            width: 1rem;
        }

        .leading-5 {
            margin: 1.5rem .25rem 1rem;
        }

        .employees-page-link {
            margin: 1rem 0 0;
        }

        img {
            width: 10rem;
        }

        .cart-actions {
            text-align: center
        }

        .user-cart {
            height: 30rem;
            overflow: auto;
        }

        
        .order__product {
            width: 98%;
            margin: 0 auto;
        }

        .item-container {
            display: flex;
            flex-wrap: wrap;

        }
        .item-container .item {
            flex-basis: 10rem;
            padding: .125rem;
            background: white;
            border: .05rem solid rgb(63, 63, 63);
            margin: .125rem;
        }

        .item-container .item-content {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-flow: column nowrap;
            padding: 1rem;
        }

    </style>
@endsection
@section('content-header', 'Cart')

@section('content')

    <div id="cart"></div>
    
@endsection