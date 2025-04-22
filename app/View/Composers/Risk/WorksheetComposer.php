<?php

namespace App\View\Composers\Risk;

use App\Enums\DocumentStatus;
use App\Models\Master\Position;
use App\Models\Risk\Worksheet;
use App\Services\RoleService;
use Illuminate\View\View;

class WorksheetComposer
{
    public function __construct(protected RoleService $roleService) {}

    public function compose(View $view)
    {
        $worksheets = Worksheet::withExpression(
            'position_hierarchy',
            Position::hierarchyQuery(
                $this->roleService->getCurrentUnit()?->sub_unit_code
            )
        )
            ->join('position_hierarchy as ph', 'ph.sub_unit_code', 'ra_worksheets.sub_unit_code')
            ->where('ra_worksheets.status', DocumentStatus::APPROVED)
            ->whereYear('ra_worksheets.created_at', now()->year)
            ->get();

        $view->with('worksheets', $worksheets);
    }
}
