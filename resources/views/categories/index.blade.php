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
                    <h1 class="m-0">Edit Category</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Category</a></li>
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
                <div class="col-md-4">
                    <x-card title="Add" footer="Save">
                        @if (session('error'))
                        <x-alert type="info">{!! session('error') !!}</x-alert>
                        @endif

                        <form role="form" action="{{ route('category.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Categori</label>
                                <input type="text" name="name"
                                    class="form-control {{ $errors->has('name') ? 'is-invalid':'' }}" id="name"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="description">Deskripsi</label>
                                <textarea name="description" id="description" cols="5" rows="5"
                                    class="form-control {{ $errors->has('description') ? 'is-invalid':'' }}"></textarea>
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
                    <x-card title="List of Category" footer="">
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
                                            <form action="{{ route('category.destroy', $category->id) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="_method" value="DELETE">
                                                <a href="{{ route('category.edit', $category->id) }}"
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
