@extends('layouts.master')

@section('title')
<title>Role Permission</title>
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
                    <h1 class="m-0">Role Permission</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Role Permission</li>
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
                    <x-card title="Add New Permissions" footer="Save">
                        @if (session('error'))
                        <x-alert type="info">{!! session('error') !!}</x-alert>
                        @endif

                        <form role="form" action="{{ route('users.add_permission') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name"
                                    class="form-control {{ $errors->has('name') ? 'is-invalid':'' }}" id="name"
                                    required>
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
                    <x-card title="Set Permission to Role" footer="">
                        @if (session('success'))
                        <x-alert type="success">{!! session('success') !!}</x-alert>
                        @endif

                        <form action="{{ route('users.roles_permission') }}" method="GET">
                            <div class="form-group">
                                <label for="">Roles</label>
                                <div class="input-group">
                                    <select name="role" class="form-control">
                                        @foreach ($roles as $value)
                                        <option value="{{ $value }}"
                                            {{ request()->get('role') == $value ? 'selected':'' }}>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    <span class="input-group-btn">
                                        <button class="btn btn-danger">Check!</button>
                                    </span>
                                </div>
                            </div>
                        </form>

                        @if (!empty($permissions))
                        <form action="{{ route('users.setRolePermission', request()->get('role')) }}" method="post">
                            @csrf
                            <input type="hidden" name="_method" value="PUT">
                            <div class="form-group">
                                <div class="nav-tabs-custom">
                                    <ul class="nav nav-tabs">
                                        <li class="active">
                                            <a href="#tab_1" data-toggle="tab">Permissions</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab_1">
                                            @php $no = 1; @endphp
                                            @foreach ($permissions as $key => $permission)
                                            <input type="checkbox" name="permission[]" class="minimal-red"
                                                value="{{$permission}}"
                                                {{in_array($permission, $hasPermission) ? 'checked' : ''}}>
                                            {{$permission}}
                                            <br>
                                            @if ($no++%4 == 0)
                                            <br>
                                            @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="pull-right">
                                <button class="btn btn-primary btn-sm">
                                    <i class="fa fa-send">Set Permission</i>
                                </button>
                            </div>
                        </form>
                        @endif
                    </x-card>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

@endsection
