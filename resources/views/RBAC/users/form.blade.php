@extends('layouts.app')

@section('header-content')
    <div>
        <h1 class="page-title fw-medium fs-18 mb-2">{{ $title }} </h1>
        <div class="">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                </ol>
            </nav>
        </div>
    </div>
@endsection

@section('main-content')
    <div class="row">
        <div class="col-12 col-md-10 col-lg-8">
            <x-card>
                <x-slot name="body">
                    @isset($user)
                        {{ html()->modelForm('PUT', route('rbac.user.update', $user->id))->open() }}
                    @else
                        {{ html()->form('POST', route('rbac.user.store'))->open() }}
                    @endisset
                    <div class="row">
                        <div class="col-12 col-md-3 col-lg-2">
                            <label for="first_name" class="form-label">Nama Depan</label>
                        </div>
                        <div class="col-12 col-md-8">
                            {{ html()->text('first_name')->class(['form-control', 'mb-3', $errors->has('first_name') ? 'is-invalid' : null])->placeholder('Masukkan Nama Depan') }}
                            @error('first_name')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-3 col-lg-2">
                            <label for="last_name" class="form-label">Nama Belakang</label>
                        </div>
                        <div class="col-12 col-md-8">
                            {{ html()->text('last_name')->class(['form-control', 'mb-3', $errors->has('last_name') ? 'is-invalid' : null])->placeholder('Masukkan Nama Belakang') }}
                            @error('last_name')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-3 col-lg-2">
                            <label for="" class="form-label">Email</label>
                        </div>
                        <div class="col-12 col-md-8">
                            {{ html()->email('email')->class(['form-control', 'mb-3', $errors->has('email') ? 'is-invalid' : null])->placeholder('Masukkan Email') }}
                            @error('email')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-3 col-lg-2">
                            <label for="" class="form-label">Email</label>
                        </div>
                        <div class="col-12 col-md-8">
                            {{ html()->text('username')->class(['form-control', 'mb-3', $errors->has('username') ? 'is-invalid' : null])->placeholder('Masukkan Email') }}
                            @error('username')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-3 col-lg-2">
                            <label for="" class="form-label">Email</label>
                        </div>
                        <div class="col-12 col-md-8">
                            {{ html()->email('email')->class(['form-control', 'mb-3', $errors->has('email') ? 'is-invalid' : null])->placeholder('Masukkan Email') }}
                            @error('email')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-3 col-lg-2">
                            <label for="password" class="form-label">Kata Sandi</label>
                        </div>
                        <div class="col-12 col-md-8">
                            {{ html()->password('password')->class(['form-control', 'mb-3', $errors->has('password') ? 'is-invalid' : null])->placeholder('Masukkan Kata Sandi') }}
                            @error('password')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-3 col-lg-2">
                            <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
                        </div>
                        <div class="col-12 col-md-8">
                            {{ html()->password('password_confirmation')->class(['form-control', 'mb-3', $errors->has('password_confirmation') ? 'is-invalid' : null])->placeholder('Masukkan Konfirmasi Kata Sandi') }}
                            @error('password_confirmation')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-3 col-lg-2"></div>
                        <div class="col-12 col-md-8">
                            <a onclick="confirm('Apakah anda yakin ingin membatalkan?') ? true: event.preventDefault()"
                                class="btn btn-w-lg btn-secondary-light float-end"
                                href="{{ route('rbac.user.index') }}">Batal</a>
                            <button class="btn btn-w-lg btn-primary-light float-end mx-3" type="submit">Simpan</button>
                        </div>
                    </div>
                    @isset($user)
                        {{ html()->modelForm()->close() }}
                    @else
                        {{ html()->form()->close() }}
                    @endisset
                </x-slot>
            </x-card>
        </div>
    </div>
@endsection
