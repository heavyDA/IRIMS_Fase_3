@extends('layouts.app')

@section('header-content')
    <div>
        <h1 class="page-title fw-medium fs-18 mb-2">Form Edit Skala</h1>
        <div class="">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">Master</li>
                    <li class="breadcrumb-item"><a href="{{ route('master.bumn_scales.index') }}">Skala</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Form Edit</li>
                </ol>
            </nav>
        </div>
    </div>
@endsection

@section('main-content')
    <x-card>
        <x-slot name="body">
            <form method="POST" action="{{ route('master.bumn_scales.update', $bumn_scale->getEncryptedId()) }}"
                class="row gap-2">
                @csrf
                @method('PATCH')
                <div class="col-12">
                    <label for="impact_category">Kategori Dampak</label>
                    <select name="impact_category"
                        class="form-select {{ $errors->has('impact_category') ? 'is-invalid' : null }}" required>
                        <option value="">Pilih</option>
                        <option
                            {{ old('impact_category', $bumn_scale->impact_category) == 'kualitatif' ? 'selected' : null }}
                            value="kualitatif">Kualitatif</option>
                        <option
                            {{ old('impact_category', $bumn_scale->impact_category) == 'kuantitatf' ? 'selected' : null }}
                            value="kuantitatf">Kuantitatf</option>
                    </select>
                    @error('impact_category')
                        <x-forms.error :message="$message"></x-forms.error>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="scale">Skala</label>
                    <input value="{{ old('scale', $bumn_scale->scale) }}" name="scale" type="text" required
                        class="form-control {{ $errors->has('scale') ? 'is-invalid' : null }}" />
                    @error('scale')
                        <x-forms.error :message="$message"></x-forms.error>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="criteria">Kriteria</label>
                    <input value="{{ old('criteria', $bumn_scale->criteria) }}" name="criteria" type="text" required
                        class="form-control {{ $errors->has('criteria') ? 'is-invalid' : null }}" />
                    @error('criteria')
                        <x-forms.error :message="$message"></x-forms.error>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="description">Deskripsi</label>
                    <textarea name="description" cols="4"
                        class="form-control {{ $errors->has('description') ? 'is-invalid' : null }}">{{ old('description', $bumn_scale->description) }}</textarea>
                    @error('description')
                        <x-forms.error :message="$message"></x-forms.error>
                    @enderror
                </div>
                <div class="col-12 row p-0 m-0">
                    <div class="col-12 col-md-6">
                        <label for="min">Nilai Minimal</label>
                        <input value="{{ old('min', $bumn_scale->min) }}" name="min" type="number" required
                            class="form-control {{ $errors->has('min') ? 'is-invalid' : null }}" />
                        @error('min')
                            <x-forms.error :message="$message"></x-forms.error>
                        @enderror
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="max">Nilai Maksimal</label>
                        <input value="{{ old('max', $bumn_scale->max) }}" name="max" type="number" required
                            class="form-control {{ $errors->has('max') ? 'is-invalid' : null }}" />
                        @error('max')
                            <x-forms.error :message="$message"></x-forms.error>
                        @enderror
                    </div>
                </div>
                <div class="col-12 align-self-end">
                    <button class="btn btn-primary" type="submit">Simpan</button>
                    <a class="btn btn-light" href="{{ route('master.bumn_scales.index') }}">Batal</a>
                </div>
            </form>
        </x-slot>
    </x-card>
@endsection
