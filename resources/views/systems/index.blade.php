@extends('layouts.master')

@section('title')
<title>System Manajement</title>
@endsection

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">System Management</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">System</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            @if (session('success'))
            <x-alert type="success">{!! session('success') !!}</x-alert>
            @endif

            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 d-flex align-items-stretch flex-column">
                    <div class="card bg-light d-flex flex-fill">
                        <div class="card-header text-muted border-bottom-0">
                            Identity Information
                        </div>
                        <div class="card-body pt-0">
                            <div class="row">
                                <div class="col-5 text-center">
                                    <img src="{{ !empty(session('identity')[0]['photo']) ? asset('dist/img/'.session('identity')[0]['photo']) : asset('dist/img/AdminLTELogo.png') }}"
                                        alt="{{ session('identity')[0]['name'] }}"
                                        class="img-circle img-fluid img-bordered" width="150px" height="150px">
                                </div>
                                <div class="col-7">
                                    <h2 class="lead"><b>{{ session('identity')[0]['name'] }}</b></h2>
                                    <ul class="ml-4 mb-0 fa-ul text-muted">
                                        <li>
                                            <span class="fa-li">
                                                <i class="fas fa-lg fa-map-marked"></i>
                                            </span> {{ session('identity')[0]['address'] }}
                                        </li>
                                        <li>
                                            <span class="fa-li">
                                                <i class="fas fa-lg fa-envelope"></i>
                                            </span>
                                            {{ session('identity')[0]['email'] }}
                                        </li>
                                        <li>
                                            <span class="fa-li">
                                                <i class="fas fa-lg fa-phone"></i>
                                            </span>
                                            {{ session('identity')[0]['phone'] }}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="text-center">
                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">
                                    <i class="fas fa-id-card"></i> Edit Identity
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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

                <form action="{{ route('system.update', 1) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <div class="modal-header">
                        <h3 id="myModalLabel">Modal header</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label for="">Name</label>
                                <input type="text" name="name" value="{{ session('identity')[0]['name'] }}"
                                    class="form-control {{ $errors->has('name') ? 'is-invalid':'' }}">
                                <p class="text-danger">{{ $errors->first('name') }}</p>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="">Email</label>
                                <input type="email" name="email" value="{{ session('identity')[0]['email'] }}"
                                    class="form-control {{ $errors->has('email') ? 'is-invalid':'' }}">
                                <p class="text-danger">{{ $errors->first('email') }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-12">
                                <label for="">Address</label>
                                <textarea name="address" cols="5" rows="2"
                                    class="form-control {{ $errors->has('address') ? 'is-invalid':'' }}">{{session('identity')[0]['address']}}</textarea>
                                <p class="text-danger">{{ $errors->first('address') }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label for="">Phone</label>
                                <input type="text" name="phone" value="{{ session('identity')[0]['phone'] }}"
                                    class="form-control">
                                <p class=" text-danger">{{ $errors->first('email') }}</p>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="">Foto</label>
                                <input type="file" name="photo" class="form-control" accept=".gif,.jpg,.jpeg,.png">
                                <p class="text-danger">{{ $errors->first('photo') }}</p>
                                <hr>
                                @if (session('identity')[0]['photo'])
                                <img src="{{asset('dist/img/'.session('identity')[0]['photo'])}}"
                                    class="img-circle img-fluid img-bordered" width="150px" height="150px">
                                @else
                                <img src="{{asset('dist/img/AdminLTELogo.png')}}"
                                    class="img-circle img-fluid img-bordered" width="150px" height="150px">
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                        <button class="btn btn-primary">Save changes</button>
                    </div>
                </form>

            </div>

        </div>
    </div>
</div>
@endsection
