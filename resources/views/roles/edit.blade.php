@extends('layouts.master')

@section('title')
<title>Edit Role</title>
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
                    <h1 class="m-0">Edit Role</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Role</a></li>
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
                    <x-card title="" footer="">
                        @slot('title')
                        @endslot

                        <form action="{{ route('roles.update', $role->id) }}" method="post">
                            @csrf
                            <input type="hidden" name="_method" value="PUT">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="">Role Name</label>
                                    <input type="text" name="name" value="{{$role->name}}"
                                        class="form-control {{ $errors->has('name') ? 'is-invalid':'' }}">
                                    <p class="text-danger">{{ $errors->first('name') }}</p>
                                </div>
                            </div>

                            <div
                                class="card card-row {{ $errors->has('permission') ? 'card-danger':'card-secondary' }}">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        Permission
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div class="tab-pane active" id="tab_1">
                                        @php $no = 1; $header = '';@endphp
                                        @foreach ($permission as $value)

                                        <input type="checkbox" name="permission[]" value="{{$value->id}}"
                                            {{in_array($value->id, $rolePermissions) ? 'checked' : ''}}>
                                        <label>{{Str::ucfirst($value->name)}}</label>
                                        <br>
                                        @if ($no++%5 == 0)
                                        <hr>
                                        @endif
                                        @endforeach
                                    </div>
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
