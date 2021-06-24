@extends('layouts.master')

@section('title')
<title>Partner Management</title>
@endsection

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Partner Management</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Partner</li>
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
                        @can('partner-create')
                        List Business Partner
                        <a href="{{ route('partners.create') }}" class="btn btn-primary btn-flat btn-sm">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                        </a>
                        @endcan
                        @endslot

                        @if (session('success'))
                        <x-alert type="success">{!! session('success') !!}</x-alert>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr class="text-center">
                                        <td>#</td>
                                        <td>Name</td>
                                        <td>Email</td>
                                        <td>Customer</td>
                                        <td>Vendor</td>
                                        <td>Phone</td>
                                        <td>Action</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $i = 1;
                                    @endphp
                                    @forelse ($partners as $partner )
                                    <tr class="{{$partner->isactive == false ? 'text-danger' : ''}}">
                                        <td>{{$i++}}</td>
                                        <td>{{$partner->name}}</td>
                                        <td>{{$partner->email}}</td>
                                        <td class="text-center">
                                            @if ($partner->iscustomer == true)
                                            <i class="far fa-circle text-primary"></i>
                                            @else
                                            <i class="far fa-circle text-danger"></i>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($partner->isvendor == true)
                                            <i class="far fa-circle text-primary"></i>
                                            @else
                                            <i class="far fa-circle text-danger"></i>
                                            @endif
                                        </td>
                                        <td>{{$partner->phone}}</td>
                                        @can('partner-edit', 'partner-delete')
                                        <td class="text-center">
                                            @can('partner-edit')
                                            <a href="{{ route('partners.edit', $partner->id) }}"
                                                class="btn btn-warning btn-sm">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            @endcan
                                            @can('partner-delete')
                                            <form style="display: inline"
                                                action="{{ route('partners.destroy', $partner->id) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button class="btn btn-danger btn-sm">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                            @endcan
                                        </td>
                                        @endcan
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No Data</td>
                                    </tr>
                                    @endforelse

                                </tbody>
                            </table>
                            <div class="float-right">
                                {!! $partners->links() !!}
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
