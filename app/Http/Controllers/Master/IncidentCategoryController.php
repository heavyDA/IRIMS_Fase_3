<?php

namespace App\Http\Controllers\Master;

use App\Enums\State;
use App\Http\Controllers\Controller;
use App\Models\Master\IncidentCategory;
use App\Http\Requests\IncidentCategoryRequest;
use Yajra\DataTables\Facades\DataTables;

class IncidentCategoryController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $incident_categories = IncidentCategory::query();
            return DataTables::of($incident_categories)
                ->addColumn('action', function ($incident_category) {
                    $id = $incident_category->getEncryptedId();
                    $actions = [
                        [
                            'type' => 'link',
                            'permission' => 'master.incident_categories.edit',
                            'text' => 'Edit',
                            'route' => route('master.incident_categories.edit', $id),
                        ],
                        [
                            'id' => $id,
                            'type' => 'delete',
                            'permission' => 'master.incident_categories.destroy',
                            'text' => 'Hapus',
                            'route' => route('master.incident_categories.destroy', $id),
                        ],
                    ];
                    return view('layouts.partials._table_action', compact('actions'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('master.incident_category.index');
    }

    public function create()
    {
        return view('master.incident_category.create');
    }

    public function store(IncidentCategoryRequest $request)
    {
        IncidentCategory::create($request->only('type', 'name'))
            ?
            flash_message('flash_message', 'Kategori Kejadian berhasil ditambahkan')
            :
            flash_message('flash_message', 'Kategori Kejadian gagal ditambahkan', State::ERROR);

        return redirect()->route('master.incident_categories.index');
    }

    public function edit(string $incident_category)
    {
        $incident_category = IncidentCategory::findByEncryptedIdOrFail($incident_category);
        return view('master.incident_category.edit', compact('incident_category'));
    }

    public function update(string $incident_category, IncidentCategoryRequest $request)
    {
        $incident_category = IncidentCategory::findByEncryptedIdOrFail($incident_category);

        $incident_category->update(
            $request->only('type', 'name')
        ) ?
            flash_message('flash_message', 'Kategori Kejadian berhasil diperbarui')
            :
            flash_message('flash_message', 'Kategori Kejadian gagal diperbarui', State::ERROR);

        return redirect()->route('master.incident_categories.index');
    }

    public function destroy(string $incident_category)
    {
        $incident_category = IncidentCategory::findByEncryptedIdOrFail($incident_category);

        $incident_category->delete() ?
            flash_message('flash_message', 'Kategori Kejadian berhasil dihapus')
            :
            flash_message('flash_message', 'Kategori Kejadian gagal dihapus', State::ERROR);

        return redirect()->route('master.incident_categories.index');
    }
}
