<?php

namespace App\Http\Controllers\Risk;

use App\Enums\DocumentStatus;
use App\Http\Controllers\Controller;
use App\Models\Risk\Assessment\Worksheet;
use App\Models\Risk\Assessment\WorksheetStrategy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class AssessmentController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $worksheets = WorksheetStrategy::query()
                ->select([
                    'ra_worksheet_strategies.*',
                    'ra_worksheet_targets.body as target_body',

                ])
                ->join('ra_worksheet_targets', 'ra_worksheet_targets.id', '=', 'ra_worksheet_strategies.worksheet_target_id')
                ->with(['target.worksheet', 'target.worksheet.last_history']);

            return DataTables::eloquent($worksheets)
                ->addColumn('encrypted_id', function ($strategy) {
                    return Crypt::encryptString($strategy->target->worksheet->getEncryptedId());
                })
                ->editColumn('status', function ($strategy) {
                    $status = DocumentStatus::tryFrom($strategy->target->worksheet->status);
                    $class = $status->color();
                    $worksheet = $strategy->target->worksheet;
                    $worksheet->encrypted_id = $worksheet->getEncryptedId();

                    return view('risk.assessment._table_status', compact('status', 'class', 'worksheet'))->render();
                })
                ->rawColumns(['status'])
                ->make(true);
        }

        $title = 'Risk Assessment';

        return view('risk.assessment.index', compact('title'));
    }
}
