@extends('layouts.master')

@section('title')
<title>Users Management</title>
@endsection

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Users Management</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">User</li>
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
                    <x-card title="List of Category" footer="">
                        @slot('title')
                        <a href="{{ route('user.create') }}" class="btn btn-primary btn-sm">
                            <i class="fa fa-plus-circle"></i> Add
                        </a>
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
                                        <td>Email</td>
                                        <td>Role</td>
                                        <td>Status</td>
                                        <td>Actions</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $no = 1; @endphp
                                    @forelse ($users as $user )
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>
                                            @foreach ($user->getRoleNames() as $role)
                                            <label for="" class="badge badge-info">{{ $role }}</label>
                                            @endforeach
                                        </td>
                                        <td>
                                            @if ($user->status)
                                            <label class="badge badge-success">Active</label>
                                            @else
                                            <label for="" class="badge badge-default">Suspend</label>
                                            @endif
                                        </td>
                                        <td>
                                            <form action="{{ route('user.destroy', $user->id) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="_method" value="DELETE">
                                                <a href="{{ route('user.roles', $user->id) }}"
                                                    class="btn btn-info btn-sm"><i class="fa fa-user-secret"></i></a>
                                                <a href="{{ route('user.edit', $user->id) }}"
                                                    class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                                                <button class="btn btn-danger btn-sm"><i
                                                        class="fa fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center">No Data</td>
                                    </tr>
                                    @endforelse

                                </tbody>
                            </table>
                            <div class="float-right">
                                {!! $users->links() !!}
                            </div>
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
