@extends('layouts.ecommerce')

@section('title', 'Ana Sayfa')


@section('content')
    <!-- Start Feature Product -->
    <section class="categories-slider-area bg__white">
        <div class="container">
            <div class="row">
                <!-- Start Left Feature -->
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 float-left-style">
                    <x-home.featured-product :sliders="['http://ecommerce.test/storage/resim1.jpg','https://picsum.photos/1920/800','http://ecommerce.test/storage/resim2.jpg']"/>
                </div>
                <!-- End Left Feature -->
            </div>
        </div>
    </section>
    <!-- End Feature Product -->
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
