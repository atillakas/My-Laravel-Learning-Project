@extends('adminlte::page')

@section('title', 'Post')

@section('content_header')
    <h1>Kategori Ekle</h1>
@stop

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="POST" action="{{ action('App\Http\Controllers\Admin\CategoryController@store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="product-name">Başlık</label>
                                <input type="text" name="name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="product-name">Seo Url</label>
                                <input type="text" name="slug" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="product-description">İçerik</label>
                                <textarea name="description" class="form-control" rows="4"></textarea>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                                </div>
                                <div class="custom-file">
                                    <input type="file" name="image" id="fileupload" class="custom-file-input"
                                        accept="image/*">
                                    <label class="custom-file-label" for="inputGroupFile01">Resim Seç</label>
                                </div>
                            </div>
                            <div class="image-alt-text">
                                <label for="product-image-alt-text">Resim Alt Text</label>
                                <input type="text" name="image_alt_text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="product-category">Ebeveyn Kategori</label>
                                <select name="parent_id" class="form-control custom-select">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{!! $category->name !!} </option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="submit" value="Create Category" class="btn btn-success float-right">
                        </form>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </section>
@stop

@section('css')
   
    {{--
    <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script type="text/javascript">


    </script>
@stop
