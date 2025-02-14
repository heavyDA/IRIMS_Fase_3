@extends('layouts.app')

@section('header-content')
    <div>
        <h1 class="page-title fw-medium fs-18 mb-2">Form Tambah Kategori Risiko</h1>
        <div class="">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item">Master</li>
                    <li class="breadcrumb-item"><a href="{{ route('master.risk_categories.index') }}">Kategori Risiko</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Form Tambah</li>
                </ol>
            </nav>
        </div>
    </div>
@endsection

@section('main-content')
    <x-card>
        <x-slot name="body">
            <form method="POST" action="{{ route('master.risk_categories.store') }}" class="row gap-2">
                @csrf
                <div class="col-12">
                    <label for="type">Tipe Kategori</label>
                    <select name="type" class="form-select {{ $errors->has('type') ? 'is-invalid' : null }}" required>
                        <option value="">Pilih</option>
                        <option {{ old('type') == 'T2' ? 'selected' : null }} value="T2">T2
                        </option>
                        <option {{ old('type') == 'T3' ? 'selected' : null }} value="T3">T3
                        </option>
                    </select>
                    @error('type')
                        <x-forms.error :message="$message"></x-forms.error>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="name">Nama</label>
                    <input value="{{ old('name') }}" name="name" type="text" required
                        class="form-control {{ $errors->has('name') ? 'is-invalid' : null }}" />
                    @error('name')
                        <x-forms.error :message="$message"></x-forms.error>
                    @enderror
                </div>
                <div class="col-12 align-self-end">
                    <button class="btn btn-primary" type="submit">Simpan</button>
                    <a class="btn btn-light" href="{{ route('master.risk_categories.index') }}">Batal</a>
                </div>
            </form>
        </x-slot>
    </x-card>
@endsection
