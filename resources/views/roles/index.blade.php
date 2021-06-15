@extends('layouts.master')

@section('title')
<title>Role Manajement</title>
@endsection

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Role Management</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">0
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Role</li>
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

                        <form role="form" action="{{ route('role.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Role</label>
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
                    <x-card title="List of Role" footer="">
                        @if (session('success'))
                        <x-alert type="success">{!! session('success') !!}</x-alert>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <td>#</td>
                                        <td>Role</td>
                                        <td>Guard</td>
                                        <td>Created At</td>
                                        <td>Action</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $no = 1;
                                    @endphp
                                    @forelse ($roles as $role)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td>{{ $role->guard_name }}</td>
                                        <td>{{ $role->created_at }}</td>
                                        <td>
                                            <form action="{{ route('role.destroy', $role->id) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button class="btn btn-danger btn-sm">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <td colspan="4" class="text-center">No Role Data</td>
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
