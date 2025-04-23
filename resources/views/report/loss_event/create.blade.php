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
                        Nama Kejadian
                    </div>
                    <div class="col">
                        <div id="incident_body-editor" class="textarea"></div>
                        <textarea type="text" name="incident_body" class="d-none {{ $errors->has('incident_body') ? 'is-invalid' : null }}"></textarea>
                        @error('incident_body')
                            <x-forms.error :message="$message"></x-forms.error>
                        @enderror
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-3">
                        Identifikasi Kejadian
                    </div>
                    <div class="col">
                        <div id="incident_identification-editor" class="textarea"></div>
                        <textarea type="text" name="incident_identification"
                            class="d-none {{ $errors->has('incident_identification') ? 'is-invalid' : null }}"></textarea>
                        @error('incident_identification')
                            <x-forms.error :message="$message"></x-forms.error>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-3">Kategori Kejadian</div>
                    <div class="col">
                        <select class="form-select {{ $errors->has('incident_category') ? 'is-invalid' : null }}"
                            name="incident_category">
                            <option value>Pilih</option>
                            @foreach ($incident_categories as $item)
                                <option {{ old('incident_category') == $item->id ? 'selected' : null }}
                                    value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        @error('incident_category')
                            <x-forms.error :message="$message"></x-forms.error>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-3">Sumber Penyebab Kejadian</div>
                    <div class="col">
                        <select class="form-select {{ $errors->has('incident_source') ? 'is-invalid' : null }}"
                            name="incident_source">
                            <option value>Pilih</option>
                            <option value="internal">Internal</option>
                            <option value="eksternal">Eksternal</option>
                        </select>
                        @error('incident_source')
                            <x-forms.error :message="$message"></x-forms.error>
                        @enderror
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-3">
                        Penyebab Kejadian
                    </div>
                    <div class="col">
                        <div id="incident_cause-editor" class="textarea"></div>
                        <textarea type="text" name="incident_cause"
                            class="d-none {{ $errors->has('incident_cause') ? 'is-invalid' : null }}"></textarea>
                        @error('incident_cause')
                            <x-forms.error :message="$message"></x-forms.error>
                        @enderror
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-3">
                        Penanganan Saat Kejadian
                    </div>
                    <div class="col">
                        <div id="incident_handling-editor" class="textarea"></div>
                        <textarea type="text" name="incident_handling"
                            class="d-none {{ $errors->has('incident_handling') ? 'is-invalid' : null }}"></textarea>
                        @error('incident_handling')
                            <x-forms.error :message="$message"></x-forms.error>
                        @enderror
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-3">
                        Deskripsi Kejadian
                    </div>
                    <div class="col">
                        <div id="incident_description-editor" class="textarea"></div>
                        <textarea type="text" name="incident_description"
                            class="d-none {{ $errors->has('incident_description') ? 'is-invalid' : null }}"></textarea>
                        @error('incident_description')
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
                        Penjelasan Kerugian
                    </div>
                    <div class="col">
                        <div id="loss_description-editor" class="textarea"></div>
                        <textarea type="text" name="loss_description"
                            class="d-none {{ $errors->has('loss_description') ? 'is-invalid' : null }}"></textarea>
                        @error('loss_description')
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
                        <input type="number" class="d-none" name="loss_value">
                        @error('loss_value')
                            <x-forms.error :message="$message"></x-forms.error>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-3">Kejadian Berulang</div>
                    <div class="col">
                        <div class="d-flex gap-4 {{ $errors->has('incident_repetitive') ? 'is-invalid' : null }}">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="incident_repetitive"
                                    id="incident_repetitive_true" value="1">
                                <label class="form-check-label" for="incident_repetitive_true">
                                    Ya
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="incident_repetitive"
                                    id="incident_repetitive_false" value="0">
                                <label class="form-check-label" for="incident_repetitive_false">
                                    Tidak
                                </label>
                            </div>
                        </div>
                        @error('incident_repetitive')
                            <x-forms.error :message="$message"></x-forms.error>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-3">Frekuensi Kejadian</div>
                    <div class="col">
                        <select class="form-select {{ $errors->has('incident_frequency_id') ? 'is-invalid' : null }}"
                            name="incident_frequency_id">
                            <option value>Pilih</option>
                            @foreach ($frequencies as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        @error('incident_frequency_id')
                            <x-forms.error :message="$message"></x-forms.error>
                        @enderror
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-3">
                        Mitigasi yang Direncanakan
                    </div>
                    <div class="col">
                        <div id="mitigation_plan-editor" class="textarea"></div>
                        <textarea type="text" name="mitigation_plan"
                            class="d-none {{ $errors->has('mitigation_plan') ? 'is-invalid' : null }}"></textarea>
                        @error('mitigation_plan')
                            <x-forms.error :message="$message"></x-forms.error>
                        @enderror
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-3">
                        Realisasi Mitigasi
                    </div>
                    <div class="col">
                        <div id="actualization_plan-editor" class="textarea"></div>
                        <textarea type="text" name="actualization_plan"
                            class="d-none {{ $errors->has('actualization_plan') ? 'is-invalid' : null }}"></textarea>
                        @error('actualization_plan')
                            <x-forms.error :message="$message"></x-forms.error>
                        @enderror
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-3">
                        Perbaikan Mendatang
                    </div>
                    <div class="col">
                        <div id="follow_up_plan-editor" class="textarea"></div>
                        <textarea type="text" name="follow_up_plan"
                            class="d-none {{ $errors->has('follow_up_plan') ? 'is-invalid' : null }}"></textarea>
                        @error('follow_up_plan')
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
                        <textarea type="text" name="related_party"
                            class="d-none {{ $errors->has('related_party') ? 'is-invalid' : null }}"></textarea>
                        @error('related_party')
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
                                    id="insurance_status_true" value="1">
                                <label class="form-check-label" for="insurance_status_true">
                                    Ya
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="insurance_status"
                                    id="insurance_status_false" value="0">
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
                        <input type="number" class="d-none" name="insurance_permit">
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
                        <input type="number" class="d-none" name="insurance_claim">
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
