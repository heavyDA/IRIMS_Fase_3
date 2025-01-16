@extends('layouts.app')

@push('top-script')
    @vite(['resources/js/pages/dashboard/index.js'])
@endpush

@section('header-content')
    <div>
        <h1 class="page-title fw-medium fs-18 mb-2">Dashboard </h1>

    </div>
@endsection

@section('main-content')
    <style>
        .avatar.avatar-xl {
            width: 6rem;
            height: 3rem;
            line-height: 4rem;
            font-size: 1.45rem;
        }

        .align-items-start {
            align-items: flex-start !important;
            min-height: 80px;
        }
    </style>
    <x-card>
        <x-slot name="body">
            <div class="row mb-12">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Tahun Laporan</label>
                <div class="col-sm-2">
                    <select class="form-select" aria-label="Default select example">
                        @for ($i = 3; $i <= 5; $i++)
                            <option {{ date('Y') == 2020 + $i ? 'selected' : '' }} value="{{ 2020 + $i }}">
                                {{ 2020 + $i }}</option>
                        @endfor
                    </select>
                </div>
                <label for="inputEmail3" class="col-sm-1 col-form-label">Unit Kerja</label>
                <div class="col-sm-4">
                    <input value="{{ auth()->user()->sub_unit_name }}" disabled class="form-control not-allowed" />
                </div>
            </div>

        </x-slot>
    </x-card>
    <!-- Start:: row-4-->
    <div class="row">
        <div class="col-xxl-4 col-xl-6">
            <div class="card custom-card p-2">
                <div class="card-body bg-light border">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <p class="mb-0 fs-17 fw-semibold">Risk Draft </p><br />

                        </div>
                        <div> <span class="avatar avatar-xl bg-primary fw-semibold">
                                <span>1022</span> </span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-xxl-4 col-xl-6">
            <div class="card custom-card p-2">
                <div class="card-body bg-light border">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <p class="mb-0 fs-17 fw-semibold">On Progress <br />Task </p>

                        </div>
                        <div> <span class="avatar avatar-xl bg-secondary fw-semibold">
                                <span>1</span> </span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-xxl-4 col-xl-6">
            <div class="card custom-card p-2">
                <div class="card-body bg-light border">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <p class="mb-0 fs-16 fw-semibold">Profil Risiko </p><br />

                        </div>
                        <div> <span class="avatar avatar-xl bg-success fw-semibold">
                                <span>12</span> </span>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
    <!-- End:: row-4 -->

    <!-- Start:: row-1 -->
    <!-- Start:: row-4-->
    <div class="row">
        <div class="col-xxl-4 col-xl-6">
            <div class="card custom-card p-2">
                <div class="card-body bg-light border">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <p class="mb-0 fs-16 fw-semibold">Jumlah Rencana <br /> Mitigasi </p>

                        </div>
                        <div> <span class="avatar avatar-xl bg-success fw-semibold">
                                <span>120</span> </span>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-xxl-4 col-xl-6">
            <div class="card custom-card p-2">
                <div class="card-body bg-light border">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <p class="mb-0 fs-16 fw-semibold">Jumlah Progres Tinjut
                                Rencana Mitigasi </p>

                        </div>
                        <div> <span class="avatar avatar-xl bg-success fw-semibold">
                                <span>120</span> </span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-xxl-4 col-xl-6">
            <div class="card custom-card p-2">
                <div class="card-body bg-light border">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <p class="mb-0 fs-16 fw-semibold">Jumlah Penyelesaian<br />
                                Mitigasi Risiko</p>

                        </div>
                        <div> <span class="avatar avatar-xl bg-success fw-semibold">
                                <span>120</span> </span>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
    </div>
    <!-- End:: row-4 -->

    <!-- Start:: row-1 -->
    <!-- Start:: row-4-->


    <!-- Start:: row-1 -->
    <div class="row">
        <div class="col-xl-6">
            <div class="card custom-card">
                <div class="card-header justify-content-between border-bottom-0">
                    <div class="card-title">
                        Risk Map Inheren
                    </div>
                    <a href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseExample"
                        aria-expanded="false" aria-controls="collapseExample">
                        <i class="ri-arrow-down-s-line fs-18 collapse-open"></i>
                        <i class="ri-arrow-up-s-line collapse-close fs-18"></i>
                    </a>
                </div>
                <div class="collapse show border-top" id="collapseExample">
                    <div class="card-body">

                        <div id="risk-chart-d3" style="height: 500px; width:550px;">
                            <svg width="100%" height="100%" viewBox="0 0 262 262">
                                <rect width="262" height="262" fill="white"></rect>
                                <g>
                                    <rect x="20" y="1" width="40" height="40" fill="white" stroke="white"></rect>
                                    <g>
                                        <rect x="20" y="2" width="39" height="38" fill="white" stroke="black"
                                            stroke-width="0.5"></rect>
                                        <text x="30" y="19" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Hampir</text>
                                        <text x="24" y="25" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Pasti Terjadi</text>
                                        <text x="36" y="30" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">5</text>
                                    </g>
                                    <g onclick="gotoheatmap(7)" style="cursor: pointer;">
                                        <rect x="61" y="1" width="40" height="40" fill="#92D050" stroke="white">
                                        </rect>
                                        <text x="70" y="20" font-family="arial" font-size="10" fill="black"
                                            font-weight="bold" id="val07"></text>
                                        <text x="64" y="30" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Low to</text>
                                        <text x="64" y="36" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Moderate (7)</text>
                                    </g>
                                    <g onclick="gotoheatmap(12)" style="cursor: pointer;">
                                        <rect x="101" y="1" width="40" height="40" fill="#FFFF00" stroke="white">
                                        </rect>
                                        <text x="110" y="20" font-family="arial" font-size="10" fill="black"
                                            font-weight="bold" id="val12"></text>
                                        <text x="104" y="36" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Moderate (12)</text>
                                    </g>
                                    <g onclick="gotoheatmap(17)" style="cursor: pointer;">
                                        <rect x="141" y="1" width="40" height="40" fill="#FFC000" stroke="white">
                                        </rect>
                                        <text x="151" y="20" font-family="arial" font-size="10" fill="black"
                                            font-weight="bold" id="val17"></text>
                                        <text x="144" y="30" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Moderate to</text>
                                        <text x="144" y="36" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">High (17)</text>
                                    </g>
                                    <g onclick="gotoheatmap(22)" style="cursor: pointer;">
                                        <rect x="181" y="1" width="40" height="40" fill="#FE0000" stroke="white">
                                        </rect>
                                        <text x="190" y="20" font-family="arial" font-size="10" fill="black"
                                            font-weight="bold" id="val22"></text>
                                        <text x="184" y="36" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">High (22)</text>
                                    </g>
                                    <g onclick="gotoheatmap(25)" style="cursor: pointer;">
                                        <rect x="221" y="1" width="40" height="40" fill="#FE0000" stroke="white">
                                        </rect>
                                        <text x="230" y="20" font-family="arial" font-size="10" fill="black"
                                            font-weight="bold" id="val25"></text>
                                        <text x="224" y="36" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">High (25)</text>
                                    </g>

                                </g>
                                <g>
                                    <rect x="20" y="41" width="40" height="40" fill="white" stroke="white">
                                    </rect>
                                    <g>
                                        <rect x="20" y="42" width="39" height="38" fill="white" stroke="black"
                                            stroke-width="0.5"></rect>
                                        <text x="30" y="55" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Sangat</text>
                                        <text x="28" y="62" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Mungkin</text>
                                        <text x="30" y="69" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Terjadi</text>
                                        <text x="36" y="75" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">4</text>
                                    </g>

                                    <g onclick="gotoheatmap(4)" style="cursor: pointer;">
                                        <rect x="61" y="41" width="40" height="40" fill="#00B050" stroke="white">
                                        </rect>
                                        <text x="70" y="62" font-family="arial" font-size="10" fill="black"
                                            font-weight="bold" id="val04"></text>
                                        <text x="64" y="76" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Low (4)</text>
                                    </g>
                                    <g onclick="gotoheatmap(9)" style="cursor: pointer;">
                                        <rect x="101" y="41" width="40" height="40" fill="#92D050"
                                            stroke="white"></rect>
                                        <text x="110" y="62" font-family="arial" font-size="10" fill="black"
                                            font-weight="bold" id="val09"></text>
                                        <text x="104" y="71" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Low to</text>
                                        <text x="104" y="77" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Moderate (9)</text>
                                    </g>
                                    <g onclick="gotoheatmap(14)" style="cursor: pointer;">
                                        <rect x="141" y="41" width="40" height="40" fill="#FFFF00"
                                            stroke="white"></rect>
                                        <text x="151" y="62" font-family="arial" font-size="10" fill="black"
                                            font-weight="bold" id="val14"></text>
                                        <text x="144" y="76" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Moderate (14)</text>
                                    </g>
                                    <g onclick="gotoheatmap(19)" style="cursor: pointer;">
                                        <rect x="181" y="41" width="40" height="40" fill="#FFC000"
                                            stroke="white"></rect>
                                        <text x="190" y="62" font-family="arial" font-size="10" fill="black"
                                            font-weight="bold" id="val19"></text>
                                        <text x="184" y="71" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Moderate to</text>
                                        <text x="184" y="77" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">High (19)</text>
                                    </g>
                                    <g onclick="gotoheatmap(24)" style="cursor: pointer;">
                                        <rect x="221" y="41" width="40" height="40" fill="#FE0000"
                                            stroke="white"></rect>
                                        <text x="230" y="62" font-family="arial" font-size="10" fill="black"
                                            font-weight="bold" id="val24"></text>
                                        <text x="224" y="76" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">High (24)</text>
                                    </g>


                                </g>
                                <g>
                                    <rect x="20" y="81" width="40" height="40" fill="white" stroke="white">
                                    </rect>
                                    <g>
                                        <rect x="20" y="82" width="39" height="38" fill="white" stroke="black"
                                            stroke-width="0.5"></rect>
                                        <text x="26" y="100" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Bisa Terjadi</text>
                                        <text x="36" y="108" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">3</text>
                                    </g>
                                    <g onclick="gotoheatmap(3)" style="cursor: pointer;">
                                        <rect x="61" y="81" width="40" height="40" fill="#00B050" stroke="white">
                                        </rect>
                                        <text x="70" y="102" font-family="arial" font-size="10" fill="black"
                                            font-weight="bold" id="val03"></text>
                                        <text x="64" y="115" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Low (3)</text>
                                    </g>
                                    <g onclick="gotoheatmap(8)" style="cursor: pointer;">
                                        <rect x="101" y="81" width="40" height="40" fill="#92D050"
                                            stroke="white"></rect>
                                        <text x="110" y="102" font-family="arial" font-size="10" fill="black"
                                            font-weight="bold" id="val08"></text>
                                        <text x="104" y="111" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Low to</text>
                                        <text x="104" y="117" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Moderate (8)</text>
                                    </g>
                                    <g onclick="gotoheatmap(13)" style="cursor: pointer;">
                                        <rect x="141" y="81" width="40" height="40" fill="#FFFF00"
                                            stroke="white"></rect>
                                        <text x="151" y="102" font-family="arial" font-size="10" fill="black"
                                            font-weight="bold" id="val13"></text>
                                        <text x="144" y="117" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Moderate (13)</text>
                                    </g>
                                    <g onclick="gotoheatmap(18)" style="cursor: pointer;">
                                        <rect x="181" y="81" width="40" height="40" fill="#FFC000"
                                            stroke="white"></rect>
                                        <text x="190" y="102" font-family="arial" font-size="10" fill="black"
                                            font-weight="bold" id="val18"></text>
                                        <text x="184" y="111" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Moderate to</text>
                                        <text x="184" y="117" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">High (18)</text>
                                    </g>
                                    <g onclick="gotoheatmap(23)" style="cursor: pointer;">
                                        <rect x="221" y="81" width="40" height="40" fill="#FE0000"
                                            stroke="white"></rect>
                                        <text x="230" y="102" font-family="arial" font-size="10" fill="black"
                                            font-weight="bold" id="val23"></text>
                                        <text x="224" y="117" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">High (23)</text>
                                    </g>

                                </g>
                                <g>
                                    <rect x="20" y="121" width="40" height="40" fill="white" stroke="white">
                                    </rect>
                                    <g>
                                        <rect x="20" y="122" width="39" height="38" fill="white" stroke="black"
                                            stroke-width="0.5"></rect>
                                        <text x="32" y="138" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Jarang</text>
                                        <text x="32" y="145" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Terjadi</text>
                                        <text x="36" y="152" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">2</text>
                                    </g>
                                    <g onclick="gotoheatmap(2)" style="cursor: pointer;">
                                        <rect x="61" y="121" width="40" height="40" fill="#00B050"
                                            stroke="white"></rect>
                                        <text x="70" y="142" font-family="arial" font-size="10" fill="black"
                                            font-weight="bold" id="val02"></text>
                                        <text x="64" y="155" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Low (2)</text>
                                    </g>
                                    <g onclick="gotoheatmap(6)" style="cursor: pointer;">
                                        <rect x="101" y="121" width="40" height="40" fill="#92D050"
                                            stroke="white"></rect>
                                        <text x="110" y="142" font-family="arial" font-size="10" fill="black"
                                            font-weight="bold" id="val06"></text>
                                        <text x="104" y="150" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Low to</text>
                                        <text x="104" y="156" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Moderate (6)</text>
                                    </g>
                                    <g onclick="gotoheatmap(11)" style="cursor: pointer;">
                                        <rect x="141" y="121" width="40" height="40" fill="#92D050"
                                            stroke="white"></rect>
                                        <text x="151" y="142" font-family="arial" font-size="10" fill="black"
                                            font-weight="bold" id="val11"></text>
                                        <text x="144" y="150" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Low to</text>
                                        <text x="144" y="156" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Moderate (11)</text>

                                    </g>
                                    <g onclick="gotoheatmap(16)" style="cursor: pointer;">
                                        <rect x="181" y="121" width="40" height="40" fill="#FFC000"
                                            stroke="white"></rect>
                                        <text x="190" y="142" font-family="arial" font-size="10" fill="black"
                                            font-weight="bold" id="val16"></text>
                                        <text x="184" y="150" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Moderate to</text>
                                        <text x="184" y="156" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">High (16)</text>
                                    </g>
                                    <g onclick="gotoheatmap(21)" style="cursor: pointer;">
                                        <rect x="221" y="121" width="40" height="40" fill="#FE0000"
                                            stroke="white"></rect>
                                        <text x="230" y="142" font-family="arial" font-size="10" fill="black"
                                            font-weight="bold" id="val21"></text>
                                        <text x="224" y="156" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">High (21)</text>
                                    </g>


                                </g>
                                <g>
                                    <rect x="20" y="161" width="40" height="40" fill="white" stroke="white">
                                    </rect>
                                    <g>
                                        <rect x="20" y="162" width="39" height="38" fill="white" stroke="black"
                                            stroke-width="0.5"></rect>
                                        <text x="31" y="175" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Sangat</text>
                                        <text x="31" y="181" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Jarang</text>
                                        <text x="31" y="188" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Terjadi</text>
                                        <text x="36" y="195" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">1</text>
                                    </g>
                                    <g onclick="gotoheatmap(1)" style="cursor: pointer;">
                                        <rect x="61" y="161" width="40" height="40" fill="#00B050"
                                            stroke="white"></rect>
                                        <text x="70" y="181" font-family="arial" font-size="10" fill="black"
                                            font-weight="bold" id="val01"></text>
                                        <text x="64" y="194" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Low (1)</text>
                                    </g>
                                    <g onclick="gotoheatmap(5)" style="cursor: pointer;">
                                        <rect x="101" y="161" width="40" height="40" fill="#00B050"
                                            stroke="white"></rect>
                                        <text x="110" y="181" font-family="arial" font-size="10" fill="black"
                                            font-weight="bold" id="val05"></text>
                                        <text x="104" y="194" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Low (5)</text>
                                    </g>
                                    <g onclick="gotoheatmap(10)" style="cursor: pointer;">
                                        <rect x="141" y="161" width="40" height="40" fill="#92D050"
                                            stroke="white"></rect>
                                        <text x="151" y="181" font-family="arial" font-size="10" fill="black"
                                            font-weight="bold" id="val10"></text>
                                        <text x="144" y="190" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Low to</text>
                                        <text x="144" y="196" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Moderate (10)</text>

                                    </g>
                                    <g onclick="gotoheatmap(15)" style="cursor: pointer;">
                                        <rect x="181" y="161" width="40" height="40" fill="#FFFF00"
                                            stroke="white"></rect>
                                        <text x="190" y="181" font-family="arial" font-size="10" fill="black"
                                            font-weight="bold" id="val15"></text>
                                        <text x="184" y="196" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Moderate (15)</text>
                                    </g>
                                    <g onclick="gotoheatmap(20)" style="cursor: pointer;">
                                        <rect x="221" y="161" width="40" height="40" fill="#FE0000"
                                            stroke="white"></rect>
                                        <text x="230" y="181" font-family="arial" font-size="10" fill="black"
                                            font-weight="bold" id="val20"></text>
                                        <text x="224" y="196" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">High (20)</text>
                                    </g>




                                </g>
                                <g>
                                    <rect x="20" y="201" width="40" height="40" fill="white" stroke="white">
                                    </rect>
                                    <rect x="61" y="201" width="40" height="40" fill="white" stroke="white">
                                    </rect>
                                    <g>
                                        <rect x="62" y="202" width="38" height="39" fill="white" stroke="black"
                                            stroke-width="0.5"></rect>
                                        <text x="80" y="220" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">1</text>
                                        <text x="64" y="229" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Sangat rendah</text>

                                    </g>
                                    <rect x="101" y="201" width="40" height="40" fill="white" stroke="white">
                                    </rect>
                                    <g>
                                        <rect x="102" y="202" width="38" height="39" fill="white"
                                            stroke="black" stroke-width="0.5"></rect>
                                        <text x="117" y="220" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">2</text>
                                        <text x="111" y="229" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Rendah</text>
                                    </g>
                                    <rect x="141" y="201" width="40" height="40" fill="white" stroke="white">
                                    </rect>
                                    <g>
                                        <rect x="142" y="202" width="38" height="39" fill="white"
                                            stroke="black" stroke-width="0.5"></rect>
                                        <text x="158" y="220" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">3</text>
                                        <text x="152" y="229" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Menengah</text>
                                    </g>
                                    <rect x="181" y="201" width="40" height="40" fill="white" stroke="white">
                                    </rect>
                                    <g>
                                        <rect x="182" y="202" width="38" height="39" fill="white"
                                            stroke="black" stroke-width="0.5"></rect>
                                        <text x="198" y="220" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">4</text>
                                        <text x="194" y="229" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Tinggi</text>
                                    </g>
                                    <rect x="221" y="201" width="40" height="40" fill="white" stroke="white">
                                    </rect>
                                    <g>
                                        <rect x="222" y="202" width="38" height="39" fill="white"
                                            stroke="black" stroke-width="0.5"></rect>
                                        <text x="238" y="220" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">5</text>
                                        <text x="226" y="229" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Tinggi Sekali</text>
                                        <rect x="0" y="2" width="15" height="198" fill="#DDDDDD" stroke="white"
                                            stroke-width="0.5"></rect>
                                        <text x="25" y="130" font-family="arial" font-size="6.5" fill="black"
                                            font-weight="bold" transform="rotate(270, 10, 130)">TNGKAT KEMUNGKINAN</text>
                                        <rect x="62" y="246" width="198" height="15" fill="#DDDDDD" stroke="white"
                                            stroke-width="0.5"></rect>
                                        <text x="137" y="256" font-family="arial" font-size="6.5" fill="black"
                                            font-weight="bold">TINGKAT DAMPAK</text>
                                    </g>
                                    <g>

                                    </g>
                                </g>
                            </svg>
                        </div>





                    </div>

                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card custom-card">
                <div class="card-header justify-content-between border-bottom-0">
                    <div class="card-title">
                        Risk Map Actual
                    </div>
                    <a href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseExample1"
                        aria-expanded="false" aria-controls="collapseExample">
                        <i class="ri-arrow-down-s-line fs-18 collapse-open"></i>
                        <i class="ri-arrow-up-s-line collapse-close fs-18"></i>
                    </a>
                </div>
                <div class="collapse show border-top" id="collapseExample1">
                    <div class="card-body">

                        <div id="risk-chart-d3" style="height: 500px; width:550px;">
                            <svg width="100%" height="100%" viewBox="0 0 262 262">
                                <rect width="262" height="262" fill="white"></rect>
                                <g>
                                    <rect x="20" y="1" width="40" height="40" fill="white" stroke="white">
                                    </rect>
                                    <g>
                                        <rect x="20" y="2" width="39" height="38" fill="white" stroke="black"
                                            stroke-width="0.5"></rect>
                                        <text x="30" y="19" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Hampir</text>
                                        <text x="24" y="25" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Pasti Terjadi</text>
                                        <text x="36" y="30" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">5</text>
                                    </g>
                                    <g onclick="gotoheatmapResidual()" style="cursor: pointer;">
                                        <rect x="61" y="1" width="40" height="40" fill="#92D050" stroke="white">
                                        </rect>
                                        <text x="70" y="20" font-family="arial" font-size="10" fill="black"
                                            font-weight="bold" id="actval07"></text>
                                        <text x="64" y="30" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Low to</text>
                                        <text x="64" y="36" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Moderate (7)</text>
                                    </g>
                                    <g onclick="gotoheatmapResidual()" style="cursor: pointer;">
                                        <rect x="101" y="1" width="40" height="40" fill="#FFFF00" stroke="white">
                                        </rect>
                                        <text x="110" y="20" font-family="arial" font-size="10" fill="black"
                                            font-weight="bold" id="actval12"></text>
                                        <text x="104" y="36" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Moderate (12)</text>
                                    </g>
                                    <g onclick="gotoheatmapResidual()" style="cursor: pointer;">
                                        <rect x="141" y="1" width="40" height="40" fill="#FFC000" stroke="white">
                                        </rect>
                                        <text x="151" y="20" font-family="arial" font-size="10" fill="black"
                                            font-weight="bold" id="actval17"></text>
                                        <text x="144" y="30" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Moderate to</text>
                                        <text x="144" y="36" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">High (17)</text>
                                    </g>
                                    <g onclick="gotoheatmapResidual()" style="cursor: pointer;">
                                        <rect x="181" y="1" width="40" height="40" fill="#FE0000" stroke="white">
                                        </rect>
                                        <text x="190" y="20" font-family="arial" font-size="10" fill="black"
                                            font-weight="bold" id="actval22"></text>
                                        <text x="184" y="36" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">High (22)</text>
                                    </g>
                                    <g onclick="gotoheatmapResidual()" style="cursor: pointer;">
                                        <rect x="221" y="1" width="40" height="40" fill="#FE0000" stroke="white">
                                        </rect>
                                        <text x="230" y="20" font-family="arial" font-size="10" fill="black"
                                            font-weight="bold" id="actval25"></text>
                                        <text x="224" y="36" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">High (25)</text>
                                    </g>

                                </g>
                                <g>
                                    <rect x="20" y="41" width="40" height="40" fill="white" stroke="white">
                                    </rect>
                                    <g>
                                        <rect x="20" y="42" width="39" height="38" fill="white" stroke="black"
                                            stroke-width="0.5"></rect>
                                        <text x="30" y="55" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Sangat</text>
                                        <text x="28" y="62" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Mungkin</text>
                                        <text x="30" y="69" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Terjadi</text>
                                        <text x="36" y="75" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">4</text>
                                    </g>

                                    <g onclick="gotoheatmapResidual()" style="cursor: pointer;">
                                        <rect x="61" y="41" width="40" height="40" fill="#00B050" stroke="white">
                                        </rect>
                                        <text x="70" y="62" font-family="arial" font-size="10" fill="black"
                                            font-weight="bold" id="actval04"></text>
                                        <text x="64" y="76" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Low (4)</text>
                                    </g>
                                    <g onclick="gotoheatmapResidual()" style="cursor: pointer;">
                                        <rect x="101" y="41" width="40" height="40" fill="#92D050"
                                            stroke="white"></rect>
                                        <text x="110" y="62" font-family="arial" font-size="10" fill="black"
                                            font-weight="bold" id="actval09"></text>
                                        <text x="104" y="71" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Low to</text>
                                        <text x="104" y="77" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Moderate (9)</text>
                                    </g>
                                    <g onclick="gotoheatmapResidual()" style="cursor: pointer;">
                                        <rect x="141" y="41" width="40" height="40" fill="#FFFF00"
                                            stroke="white"></rect>
                                        <text x="151" y="62" font-family="arial" font-size="10" fill="black"
                                            font-weight="bold" id="actval14"></text>
                                        <text x="144" y="76" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Moderate (14)</text>
                                    </g>
                                    <g onclick="gotoheatmapResidual()" style="cursor: pointer;">
                                        <rect x="181" y="41" width="40" height="40" fill="#FFC000"
                                            stroke="white"></rect>
                                        <text x="190" y="62" font-family="arial" font-size="10" fill="black"
                                            font-weight="bold" id="actval19"></text>
                                        <text x="184" y="71" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Moderate to</text>
                                        <text x="184" y="77" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">High (19)</text>
                                    </g>
                                    <g onclick="gotoheatmapResidual()" style="cursor: pointer;">
                                        <rect x="221" y="41" width="40" height="40" fill="#FE0000"
                                            stroke="white"></rect>
                                        <text x="230" y="62" font-family="arial" font-size="10" fill="black"
                                            font-weight="bold" id="actval24"></text>
                                        <text x="224" y="76" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">High (24)</text>
                                    </g>


                                </g>
                                <g>
                                    <rect x="20" y="81" width="40" height="40" fill="white" stroke="white">
                                    </rect>
                                    <g>
                                        <rect x="20" y="82" width="39" height="38" fill="white" stroke="black"
                                            stroke-width="0.5"></rect>
                                        <text x="26" y="100" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Bisa Terjadi</text>
                                        <text x="36" y="108" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">3</text>
                                    </g>
                                    <g onclick="gotoheatmapResidual()" style="cursor: pointer;">
                                        <rect x="61" y="81" width="40" height="40" fill="#00B050" stroke="white">
                                        </rect>
                                        <text x="70" y="102" font-family="arial" font-size="10" fill="black"
                                            font-weight="bold" id="actval03"></text>
                                        <text x="64" y="115" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Low (3)</text>
                                    </g>
                                    <g onclick="gotoheatmapResidual()" style="cursor: pointer;">
                                        <rect x="101" y="81" width="40" height="40" fill="#92D050"
                                            stroke="white"></rect>
                                        <text x="110" y="102" font-family="arial" font-size="10" fill="black"
                                            font-weight="bold" id="actval08"></text>
                                        <text x="104" y="111" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Low to</text>
                                        <text x="104" y="117" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Moderate (8)</text>
                                    </g>
                                    <g onclick="gotoheatmapResidual()" style="cursor: pointer;">
                                        <rect x="141" y="81" width="40" height="40" fill="#FFFF00"
                                            stroke="white"></rect>
                                        <text x="151" y="102" font-family="arial" font-size="10" fill="black"
                                            font-weight="bold" id="actval13"></text>
                                        <text x="144" y="117" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Moderate (13)</text>
                                    </g>
                                    <g onclick="gotoheatmapResidual()" style="cursor: pointer;">
                                        <rect x="181" y="81" width="40" height="40" fill="#FFC000"
                                            stroke="white"></rect>
                                        <text x="190" y="102" font-family="arial" font-size="10" fill="black"
                                            font-weight="bold" id="actval18"></text>
                                        <text x="184" y="111" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Moderate to</text>
                                        <text x="184" y="117" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">High (18)</text>
                                    </g>
                                    <g onclick="gotoheatmapResidual()" style="cursor: pointer;">
                                        <rect x="221" y="81" width="40" height="40" fill="#FE0000"
                                            stroke="white"></rect>
                                        <text x="230" y="102" font-family="arial" font-size="10" fill="black"
                                            font-weight="bold" id="actval23"></text>
                                        <text x="224" y="117" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">High (23)</text>
                                    </g>

                                </g>
                                <g>
                                    <rect x="20" y="121" width="40" height="40" fill="white"
                                        stroke="white"></rect>
                                    <g>
                                        <rect x="20" y="122" width="39" height="38" fill="white"
                                            stroke="black" stroke-width="0.5"></rect>
                                        <text x="32" y="138" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Jarang</text>
                                        <text x="32" y="145" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Terjadi</text>
                                        <text x="36" y="152" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">2</text>
                                    </g>
                                    <g onclick="gotoheatmapResidual()" style="cursor: pointer;">
                                        <rect x="61" y="121" width="40" height="40" fill="#00B050"
                                            stroke="white"></rect>
                                        <text x="70" y="142" font-family="arial" font-size="10" fill="black"
                                            font-weight="bold" id="actval02"></text>
                                        <text x="64" y="155" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Low (2)</text>
                                    </g>
                                    <g onclick="gotoheatmapResidual()" style="cursor: pointer;">
                                        <rect x="101" y="121" width="40" height="40" fill="#92D050"
                                            stroke="white"></rect>
                                        <text x="110" y="142" font-family="arial" font-size="10" fill="black"
                                            font-weight="bold" id="actval06"></text>
                                        <text x="104" y="150" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Low to</text>
                                        <text x="104" y="156" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Moderate (6)</text>
                                    </g>
                                    <g onclick="gotoheatmapResidual()" style="cursor: pointer;">
                                        <rect x="141" y="121" width="40" height="40" fill="#92D050"
                                            stroke="white"></rect>
                                        <text x="151" y="142" font-family="arial" font-size="10" fill="black"
                                            font-weight="bold" id="actval11"></text>
                                        <text x="144" y="150" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Low to</text>
                                        <text x="144" y="156" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Moderate (11)</text>

                                    </g>
                                    <g onclick="gotoheatmapResidual()" style="cursor: pointer;">
                                        <rect x="181" y="121" width="40" height="40" fill="#FFC000"
                                            stroke="white"></rect>
                                        <text x="190" y="142" font-family="arial" font-size="10" fill="black"
                                            font-weight="bold" id="actval16"></text>
                                        <text x="184" y="150" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Moderate to</text>
                                        <text x="184" y="156" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">High (16)</text>
                                    </g>
                                    <g onclick="gotoheatmapResidual()" style="cursor: pointer;">
                                        <rect x="221" y="121" width="40" height="40" fill="#FE0000"
                                            stroke="white"></rect>
                                        <text x="230" y="142" font-family="arial" font-size="10" fill="black"
                                            font-weight="bold" id="actval21"></text>
                                        <text x="224" y="156" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">High (21)</text>
                                    </g>


                                </g>
                                <g>
                                    <rect x="20" y="161" width="40" height="40" fill="white"
                                        stroke="white"></rect>
                                    <g>
                                        <rect x="20" y="162" width="39" height="38" fill="white"
                                            stroke="black" stroke-width="0.5"></rect>
                                        <text x="31" y="175" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Sangat</text>
                                        <text x="31" y="181" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Jarang</text>
                                        <text x="31" y="188" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Terjadi</text>
                                        <text x="36" y="195" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">1</text>
                                    </g>
                                    <g onclick="gotoheatmapResidual()" style="cursor: pointer;">
                                        <rect x="61" y="161" width="40" height="40" fill="#00B050"
                                            stroke="white"></rect>
                                        <text x="70" y="181" font-family="arial" font-size="10" fill="black"
                                            font-weight="bold" id="actval01"></text>
                                        <text x="64" y="194" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Low (1)</text>
                                    </g>
                                    <g onclick="gotoheatmapResidual()" style="cursor: pointer;">
                                        <rect x="101" y="161" width="40" height="40" fill="#00B050"
                                            stroke="white"></rect>
                                        <text x="110" y="181" font-family="arial" font-size="10" fill="black"
                                            font-weight="bold" id="actval05"></text>
                                        <text x="104" y="194" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Low (5)</text>
                                    </g>
                                    <g onclick="gotoheatmapResidual()" style="cursor: pointer;">
                                        <rect x="141" y="161" width="40" height="40" fill="#92D050"
                                            stroke="white"></rect>
                                        <text x="151" y="181" font-family="arial" font-size="10" fill="black"
                                            font-weight="bold" id="actval10"></text>
                                        <text x="144" y="190" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Low to</text>
                                        <text x="144" y="196" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Moderate (10)</text>

                                    </g>
                                    <g onclick="gotoheatmapResidual()" style="cursor: pointer;">
                                        <rect x="181" y="161" width="40" height="40" fill="#FFFF00"
                                            stroke="white"></rect>
                                        <text x="190" y="181" font-family="arial" font-size="10" fill="black"
                                            font-weight="bold" id="actval15"></text>
                                        <text x="184" y="196" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Moderate (15)</text>
                                    </g>
                                    <g onclick="gotoheatmapResidual()" style="cursor: pointer;">
                                        <rect x="221" y="161" width="40" height="40" fill="#FE0000"
                                            stroke="white"></rect>
                                        <text x="230" y="181" font-family="arial" font-size="10" fill="black"
                                            font-weight="bold" id="actval20"></text>
                                        <text x="224" y="196" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">High (20)</text>
                                    </g>




                                </g>
                                <g>
                                    <rect x="20" y="201" width="40" height="40" fill="white"
                                        stroke="white"></rect>
                                    <rect x="61" y="201" width="40" height="40" fill="white"
                                        stroke="white"></rect>
                                    <g>
                                        <rect x="62" y="202" width="38" height="39" fill="white"
                                            stroke="black" stroke-width="0.5"></rect>
                                        <text x="80" y="220" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">1</text>
                                        <text x="64" y="229" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Sangat rendah</text>

                                    </g>
                                    <rect x="101" y="201" width="40" height="40" fill="white"
                                        stroke="white"></rect>
                                    <g>
                                        <rect x="102" y="202" width="38" height="39" fill="white"
                                            stroke="black" stroke-width="0.5"></rect>
                                        <text x="117" y="220" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">2</text>
                                        <text x="111" y="229" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Rendah</text>
                                    </g>
                                    <rect x="141" y="201" width="40" height="40" fill="white"
                                        stroke="white"></rect>
                                    <g>
                                        <rect x="142" y="202" width="38" height="39" fill="white"
                                            stroke="black" stroke-width="0.5"></rect>
                                        <text x="158" y="220" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">3</text>
                                        <text x="152" y="229" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Menengah</text>
                                    </g>
                                    <rect x="181" y="201" width="40" height="40" fill="white"
                                        stroke="white"></rect>
                                    <g>
                                        <rect x="182" y="202" width="38" height="39" fill="white"
                                            stroke="black" stroke-width="0.5"></rect>
                                        <text x="198" y="220" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">4</text>
                                        <text x="194" y="229" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Tinggi</text>
                                    </g>
                                    <rect x="221" y="201" width="40" height="40" fill="white"
                                        stroke="white"></rect>
                                    <g>
                                        <rect x="222" y="202" width="38" height="39" fill="white"
                                            stroke="black" stroke-width="0.5"></rect>
                                        <text x="238" y="220" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">5</text>
                                        <text x="226" y="229" font-family="arial" font-size="5" fill="black"
                                            font-weight="bold">Tinggi Sekali</text>
                                        <rect x="0" y="2" width="15" height="198" fill="#DDDDDD"
                                            stroke="white" stroke-width="0.5"></rect>
                                        <text x="25" y="130" font-family="arial" font-size="6.5" fill="black"
                                            font-weight="bold" transform="rotate(270, 10, 130)">TNGKAT
                                            KEMUNGKINAN</text>
                                        <rect x="62" y="246" width="198" height="15" fill="#DDDDDD"
                                            stroke="white" stroke-width="0.5"></rect>
                                        <text x="137" y="256" font-family="arial" font-size="6.5" fill="black"
                                            font-weight="bold">TINGKAT DAMPAK</text>
                                    </g>
                                    <g>

                                    </g>
                                </g>
                            </svg>
                        </div>


                    </div>

                </div>
            </div>
        </div>

    </div>
    <!-- End:: row-1 -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header justify-content-between border-bottom-0">
                    <div class="card-title">
                        TOP RISK
                    </div>
                    <a href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseExample2"
                        aria-expanded="false" aria-controls="collapseExample">
                        <i class="ri-arrow-down-s-line fs-18 collapse-open"></i>
                        <i class="ri-arrow-up-s-line collapse-close fs-18"></i>
                    </a>
                </div>
                <div class="collapse show border-top" id="collapseExample2">
                    <div class="card-body">
                        <table id="tbltop10" class="table table-hover">
                            <thead>
                                <tr>
                                    <th>
                                        NO
                                    </th>
                                    <th style="text-align : center">
                                        KATEGORI RISIKO T2 & T3
                                    </th>
                                    <th style="text-align : center">
                                        PERISTIWA RISIKO
                                    </th>

                                    <th style="text-align : center">
                                        LEVEL RISIKO <br /> INHEREN
                                    </th>
                                    <th style="text-align : center">
                                        EXSPOSURE RISIKO <br /> INHEREN
                                    </th>
                                    <th style="text-align : center">
                                        LEVEL REALISASI <br /> RISIKO RESIDUAL
                                    </th>
                                    <th style="text-align : center">
                                        REALISASI EXSPOSURE <br /> RISIKO RESIDUAL
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- <tr>
                                   <td>1</td>
                                   <td>2</td>
                                   <td>3</td>
                                   <td>4</td>
                                   <td>5</td>
                                   <td>6</td>
                                 <tr>				 -->

                            </tbody>
                        </table>


                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
