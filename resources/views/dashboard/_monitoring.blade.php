<!-- Top Risk -->
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-header justify-content-between border-bottom-0">
                <div class="card-title">
                    Progress Monitoring
                </div>
                <a href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseExample2"
                    aria-expanded="false" aria-controls="collapseExample">
                    <i class="ri-arrow-down-s-line fs-18 collapse-open"></i>
                    <i class="ri-arrow-up-s-line collapse-close fs-18"></i>
                </a>
            </div>
            <div class="collapse show border-top" id="collapseExample2">
                <div class="card-body overflow-scroll">
                    <table id="progress-monitoring-table" class="table text-nowrap table-striped">
                        <thead>
                            <tr>
                                <th rowspan="2" style="width: 256px;"></th>
                                <th colspan="12" class="text-center">Timeline</th>
                            </tr>
                            <tr>
                                @for ($i = 1; $i <= 12; $i++)
                                    <th class="text-center">
                                        {{ format_date(request('year', date('Y') . sprintf('-%02d', $i) . '-01'))->translatedFormat('M') }}
                                    </th>
                                @endfor
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($units as $key => $unit)
                                <tr>
                                    <td>{{ $unit->sub_unit_name }}</td>
                                    @for ($i = 1; $i <= 12; $i++)
                                        @if ($i == 1 && $key == 0)
                                            <td class="text-center bg-success-transparent">100%</td>
                                        @else
                                            <td class="text-center bg-warning-transparent">66%</td>
                                        @endif
                                    @endfor
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Top Risk -->
