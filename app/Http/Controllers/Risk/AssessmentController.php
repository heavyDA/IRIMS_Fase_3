<?php

namespace App\Http\Controllers\Risk;

use App\Enums\DocumentStatus;
use App\Http\Controllers\Controller;
use App\Models\Risk\Assessment\Worksheet;
use App\Models\Risk\Assessment\WorksheetIdentificationIncident;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class AssessmentController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $incidents = WorksheetIdentificationIncident::query()
                ->with([
                    'identification' => fn($q) => $q->with(['target.worksheet']),
                    'inherent',
                ])
                ->when(
                    request('year', date('Y')),
                    fn($q) => $q->whereHas('identification', fn($q) => $q->whereHas('target', fn($q) => $q->whereHas('worksheet', fn($q) => $q->whereYear('created_at', request('year')))))
                );

            return DataTables::eloquent($incidents)
                ->addColumn('encrypted_id', function ($incident) {
                    return Crypt::encryptString($incident->identification->target->worksheet->getEncryptedId());
                })
                ->editColumn('status', function ($incident) {
                    $status = DocumentStatus::tryFrom($incident->identification->target->worksheet->status);
                    $class = $status->color();
                    $worksheet = $incident->identification->target->worksheet;
                    $worksheet->encrypted_id = $worksheet->getEncryptedId();

                    return view('risk.assessment._table_status', compact('status', 'class', 'worksheet'))->render();
                })
                ->rawColumns(['status'])
                ->make(true);
        }

        $title = 'Risk Assessment';
        $years = Worksheet::selectRaw('YEAR(created_at) as year')->groupBy('year')->get()->pluck('year');
        if (empty($years)) {
            $years = [date('Y')];
        }

        $positions = cache()->get('master.positions', []);

        return view('risk.assessment.index', compact('title', 'years', 'positions'));
    }
}
