@extends('layouts.master')

@section('title')
<title>{{ $partner->id == null ? 'Add' : 'Edit'}} Partner</title>
@endsection

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ $partner->id == null ? 'Add' : 'Edit'}} Partner</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('partners.index') }}">Partner</a></li>
                        <li class="breadcrumb-item active">{{ $partner->id == null ? 'Add' : 'Edit'}}</li>
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
                    <x-card title="Add Partner" footer="">
                        @slot('title')
                        @endslot

                        <form class="disabled"
                            action="{{ $partner->id == null ? route('partners.store') : route('partners.update', $partner->id) }}"
                            method="post">
                            @csrf
                            @if ($partner->id != null)
                            <input type="hidden" name="_method" value="PUT">
                            @endif

                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label for="">Partner Name</label>
                                    <input type="text" name="name" value="{{$partner->name}}"
                                        class="form-control {{ $errors->has('name') ? 'is-invalid':'' }}" <p
                                        class="text-danger">{{ $errors->first('name') }}</p>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="">Email</label>
                                    <input type="email" name="email" value="{{$partner->email}}"
                                        class="form-control {{ $errors->has('email') ? 'is-invalid':'' }}" <p
                                        class="text-danger">{{ $errors->first('email') }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-check col-sm-2 col-4">
                                    <input class="form-check-input" type="checkbox" name="iscustomer"
                                        {{ $partner->iscustomer == true ? 'checked' : ''}}>
                                    <label for="customCheckbox1">Customer</label>
                                    <p class="text-danger">{{ $errors->first('iscustomer') }}</p>
                                </div>

                                <div class="form-check col-sm-2 col-4">
                                    <input class="form-check-input" type="checkbox" name="isvendor"
                                        {{ $partner->isvendor == true ? 'checked' : ''}}>
                                    <label for="customCheckbox1">Vendor</label>
                                    <p class="text-danger">{{ $errors->first('isvendor') }}</p>
                                </div>
                                <div class="form-check col-sm-2 col-4">
                                    <input class="form-check-input" type="checkbox"
                                        {{ ($partner->id == null || $partner->isactive == true) ? 'checked' : ''}}
                                        name='isactive'>
                                    <label for="customCheckbox1">Active</label>
                                    <p class="text-danger">{{ $errors->first('isactive') }}</p>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="">Phone</label>
                                    <input type="text" name="phone" value="{{$partner->phone}}"
                                        class="form-control {{ $errors->has('phone') ? 'is-invalid':'' }}"
                                        value="{{$partner->phone}}">
                                    <p class="text-danger">{{ $errors->first('phone') }}</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">Address</label>
                                <textarea name="address" cols="5" rows="2"
                                    class="form-control {{ $errors->has('address') ? 'is-invalid':'' }}">{{$partner->address}}</textarea>
                                <p class="text-danger">{{ $errors->first('address') }}</p>
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
