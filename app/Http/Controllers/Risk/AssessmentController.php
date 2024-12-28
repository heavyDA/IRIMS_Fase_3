<?php

namespace App\Http\Controllers\Risk;

use App\Http\Controllers\Controller;
use App\Models\Risk\Assessment\Worksheet;
use App\Models\Risk\Assessment\WorksheetStrategy;
use Illuminate\Http\Request;
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
                ->with(['target.worksheet']);

            return DataTables::eloquent($worksheets)->make(true);
        }

        $title = 'Risk Assessment';

        return view('risk.assessment.index', compact('title'));
    }
}
