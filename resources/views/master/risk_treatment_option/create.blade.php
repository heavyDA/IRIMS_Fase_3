@extends('layouts.app')

@section('header-content')
    <div>
        <h1 class="page-title fw-medium fs-18 mb-2">Form Tambah Opsi Perlakuan Risiko</h1>
        <div class="">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">Master</li>
                    <li class="breadcrumb-item"><a href="{{ route('master.risk_treatment_options.index') }}">Opsi Perlakuan
                            Risiko</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Form Tambah</li>
                </ol>
            </nav>
        </div>
    </div>
@endsection

@section('main-content')
    <x-card>
        <x-slot name="body">
            <form method="POST" action="{{ route('master.risk_treatment_options.store') }}" class="row gap-2">
                @csrf

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
                    <a class="btn btn-light" href="{{ route('master.risk_treatment_options.index') }}">Batal</a>
                </div>
            </form>
        </x-slot>
    </x-card>
@endsection
