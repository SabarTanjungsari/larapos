@extends('layouts.master')

@section('title')
<title>Create New Role</title>
@endsection

@section('css')
<style type="text/css">
    .tab-pane {
        height: 150px;
        overflow-y: scroll;
    }
</style>
@endsection

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Create New Role</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Role</a></li>
                        <li class="breadcrumb-item active">Create</li>
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
                    <x-card title="Create New Role" footer="">
                        @slot('title')
                        @endslot

                        @if (session('errors'))
                        <x-alert type="error">{!! session('errors') !!}</x-alert>
                        @endif

                        <form action="{{ route('roles.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <strong>Name :</strong>
                                        <input type="text" name="name" required
                                            class="form-control {{ $errors->has('name') ? 'is-invalid':'' }}">
                                        <p class="text-danger">{{ $errors->first('name') }}</p>
                                    </div>
                                </div>
                            </div>


                            <div class="card card-row card-secondary">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        Permission
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div class="tab-pane active" id="tab_1">
                                        @php $no = 1; @endphp
                                        @foreach ($permissions as $key => $permission)
                                        <input type="checkbox" name="permission[]" value="{{$permission->id}}">
                                        <label>{{Str::ucfirst($permission->name)}}</label>
                                        <br>
                                        @if ($no++%5 == 0)
                                        <br>
                                        @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary btn-sm">
                                    <i class="fa fa-send"></i> Save
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
