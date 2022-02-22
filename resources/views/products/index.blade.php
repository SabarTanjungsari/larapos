@extends('layouts.master')

@section('title')
    <title>Product Management</title>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Product Management
                            <a href="{{ route('product.export') }}" class="btn btn-outline-info btn-sm">
                                <i class="fa fa-file-download"></i>
                            </a>
                            <button type="button" class="btn btn-outline-success btn-sm" data-toggle="modal"
                                data-target="#myModal">
                                <i class="fa fa-file-upload"></i>
                            </button>
                        </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Product</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-md-12">
                        <x-card title="List of Category" footer="">
                            @slot('title')
                                @can('product-create')
                                    <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm">
                                        <i class="fa fa-plus-circle"></i> Add
                                    </a>
                                @endcan
                            @endslot

                            @if (session('success'))
                                <x-alert type="success">{!! session('success') !!}</x-alert>
                            @endif
                            @if (session('error'))
                                <x-alert type="danger">{!! session('error') !!}</x-alert>
                            @endif
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <td>Barcode</td>
                                            <td colspan="2">Name</td>
                                            <td>Stock</td>
                                            <td>Price</td>
                                            <td>Category</td>
                                            <td>Last Update</td>
                                            <td>Action</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($products as $product)
                                            <tr>
                                                <td class="text-center">
                                                    <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($product->code, 'C93') }}"
                                                        alt="barcode" />
                                                    <sup class="text text-success">{{ $product->code }}</sup>
                                                </td>
                                                <td>
                                                    @if (!empty($product->photo))
                                                        <img src="{{ asset('uploads/product/' . $product->photo) }}"
                                                            alt="{{ $product->name }}" width="50px" height="50px">
                                                    @else
                                                        <img src="{{ asset('dist/img/50x50.png') }}"
                                                            alt="{{ $product->name }}">
                                                    @endif
                                                </td>
                                                <td>
                                                    <strong>{{ ucfirst($product->name) }}</strong>
                                                </td>
                                                <td class="text-right {{ $product->stock <= 0 ? 'text-danger' : '' }}">
                                                    {{ $product->stock }}</td>
                                                <td class="text-right">{{ number_format($product->price) }}</td>
                                                <td>{{ $product->category->name }}</td>
                                                <td>{{ $product->updated_at }}</td>
                                                @can('product-edit', 'product-delete')
                                                    <td>
                                                        @can('product-edit')
                                                            <a href=" {{ route('products.edit', $product->id) }}"
                                                                class="btn btn-warning btn-sm">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                        @endcan
                                                        @can('product-delete')
                                                            <form style="display: inline"
                                                                action="{{ route('products.destroy', $product->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                <input type="hidden" name="_method" value="DELETE">
                                                                <button class="btn btn-danger btn-sm">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        @endcan
                                                    </td>
                                                @endcan
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">No Data</td>
                                            </tr>
                                        @endforelse

                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center">
                                    {!! $products->links() !!}
                                </div>
                            </div>
                        </x-card>
                    </div>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection

<!-- The Modal -->
@section('modal')
    <div class="modal" id="myModal">
        <div class="modal-dialog modal-lg   ">
            <div class="modal-content">

                <div class="col-md-12">
                    <x-card title="" footer="">
                        @slot('title')
                            Filter Transaction
                        @endslot

                        <form role="form" method="post" action="{{ route('product.import') }}"
                            enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label>Document (.xlsx) <small style="color: red">*</small></label>
                                <input type="file" name="file" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success">Upload</button>
                            </div>
                        </form>
                    </x-card>
                </div>

            </div>
        </div>
    </div>
@endsection
