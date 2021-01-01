@extends('layouts.ecommerce')

@section('title', 'Ana Sayfa')


@section('content')
    <x-home.product-filter-by-category filter="open"/>
@endsection

@section('css')
    <style>
        body {
            background-color: red;
        }

    </style>
@endsection

@section('js')
    <script type="text/javascript">
        console.log("merhaba burası custom js kodları içindi");

    </script>
@endsection
