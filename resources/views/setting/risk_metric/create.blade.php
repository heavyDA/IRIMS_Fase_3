@extends('layouts.app')

@push('top-script')
    @vite(['resources/js/pages/setting/risk_metric/form.js'])
@endpush

@section('header-content')
    <div>
        <h1 class="page-title fw-medium fs-18 mb-2">Form Tambah Matrik Strategi Risiko</h1>
        <div class="">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item">Pengaturan</li>
                    <li class="breadcrumb-item"><a href="{{ route('setting.risk_metrics.index') }}">Matrik Strategi Risiko</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Form Tambah</li>
                </ol>
            </nav>
        </div>
    </div>
@endsection

@section('main-content')
    <x-card>
        <x-slot name="body">
            <form id="risk-metrics-form" method="POST" action="{{ route('setting.risk_metrics.store') }}"
                class="row gap-2">
                @csrf
                <div class="col-12">
                    <label for="year">Tahun</label>
                    <select name="year" class="form-select {{ $errors->has('year') ? 'is-invalid' : null }}">
                        <option value="{{ Date('Y') }}">{{ Date('Y') }}</option>
                    </select>
                    @error('year')
                        <x-forms.error :message="$message"></x-forms.error>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="unit_code">Unit</label>
                    <select name="unit_code" class="form-select {{ $errors->has('unit_code') ? 'is-invalid' : null }}"
                        required>
                        <option value="">Pilih</option>
                        @foreach ($units as $unit)
                            <option {{ old('unit_code') == $unit->unit_code ? 'selected' : null }}
                                value="{{ $unit->unit_code }}">{{ "[{$unit->personnel_area_code}] $unit->unit_name" }}
                            </option>
                        @endforeach
                    </select>
                    @error('unit_code')
                        <x-forms.error :message="$message"></x-forms.error>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="capacity">Kapasitas</label>
                    <input value="{{ old('capacity') }}" name="capacity" type="text" required
                        class="form-control currency {{ $errors->has('capacity') ? 'is-invalid' : null }}" />
                    @error('capacity')
                        <x-forms.error :message="$message"></x-forms.error>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="appetite">Appetite</label>
                    <input value="{{ old('appetite') }}" name="appetite" type="text" required
                        class="form-control currency {{ $errors->has('appetite') ? 'is-invalid' : null }}" />
                    @error('appetite')
                        <x-forms.error :message="$message"></x-forms.error>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="tolerancy">Toleransi</label>
                    <input value="{{ old('tolerancy') }}" name="tolerancy" type="text" required
                        class="form-control currency {{ $errors->has('tolerancy') ? 'is-invalid' : null }}" />
                    @error('tolerancy')
                        <x-forms.error :message="$message"></x-forms.error>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="limit">Batasan</label>
                    <input value="{{ old('limit') }}" name="limit" type="text" required
                        class="form-control currency {{ $errors->has('limit') ? 'is-invalid' : null }}" />
                    @error('limit')
                        <x-forms.error :message="$message"></x-forms.error>
                    @enderror
                </div>
                <div class="col-12 align-self-end">
                    <button class="btn btn-primary" type="submit">Simpan</button>
                    <a class="btn btn-light" href="{{ route('setting.risk_metrics.index') }}">Batal</a>
                </div>
            </form>
        </x-slot>
    </x-card>
@endsection
