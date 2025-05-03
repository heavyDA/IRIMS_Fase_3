@extends('layouts.app')

@push('bottom-script')
    @vite(['resources/js/pages/report/loss_event/form.js'])
@endpush

@section('header-content')
    <div>
        <h1 class="page-title fw-medium fs-18 mb-2">Form Tambah Catatan Kejadian Kerugian</h1>
        <div class="">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">Risk Report</li>
                    <li class="breadcrumb-item"><a href="{{ route('risk.report.loss_events.index') }}">Catatan Kejadian
                            Kerugian</a>
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
            <form id="loss-event-form" method="POST" action="{{ route('risk.report.loss_events.store') }}"
                class="row gap-2">
                @csrf
                <div class="row mb-1">
                    <div class="col-3">
                        <label for="worksheet">Profil Risiko</label>
                    </div>
                    <div class="col">
                        <select name="worksheet_id"
                            class="form-select {{ $errors->has('worksheet_id') ? 'is-invalid' : null }}">
                            @foreach ($worksheets as $worksheet)
                                <option {{ old('worksheet_id') == $worksheet->id ? 'selected' : null }}
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
                        Peristiwa Risiko
                    </div>
                    <div class="col">
                        <div id="incident_body-editor" class="textarea"></div>
                        <textarea type="text" name="incident_body" class="d-none {{ $errors->has('incident_body') ? 'is-invalid' : null }}">{{ old('incident_body') }}</textarea>
                        @error('incident_body')
                            <x-forms.error :message="$message"></x-forms.error>
                        @enderror
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-3">
                        Waktu Kejadian
                    </div>
                    <div class="col">
                        <input type="datetime-local"
                            class="form-control {{ $errors->has('incident_date') ? 'is-invalid' : null }}"
                            name="incident_date" value="{{ old('incident_date') }}">
                        @error('incident_date')
                            <x-forms.error :message="$message"></x-forms.error>
                        @enderror
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-3">
                        Sumber Penyebab Kejadian
                    </div>
                    <div class="col">
                        <div id="incident_source-editor" class="textarea"></div>
                        <textarea type="text" name="incident_source"
                            class="d-none {{ $errors->has('incident_source') ? 'is-invalid' : null }}">{{ old('incident_source') }}</textarea>
                        @error('incident_source')
                            <x-forms.error :message="$message"></x-forms.error>
                        @enderror
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-3">
                        Perlakuan atas Kejadian
                    </div>
                    <div class="col">
                        <div id="incident_handling-editor" class="textarea"></div>
                        <textarea type="text" name="incident_handling"
                            class="d-none {{ $errors->has('incident_handling') ? 'is-invalid' : null }}">{{ old('incident_handling') }}</textarea>
                        @error('incident_handling')
                            <x-forms.error :message="$message"></x-forms.error>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-3">Kategori Risiko T2</div>
                    <div class="col">
                        <select class="form-select {{ $errors->has('risk_category_t2_id') ? 'is-invalid' : null }}"
                            name="risk_category_t2_id">
                            <option>Pilih</option>
                            @foreach ($risk_categories as $parent)
                                <option {{ old('risk_category_t2_id') == $parent->id ? 'selected' : null }}
                                    value="{{ $parent->id }}">{{ $parent->name }}</option>
                            @endforeach
                        </select>
                        @error('risk_category_t2_id')
                            <x-forms.error :message="$message"></x-forms.error>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-3">Kategori Risiko T3</div>
                    <div class="col">
                        <select class="form-select {{ $errors->has('risk_category_t3_id') ? 'is-invalid' : null }}"
                            name="risk_category_t3_id">
                            <option>Pilih</option>
                            @foreach ($risk_categories as $parent)
                                @foreach ($parent->children as $child)
                                    <option {{ old('risk_category_t3_id') == $child->id ? 'selected' : null }}
                                        data-custom-properties='@json(['parent' => $parent->id])' value="{{ $child->id }}">
                                        {{ $child->name }}</option>
                                @endforeach
                            @endforeach
                        </select>
                        @error('risk_category_t3_id')
                            <x-forms.error :message="$message"></x-forms.error>
                        @enderror
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-3">
                        Nilai Kerugian
                    </div>
                    <div class="col">
                        <input type="text" class="form-control {{ $errors->has('loss_value') ? 'is-invalid' : null }}"
                            name="loss_value_format">
                        <input type="number" step=".01" class="d-none" name="loss_value"
                            value="{{ old('loss_value') }}">
                        @error('loss_value')
                            <x-forms.error :message="$message"></x-forms.error>
                        @enderror
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-3">
                        Pihak Terkait
                    </div>
                    <div class="col">
                        <div id="related_party-editor" class="textarea"></div>
                        <textarea type="text" name="related_party" class="d-none {{ $errors->has('related_party') ? 'is-invalid' : null }}">{{ old('related_party') }}</textarea>
                        @error('related_party')
                            <x-forms.error :message="$message"></x-forms.error>
                        @enderror
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-3">
                        Status Pemulihan Saat Ini
                    </div>
                    <div class="col">
                        <div id="restoration_status-editor" class="textarea"></div>
                        <textarea type="text" name="restoration_status"
                            class="d-none {{ $errors->has('restoration_status') ? 'is-invalid' : null }}">{{ old('restoration_status') }}</textarea>
                        @error('restoration_status')
                            <x-forms.error :message="$message"></x-forms.error>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-3">Status Asuransi</div>
                    <div class="col">
                        <div class="d-flex gap-4 {{ $errors->has('insurance_status') ? 'is-invalid' : null }}">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="insurance_status"
                                    id="insurance_status_true" value="1"
                                    {{ old('insurance_status') == 1 ? 'checked' : null }}>
                                <label class="form-check-label" for="insurance_status_true">
                                    Ya
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="insurance_status"
                                    id="insurance_status_false" value="0"
                                    {{ old('insurance_status') == 0 ? 'checked' : null }}>
                                <label class="form-check-label" for="insurance_status_false">
                                    Tidak
                                </label>
                            </div>
                        </div>
                        @error('insurance_status')
                            <x-forms.error :message="$message"></x-forms.error>
                        @enderror
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-3">
                        Nilai Premi
                    </div>
                    <div class="col">
                        <input type="text"
                            class="form-control {{ $errors->has('insurance_permit') ? 'is-invalid' : null }}"
                            name="insurance_permit_format">
                        <input type="number" step=".01" class="d-none" name="insurance_permit"
                            value="{{ old('insurance_permit') }}">
                        @error('insurance_permit')
                            <x-forms.error :message="$message"></x-forms.error>
                        @enderror
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-3">
                        Nilai Klaim
                    </div>
                    <div class="col">
                        <input type="text"
                            class="form-control {{ $errors->has('insurance_claim') ? 'is-invalid' : null }}"
                            name="insurance_claim_format">
                        <input type="number" step=".01" class="d-none" name="insurance_claim"
                            value="{{ old('insurance_claim') }}">
                        @error('insurance_claim')
                            <x-forms.error :message="$message"></x-forms.error>
                        @enderror
                    </div>
                </div>
                <div class="col-12 align-self-end">
                    <button class="btn btn-primary" type="submit">Simpan</button>
                    <a class="btn btn-light" href="{{ route('risk.report.loss_events.index') }}">Batal</a>
                </div>
            </form>
        </x-slot>
    </x-card>
@endsection
