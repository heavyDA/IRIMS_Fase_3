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
    <x-card>
        <x-slot name="body">
            <form method="POST" action="{{ route('master.bumn_scales.store') }}" class="row gap-2">
                @csrf
                <div class="col-12">
                    <label for="employee_id">Nomor Pegawai</label>
                    <input value="{{ old('employee_id') }}" name="employee_id" type="text" required
                        class="form-control {{ $errors->has('employee_id') ? 'is-invalid' : null }}" />
                    @error('employee_id')
                        <x-forms.error :message="$message"></x-forms.error>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="employee_name">Nama Pegawai</label>
                    <input value="{{ old('employee_name') }}" name="employee_name" type="text" required
                        class="form-control {{ $errors->has('employee_name') ? 'is-invalid' : null }}" />
                    @error('employee_name')
                        <x-forms.error :message="$message"></x-forms.error>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="sub_unit_code">Unit</label>
                    <select class="form-select" id="form-sub-unit-code" required name="sub_unit_code">
                        <option>Pilih</option>
                        @foreach ($units as $unit)
                            <option value="{{ $unit->sub_unit_code }}">[{{ $unit->sub_unit_code_doc }}]
                                {{ $unit->sub_unit_name }} - {{ $unit->position_name }}</option>
                        @endforeach
                    </select>
                    @error('sub_unit_code')
                        <x-forms.error :message="$message"></x-forms.error>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="email">Email</label>
                    <input value="{{ old('email') }}" name="email" type="email" required
                        class="form-control {{ $errors->has('email') ? 'is-invalid' : null }}" />
                    @error('email')
                        <x-forms.error :message="$message"></x-forms.error>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="username">Username</label>
                    <input value="{{ old('username') }}" name="username" type="text" required
                        class="form-control {{ $errors->has('username') ? 'is-invalid' : null }}" />
                    @error('username')
                        <x-forms.error :message="$message"></x-forms.error>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="password">Kata Sandi</label>
                    <input value="{{ old('password') }}" name="password" type="password" required
                        class="form-control {{ $errors->has('password') ? 'is-invalid' : null }}" />
                    @error('password')
                        <x-forms.error :message="$message"></x-forms.error>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="password_confirmation">Konfirmasi Kata Sandi</label>
                    <input value="{{ old('password_confirmation') }}" name="password_confirmation"
                        type="password_confirmation" required
                        class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : null }}" />
                    @error('password_confirmation')
                        <x-forms.error :message="$message"></x-forms.error>
                    @enderror
                </div>
                <div class="col-12 align-self-end">
                    <button class="btn btn-primary" type="submit">Simpan</button>
                    <a class="btn btn-light" href="{{ route('master.bumn_scales.index') }}">Batal</a>
                </div>
            </form>
        </x-slot>
    </x-card>
@endsection
