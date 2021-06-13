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
                    <h1 class="m-0">Category Manajement</h1>
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
                <div class="col-md-6">
                    <x-card title="Add" footer="Save">
                        @if (session('error'))
                        <x-alert type="info">{!! session('error') !!}</x-alert>
                        @endif

                        <form role="form" action="{{ route('category.update', $category->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="_method" value="PUT">
                            <div class="form-group">
                                <label for="name">Category</label>
                                <input type="text" name="name" value="{{ $category->name }}"
                                    class="form-control {{ $errors->has('name') ? 'is-invalid':'' }}" id="name"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="description">Deskripsi</label>
                                <textarea name="description" id="description" cols="5" rows="5"
                                    class="form-control {{ $errors->has('description') ? 'is-invalid':'' }}">{{ $category->description }}</textarea>
                            </div>

                            @slot('footer')
                            <div class="card-footer">
                                <button class="btn btn-primary">Update</button>
                            </div>
                        </form>
                        @endslot
                    </x-card>
                </div>

            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

@endsection
