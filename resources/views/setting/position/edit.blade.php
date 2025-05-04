@extends('layouts.app')

@push('top-script')
    @vite(['resources/js/pages/setting/position/form.js'])
@endpush

@section('header-content')
    <div>
        <h1 class="page-title fw-medium fs-18 mb-2">Form Edit Posisi</h1>
        <div class="">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">Pengaturan</li>
                    <li class="breadcrumb-item"><a href="{{ route('setting.positions.index') }}">Posisi</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Form Edit</li>
                </ol>
            </nav>
        </div>
    </div>
@endsection

@section('main-content')
    <x-card>
        <x-slot name="body">
            <form method="POST" id="position-form"
                action="{{ route('setting.positions.update', $position->getEncryptedId()) }}" class="row gap-2">
                @csrf
                @method('PATCH')
                <div class="col-12">
                    <label for="sub_unit_code">Unit</label>
                    <select data-value="{{ $position->sub_unit_code }}" class="form-select" required
                        name="sub_unit_code"></select>
                    @error('sub_unit_code')
                        <x-forms.error :message="$message"></x-forms.error>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="position_name">Nama Posisi</label>
                    <input value="{{ $position->position_name }}" name="position_name" type="text" required
                        class="form-control {{ $errors->has('position_name') ? 'is-invalid' : null }}" />
                    @error('position_name')
                        <x-forms.error :message="$message"></x-forms.error>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="roles">Role</label>
                    <select class="form-select {{ $errors->has('roles') || $errors->has('roles.*') ? 'is-invalid' : null }}"
                        required name="roles[]" multiple>
                        <option value="risk admin" {{ in_array('risk admin', $position->role) ? 'selected' : null }}>Risk
                            Admin</option>
                        <option value="risk owner" {{ in_array('risk owner', $position->role) ? 'selected' : null }}>Risk
                            Owner</option>
                        <option value="risk otorisator"
                            {{ in_array('risk otorisator', $position->role) ? 'selected' : null }}>
                            Risk Otorisator</option>
                        <option value="risk analis" {{ in_array('risk analis', $position->role) ? 'selected' : null }}>Risk
                            Analis</option>
                        <option value="risk analis pusat"
                            {{ in_array('risk analis pusat', $position->role) ? 'selected' : null }}>Risk
                            Analis Pusat</option>
                        <option value="risk reviewer" {{ in_array('risk reviewer', $position->role) ? 'selected' : null }}>
                            Risk Reviewer</option>
                    </select>
                    @error('roles')
                        <x-forms.error :message="$message"></x-forms.error>
                    @enderror
                    @error('roles.*')
                        <x-forms.error :message="$message"></x-forms.error>
                    @enderror
                </div>
                <div class="col-12 align-self-end">
                    <button class="btn btn-primary" type="submit">Simpan</button>
                    <a class="btn btn-light" href="{{ route('setting.positions.index') }}">Batal</a>
                </div>
            </form>
        </x-slot>
    </x-card>
@endsection
