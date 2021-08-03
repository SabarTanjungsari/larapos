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

                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <td>#</td>
                                            <td>Name</td>
                                            <td>Stock</td>
                                            <td>Price</td>
                                            <td>Category</td>
                                            <td>Last Update</td>
                                            <td>Action</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($products as $product )
                                            <tr>
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
                                                    <sup class="text text-success">{{ $product->code }}</sup>
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
