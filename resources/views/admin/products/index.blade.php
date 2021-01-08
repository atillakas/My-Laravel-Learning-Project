@extends('adminlte::page')

@section('title', 'Ürünler')

@section('content_header')
    <h1>Ürünler</h1>
@stop

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-tools">
                            <form action="{{ route('products.index') }}" method="GET">
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
                                    <th>Fiyat</th>
                                    <th>Vergi Türü</th>
                                    <th>Vergili Fiyatı</th>
                                    <th>Resim</th>
                                    <th class="text-center">Göster</th>
                                    <th class="text-center">Düzenle</th>
                                    <th class="text-center">Sil</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($products as $product)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="selected[]" value="{{ $product->id }}">
                                        </td>
                                        <td>
                                            <div class="text-truncate align-middle">{{ $product->id }}</div>
                                        </td>
                                        <td>
                                            <span class="d-inline-block text-truncate align-middle"
                                                style="max-width: 300px;">
                                                {{ $product->name }}
                                            </span>
                                        </td>
                                        <td>
                                            @if ($product->price_new)
                                                <span style="color:red">{{ $product->price_new }}</span>
                                                <br>
                                                <del>{{ $product->price }}</del>
                                            @else
                                                {{ $product->price }}
                                            @endif

                                        </td>
                                        <td>
                                            @if ($product->tax_type == 1)
                                                <span class="d-inline-block text-truncate" style="max-width: 100px;">
                                                    Sabit Vergi
                                                </span>
                                            @else
                                                <span class="d-inline-block text-truncate" style="max-width: 100px;">
                                                    Yüzdelik Vergi
                                                </span>
                                            @endif

                                        </td>
                                        <td>
                                            @if ($product->tax_type == 1)
                                                <span class="d-inline-block text-truncate" style="max-width: 50px;">
                                                    {{ $product->tax + $product->product_price }}
                                                </span>
                                            @else
                                                <span class="d-inline-block text-truncate" style="max-width: 50px;">
                                                    hesapla
                                                </span>
                                            @endif

                                        </td>

                                        <td>
                                            @if ($product->image)
                                                {{-- <img
                                                    src="{{ Storage::url($product->image) }}"
                                                    alt="{{ $product->image_alt_text }}" width="100" height="100">
                                                --}}
                                                <img src="{{ $product->image }}" alt="{{ $product->image_alt_text }}"
                                                    width="100" height="100">
                                            @else
                                                Resim yok
                                            @endif

                                        </td>
                                        <td class="text-center align-middle">
                                            <a href="{{ route('products.show', $product->id) }}"
                                                class="btn btn-info">Göster</a>
                                        </td>
                                        <td class="text-center align-middle">
                                            <a href="{{ route('products.edit', $product->id) }}"
                                                class="btn btn-warning">Düzele</a>
                                        </td>
                                        <td class="text-center align-middle">
                                            <form
                                                action="{{ action('App\Http\Controllers\Admin\ProductController@destroy', $product->id) }}"
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
                    {{ $products->links() }}
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
        .table{
            overflow: hidden !important;
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
                '{!! session('message') !!}',
                'success'
            )

        </script>
    @endif
    @if (session('fail'))
        <script>
            Swal.fire(
                'Silinirken Hata Oluştu!',
                '{!! session('message') !!}',
                'error'
            )

        </script>
    @endif
@stop
