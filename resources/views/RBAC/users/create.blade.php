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

@push('bottom-script')
    @vite(['resources/js/pages/RBAC/users/form.js'])
@endpush

@section('main-content')
    <x-card>
        <x-slot name="body">
            <form method="POST" action="{{ route('rbac.users.store') }}" class="row gap-2" id="userForm">
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
                    <label for="email">Email</label>
                    <input value="{{ old('email') }}" name="email" type="email" required
                        class="form-control {{ $errors->has('email') ? 'is-invalid' : null }}" />
                    @error('email')
                        <x-forms.error :message="$message"></x-forms.error>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="role">Role</label>
                    <select class="form-select {{ $errors->has('role') || $errors->has('role.*') ? 'is-invalid' : null }}"
                        required name="role[]" multiple>
                        <option value="risk admin" {{ in_array('risk admin', old('role', [])) ? 'selected' : null }}>Risk
                            Admin</option>
                        <option value="risk owner" {{ in_array('risk owner', old('role', [])) ? 'selected' : null }}>Risk
                            Owner</option>
                        <option value="risk otorisator"
                            {{ in_array('risk otorisator', old('role', [])) ? 'selected' : null }}>Risk Otorisator</option>
                        <option value="risk analis" {{ in_array('risk analis', old('role', [])) ? 'selected' : null }}>Risk
                            Analis</option>
                        <option value="risk reviewer" {{ in_array('risk reviewer', old('role', [])) ? 'selected' : null }}>
                            Risk Reviewer</option>
                    </select>
                    @error('role')
                        <x-forms.error :message="$message"></x-forms.error>
                    @enderror
                    @error('role.*')
                        <x-forms.error :message="$message"></x-forms.error>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="sub_unit_code">Unit</label>
                    <select data-value="{{ old('sub_unit_code') }}" class="form-select" required
                        name="sub_unit_code"></select>
                    @error('sub_unit_code')
                        <x-forms.error :message="$message"></x-forms.error>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="position_name">Nama Posisi</label>
                    <input value="{{ old('position_name') }}" name="position_name" type="text" required
                        class="form-control {{ $errors->has('position_name') ? 'is-invalid' : null }}" />
                    @error('position_name')
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
                    <a class="btn btn-light" href="{{ route('rbac.users.index') }}">Batal</a>
                </div>
            </form>
        </x-slot>
    </x-card>
@endsection
