<?php

namespace App\Http\Controllers\Master;

use App\Enums\State;
use App\Http\Controllers\Controller;
use App\Models\Master\KBUMNRiskCategory;
use App\Http\Requests\RiskCategoryRequest;
use Yajra\DataTables\Facades\DataTables;

class KBUMNRiskCategoryController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $risk_categories = KBUMNRiskCategory::query();
            return DataTables::of($risk_categories)
                ->addColumn('action', function ($risk_categories) {
                    $id = $risk_categories->getEncryptedId();
                    $actions = [];
                    if (role()->checkPermission('master.risk_categories.update')) {
                        $actions[] = ['id' => $id, 'route' => route('master.risk_categories.edit', $id), 'type' => 'link', 'text' => 'edit', 'permission' => true];
                    }
                    if (role()->checkPermission('master.risk_categories.destroy')) {
                        $actions[] = ['id' => $id, 'route' => route('master.risk_categories.destroy', $id), 'type' => 'delete', 'text' => 'hapus', 'permission' => true];
                    }

                    if (empty($actions)) {
                        return '';
                    }
                    return view('layouts.partials._table_action', compact('actions'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('master.risk_category.index');
    }

    public function create()
    {
        return view('master.risk_category.create');
    }

    public function store(RiskCategoryRequest $request)
    {
        KBUMNRiskCategory::create($request->only('type', 'name'))
            ?
            flash_message('flash_message', 'Kategori Risiko berhasil ditambahkan')
            :
            flash_message('flash_message', 'Kategori Risiko gagal ditambahkan', State::ERROR);

        return redirect()->route('master.risk_categories.index');
    }

    public function edit(string $risk_category)
    {
        $risk_category = KBUMNRiskCategory::findByEncryptedIdOrFail($risk_category);
        return view('master.risk_category.edit', compact('risk_category'));
    }

    public function update(string $risk_category, RiskCategoryRequest $request)
    {
        $risk_category = KBUMNRiskCategory::findByEncryptedIdOrFail($risk_category);

        $risk_category->update(
            $request->only('type', 'name')
        ) ?
            flash_message('flash_message', 'Kategori Risiko berhasil diperbarui')
            :
            flash_message('flash_message', 'Kategori Risiko gagal diperbarui', State::ERROR);

        return redirect()->route('master.risk_categories.index');
    }

    public function get_all()
    {
        return response()->json(['data' => KBUMNRiskCategory::orderBy('type')->get()]);
    }
}
