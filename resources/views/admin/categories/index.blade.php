@extends('adminlte::page')

@section('title', 'product')

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
                                        <input type="checkbox"
                                            onclick="$('input[name*=\'selected\']').prop('checked', this.checked);">
                                    </th>
                                    <th>ID</th>
                                    <th>Başlık</th>
                                    <th>Resim</th>
                                    <th class="text-center">Göster</th>
                                    <th class="text-center">Düzenle</th>
                                    <th class="text-center">Sil</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($categories as $category)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="selected[]" value="{{ $category->id }}">
                                        </td>
                                        <td>
                                            <div class="text-truncate align-middle">{{ $category->id }}</div>
                                        </td>
                                        <td>
                                            <span class="d-inline-block text-truncate align-middle"
                                                style="max-width: 400px;">
                                                {!! $category->name !!}
                                            </span>
                                        </td>
                                        <td>
                                            @if ($category->image)
                                                {{-- <img
                                                    src="{{ Storage::url($category->image) }}"
                                                    alt="{{ $category->image_alt_text }}" width="100" height="100">
                                                --}}
                                                <img src="{{ $category->image }}" alt="{{ $category->image_alt_text }}"
                                                    width="100" height="100">
                                            @else
                                                Resim yok
                                            @endif

                                        </td>
                                        <td class="text-center align-middle">
                                            <a href="{{ route('categories.show', $category->id) }}"
                                                class="btn btn-info">Göster</a>
                                        </td>
                                        <td class="text-center align-middle">
                                            <a href="{{ route('categories.edit', $category->id) }}"
                                                class="btn btn-warning">Düzele</a>
                                        </td>
                                        <td class="text-center align-middle">
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
                    </div>
                    {{ $categories->links() }}
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

        .table {
            overflow: hidden !important;
        }

    </style>
@stop

@section('js')
    @if (session('message'))
        <script>
            Swal.fire(
                'Başarılı!',
                '{!! session('message') !!}',
                'success'
            )

        </script>
    @endif
    @if (session('fail'))
        <script>
            Swal.fire(
                'Hata!',
                '{!! session('fail') !!}',
                'error'
            )

        </script>
    @endif
    
@stop
