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
                    <ol class="breadcrumb float-sm-right">
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
            <div class="col-md-12">
                @if (session('success'))
                <x-alert type="success">{!! session('success') !!}</x-alert>
                @endif
                <x-card title="" footer="">

                    @slot('title')
                    List of Role

                    @can('role-create')
                    <a class="btn btn-success btn-sm" href="{{ route('roles.create') }}">
                        <i class="fa fa-plus-circle"></i>
                    </a>
                    @endcan

                    @endslot

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <td>#</td>
                                    <td>Role</td>
                                    <td>Guard</td>
                                    <td>Created At</td>
                                    <td width="280px">Action</td>
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
                                        @can('role-show')
                                        <a href="{{ route('roles.show', $role->id ) }}" class="btn btn-info btn-sm">
                                            <i class="fa fa-search-plus"></i>
                                        </a>
                                        @endcan
                                        @can('role-edit')
                                        <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-warning btn-sm">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        @endcan
                                        @can('role-delete')
                                        <form style="display: inline" action="{{ route('roles.destroy', $role->id) }}"
                                            method="POST">
                                            @csrf
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button class="btn btn-danger btn-sm">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                        @endcan
                                    </td>
                                </tr>
                                @empty
                                <td colspan="4" class="text-center">No Role Data</td>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="float-right">
                            {!! $roles->links() !!}
                        </div>
                    </div>
                </x-card>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

@endsection
