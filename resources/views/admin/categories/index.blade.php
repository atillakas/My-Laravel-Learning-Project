@extends('adminlte::page')

@section('title', 'category')

@section('content_header')
    <h1>Kategoriler</h1>
@stop

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-tools">
                            <form action="{{ route('categories.index') }}" method="GET">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="text" value="{{ $term ?? '' }}" name="s" class="form-control float-right"
                                        placeholder="Başlıkta ara">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <table class="table table-head-fixed text-nowrap">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);">
                                    </th>
                                    <th>ID</th>
                                    <th>Başlık</th>
                                    <th>İçerik</th>
                                    <th>Resim</th>
                                    <th>Durum</th>
                                    <th class="text-center">Göster</th>
                                    <th class="text-center">Düzenle</th>
                                    <th class="text-center">Sil</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($categories as $category)
                                    <tr>
                                        <td><input type="checkbox" name="selected[]" value="{{ $category->id }}">
                                        </td>
                                        <td>{{ $category->id }}</td>
                                        <td>{!! $category->name !!}</td>
                                        <td>{{ substr($category->description, 0, 50) }}...</td>

                                        <td>
                                            @if ($category->image)
                                            {{-- <img src="{{ Storage::url($category->image) }}" alt="{{ $category->image_alt_text }}" width="100" height="100"> --}}
                                            <img src="{{$category->image}}" alt="{{ $category->image_alt_text }}" width="100" height="100">
                                            @else
                                            Resim yok
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('categories.show', $category->id) }}"
                                                class="btn btn-info">Göster</a>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('categories.edit', $category->id) }}"
                                                class="btn btn-warning">Düzele</a>
                                        </td>
                                        <td class="text-center">
                                            <form
                                                action="{{ route('categories.destroy', $category->id) }}"
                                                method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger" type="submit">Sil</button>
                                            </form>
                                        </td>
                                    </tr>
                                    </tr>
                                @endforeach


                            </tbody>
                        </table>
                        {{ $categories->links() }}
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>

    </section>
@stop

@section('css')
    <style>
        .pagination {
            padding-left: 20px;
        }

        .alert {
            margin: 10px;
        }

    </style>
    {{--
    <link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}"> --}}
@stop

@section('js')
    @if (session('message'))
        <script>
            Swal.fire(
                'Başarılı!',
                '{{ session('message') }}',
                'success'
            )
        </script>
    @endif
    @if (session('fail'))
        <script>
            Swal.fire(
                'Silinirken Hata Oluştu!',
                '{{ session('message') }}',
                'error'
            )
        </script>
    @endif
@stop
