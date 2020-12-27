@extends('adminlte::page')

@section('title', 'Post')

@section('content_header')
    <h1>Post</h1>
@stop

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Post</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
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

                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('posts.update', $post->id) }}" enctype="multipart/form-data" >
                            @csrf
                            @method('PATCH')
                            <div class="form-group">
                                <label for="inputName">Başlık</label>
                                <input type="text" value="{{ $post->title }}" name="title" id="inputName"
                                    class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="inputDescription">İçerik</label>
                                <textarea id="inputDescription" name="content" class="form-control"
                                    rows="4">{{ $post->content }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="inputStatus">Durum</label>
                                <select id="inputStatus" name="status" class="form-control custom-select">
                                    @if ($post->status === 'aktif')
                                        <option value="aktif" selected>Aktif</option>
                                        <option value="pasif">İnAktif</option>
                                    @else
                                        <option value="aktif">Aktif</option>
                                        <option value="pasif" selected>İnAktif</option>
                                    @endif
                                </select>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                                </div>
                                <div class="custom-file">
                                    <input type="file" name="image" class="custom-file-input" id="inputGroupFile01"
                                        aria-describedby="inputGroupFileAddon01">
                                    <label class="custom-file-label" for="inputGroupFile01">Resim Seç</label>
                                </div>
                            </div>
                            <input type="submit" value="Create new Porject" class="btn btn-success float-right">

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
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        console.log('Hi!');

    </script>
@stop
