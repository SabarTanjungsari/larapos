@extends('layouts.master')

@section('title')
<title>{{ $user->id == null ? 'Add' : 'Edit'}} User</title>
@endsection

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ $user->id == null ? 'Add' : 'Edit'}} User</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('users.index') }}">User</a></li>
                        <li class="breadcrumb-item active">{{ $user->id == null ? 'Add' : 'Edit'}}</li>
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

                        <form action="{{ $user->id == null ? route('users.store') : route('users.update', $user->id) }}"
                            method="post" enctype="multipart/form-data">
                            @csrf
                            @if ($user->id != null)
                            <input type="hidden" name="_method" value="PUT">
                            @endif

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Name</label>
                                        <input type="text" name="name" value="{{ $user->name }}" value="{{$user->name}}"
                                            class="form-control {{ $errors->has('name') ? 'is-invalid':'' }}">
                                        <p class="text-danger">{{ $errors->first('name') }}</p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Email</label>
                                        <input type="email" name="email" value="{{ $user->email }}"
                                            value="{{$user->email}}"
                                            class="form-control {{ $errors->has('email') ? 'is-invalid':'' }}">
                                        <p class="text-danger">{{ $errors->first('email') }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Password</label>
                                        <input type="password" name="password"
                                            class="form-control {{ $errors->has('password') ? 'is-invalid':'' }}">
                                        <p class="text-danger">{{ $errors->first('password') }}</p>
                                        <p class="text-warning">Leave it blank, if you don't want to change the password
                                        </p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Role</label>
                                        <select name="role"
                                            class="form-control {{ $errors->has('role') ? 'is-invalid':'' }}">
                                            <option value="">Change</option>
                                            @foreach ($roles as $role)
                                            <option value="{{ $role->name }}"
                                                {{ $user->role == $role->name ? 'selected' : ''}}>
                                                {{ $role->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <p class="text-danger">{{ $errors->first('role') }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label for="">Foto</label>
                                    <input type="file" name="photo" class="form-control" accept=".gif,.jpg,.jpeg,.png">
                                    <p class="text-danger">{{ $errors->first('photo') }}</p>
                                </div>
                                <div class="form-group col-sm-6">

                                    @if ($user->photo)
                                    <img src="{{asset('uploads/user/'.$user->photo)}}" alt="{{$user->name}}"
                                        width="150px" height="150px">
                                    @else
                                    <img src="{{asset('uploads/user/avatar.png')}}" alt="{{$user->name}}" width="150px"
                                        height="150px">
                                    @endif
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
