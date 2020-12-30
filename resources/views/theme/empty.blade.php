
@extends('layouts.ecommerce')

@section('title', 'Ana Sayfa')


@section('content')
    <p>burası içerik alanıdır.</p>
@endsection

@section('css')
    <style>
       body{
           background-color: red;
       }
    </style>
@endsection

@section('js')
    <script type="text/javascript">
        console.log("merhaba burası custom js kodları içindi");
    </script>
@endsection