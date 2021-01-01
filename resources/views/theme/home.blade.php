@extends('layouts.ecommerce')

@section('title', 'Ana Sayfa')


@section('content')
  
    <x-home.featured-product :sliders="['http://ecommerce.test/storage/resim1.jpg','https://picsum.photos/1920/800','http://ecommerce.test/storage/resim2.jpg']"/>
    <x-home.product-filter-by-category />
@endsection

@section('css')
    <style>
        /* body {
            background-color: red;
        } */

    </style>
@endsection

@section('js')
    <script type="text/javascript">
        console.log("merhaba burası custom js kodları içindi");

    </script>
@endsection
