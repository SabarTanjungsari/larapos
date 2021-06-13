@extends('layouts.master')

@section('title')
<title>Edit Product Data</title>
@endsection

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Product</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('product.index') }}">Product</a></li>
                        <li class="breadcrumb-item active">Edit</li>
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
                    <x-card title="Add Product" footer="">
                        @slot('title')
                        @endslot

                        @if (session('error'))
                        <x-alert type="danger">{!! session('error') !!}</x-alert>
                        @endif

                        <form action="{{ route('product.update', $product->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="_method" value="PUT">
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label for="">Product Code</label>
                                    <input readonly type="text" name="code" required maxlength="10"
                                        value="{{$product->code}}"
                                        class="form-control {{ $errors->has('code') ? 'is-invalid':'' }}">
                                    <p class="text-danger">{{ $errors->first('code') }}</p>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="">Product Name</label>
                                    <input type="text" name="name" required value="{{$product->name}}"
                                        class="form-control {{ $errors->has('name') ? 'is-invalid':'' }}">
                                    <p class="text-danger">{{ $errors->first('name') }}</p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="">Description</label>
                                <textarea name="description" id="description" cols="5" rows="2"
                                    class="form-control {{ $errors->has('description') ? 'is-invalid':'' }}">{{$product->description}}</textarea>
                                <p class="text-danger">{{ $errors->first('description') }}</p>
                            </div>

                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label for="">Stock</label>
                                    <input type="number" name="stock" required value="{{$product->stock}}"
                                        class="form-control {{ $errors->has('stock') ? 'is-invalid':'' }}">
                                    <p class="text-danger">{{ $errors->first('stock') }}</p>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="">Price</label>
                                    <input type="number" name="price" required value="{{$product->price}}"
                                        class="form-control {{ $errors->has('price') ? 'is-invalid':'' }}">
                                    <p class="text-danger">{{ $errors->first('price') }}</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label for="">Category</label>
                                    <select name="category_id" id="category_id" required
                                        class="form-control {{ $errors->has('category') ? 'is-invalid':'' }}">
                                        <option value=""> - Select -</option>
                                        @foreach ($categories as $row)
                                        <option value="{{ $row->id }}"
                                            {{$row->id == $product->category_id ? 'selected' : ''}}>
                                            {{ ucfirst($row->name) }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <p class="text-danger">{{ $errors->first('category_id') }}</p>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="">Foto</label>
                                    <input type="file" name="photo" class="form-control">
                                    <p class="text-danger">{{ $errors->first('photo') }}</p>
                                    <hr>
                                    <img src="{{asset('uploads/product/'.$product->photo)}}" alt="{{$product->name}}"
                                        width="150px" height="150px">
                                </div>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary btn-sm">
                                    <i class="fa fa-send"></i> Update
                                </button>
                            </div>
                        </form>

                    </x-card>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
@endsection
