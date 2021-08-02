@extends('layouts.master')

@section('title')
    <title>Category Manajement</title>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Management Category
                            <a href="{{ route('export.category') }}" class="btn btn-outline-info btn-sm">
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
                            <li class="breadcrumb-item active">Category</li>
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
                    <div class="col-md-4">
                        <x-card title="Add" footer="Save">
                            @if (session('error'))
                                <x-alert type="info">{!! session('error') !!}</x-alert>
                            @endif

                            <form role="form" action="{{ route('categories.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Categori</label>
                                    <input type="text" name="name"
                                        class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" id="name"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="description">Deskripsi</label>
                                    <textarea name="description" id="description" cols="5" rows="5"
                                        class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}"></textarea>
                                </div>

                                @slot('footer')
                                    <div class="card-footer">
                                        <button class="btn btn-primary">Save</button>
                                    </div>
                                </form>
                            @endslot
                        </x-card>
                    </div>

                    <div class="col-md-8">
                        <x-card title="" footer="">
                            @slot('title')
                                List of category
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
                                            <td>Description</td>
                                            <td>Action</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no = 1;
                                        @endphp
                                        @forelse ($categories as $category)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $category->name }}</td>
                                                <td>{{ $category->description }}</td>
                                                <td>
                                                    <form action="{{ route('categories.destroy', $category->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <a href="{{ route('categories.edit', $category->id) }}"
                                                            class="btn btn-warning btn-sm">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        <button class="btn btn-danger btn-sm">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <td colspan="4" class="text-center">No Category Data</td>
                                        @endforelse
                                    </tbody>
                                </table>
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

                    <form role="form" method="post" action="{{ route('import.category') }}"
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
