@extends('layouts.app')

@push('bottom-script')
    @vite(['resources/js/pages/report/alteration/form.js'])
@endpush

@section('header-content')
    <div>
        <h1 class="page-title fw-medium fs-18 mb-2">Form Tambah Perubahan Strategi Risiko</h1>
        <div class="">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">Risk Report</li>
                    <li class="breadcrumb-item"><a href="{{ route('risk.report.alterations.index') }}">Perubahan Strategi
                            Risiko</a>
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
            <form id="alteration-form" method="POST"
                action="{{ route('risk.report.alterations.update', $alteration->getEncryptedId()) }}" class="row gap-2">
                @csrf
                @method('PATCH')
                <div class="row mb-1">
                    <div class="col-3">
                        <label for="worksheet">Profil Risiko</label>
                    </div>
                    <div class="col">
                        <select name="worksheet_id"
                            class="form-select {{ $errors->has('worksheet_id') ? 'is-invalid' : null }}">
                            @foreach ($worksheets as $worksheet)
                                <option {{ $worksheet->id == $alteration->worksheet_id ? 'selected' : null }}
                                    value="{{ $worksheet->id }}">
                                    <div class="d-flex flex-column">
                                        <div>{!! html_entity_decode($worksheet->target_body) !!}</div>
                                        <small class="d-flex flex-column">
                                            <strong>{{ $worksheet->worksheet_number }}</strong>
                                            <span>[{{ $worksheet->personnel_area_code }}]
                                                {{ $worksheet->sub_unit_name }}</span>
                                        </small>
                                    </div>
                                </option>
                            @endforeach
                        </select>
                        @error('worksheet_id')
                            <x-forms.error :message="$message"></x-forms.error>
                        @enderror
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-3">
                        <label for="body">Jenis Perubahan</label>
                    </div>
                    <div class="col">
                        <div id="body-editor" class="textarea"></div>
                        <textarea name="body" class="form-control d-none {{ $errors->has('body') ? 'is-invalid' : null }}">{!! $alteration->body !!}</textarea>
                        @error('body')
                            <x-forms.error :message="$message"></x-forms.error>
                        @enderror
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-3">
                        <label for="impact">Perisitwa Risiko yang Terdampak atas Perubahan</label>
                    </div>
                    <div class="col">
                        <div id="impact-editor" class="textarea"></div>
                        <textarea name="impact" class="form-control d-none {{ $errors->has('impact') ? 'is-invalid' : null }}">{!! $alteration->impact !!}</textarea>
                        @error('impact')
                            <x-forms.error :message="$message"></x-forms.error>
                        @enderror
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-3">
                        <label for="description">Penjelasan</label>
                    </div>
                    <div class="col">
                        <div id="description-editor" class="textarea"></div>
                        <textarea name="description" class="form-control d-none {{ $errors->has('description') ? 'is-invalid' : null }}">{!! $alteration->description !!}</textarea>
                        @error('description')
                            <x-forms.error :message="$message"></x-forms.error>
                        @enderror
                    </div>
                </div>
                <div class="col-12 align-self-end">
                    <button class="btn btn-primary" type="submit">Simpan</button>
                    <a class="btn btn-light" href="{{ route('risk.report.alterations.index') }}">Batal</a>
                </div>
            </form>
        </x-slot>
    </x-card>
@endsection
