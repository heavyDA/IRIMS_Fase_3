<?php

namespace App\Http\Controllers\Setting;

use App\Enums\State;
use App\Events\PositionUpdated;
use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\PositionRequest;
use App\Models\Master\Position;
use Mews\Purifier\Facades\Purifier;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class PositionController extends Controller
{
    public function index()
    {
        abort_if(!role()->checkPermission('setting.positions.index'), Response::HTTP_NOT_FOUND);

        if (request()->ajax()) {
            $positions = Position::query();
            return DataTables::of($positions)
                ->filter(function ($query) {
                    $value = request('search.value', '');

                    if ($value) {
                        $value = '%' . strip_html(Purifier::clean($value)) . '%';
                        $query->whereLike('unit_code', $value)
                            ->orWhereLike('unit_code_doc', $value)
                            ->orWhereLike('unit_name', $value)
                            ->orWhereLike('sub_unit_code', $value)
                            ->orWhereLike('sub_unit_code_doc', $value)
                            ->orWhereLike('sub_unit_name', $value)
                            ->orWhereLike('position_name', $value);
                    }
                })
                ->addColumn('action', function ($position) {
                    $id = $position->getEncryptedId();
                    $actions = [
                        [
                            'type' => 'link',
                            'permission' => 'setting.positions.edit',
                            'text' => 'Edit',
                            'route' => route('setting.positions.edit', $id),
                        ],
                        [
                            'id' => $id,
                            'type' => 'delete',
                            'permission' => 'setting.positions.destroy',
                            'text' => 'Hapus',
                            'route' => route('setting.positions.destroy', $id),
                        ],
                    ];
                    return view('layouts.partials._table_action', compact('actions'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('setting.position.index');
    }

    public function create()
    {
        abort_if(!role()->checkPermission('setting.positions.create'), Response::HTTP_NOT_FOUND);

        return view('setting.position.create');
    }

    public function store(PositionRequest $request)
    {
        abort_if(!role()->checkPermission('setting.positions.create'), Response::HTTP_NOT_FOUND);

        $unit = Position::whereSubUnitCode($request->sub_unit_code)->firstOrFail();
        $position = Position::create(
            ['position_name' => $request->position_name, 'assigned_roles' => implode(',', $request->roles)] +
                $unit->toArray()
        );

        if ($position->wasRecentlyCreated) {
            PositionUpdated::dispatch($position);
            flash_message('flash_message', 'Posisi berhasil ditambahkan');
        } else {
            flash_message('flash_message', 'Posisi gagal ditambahkan', State::ERROR);
        }


        return redirect()->route('setting.positions.index');
    }

    public function edit(string $position)
    {
        abort_if(!role()->checkPermission('setting.positions.update'), Response::HTTP_NOT_FOUND);

        $position = Position::findByEncryptedIdOrFail($position);
        $position->role = explode(',', $position->assigned_roles);
        return view('setting.position.edit', compact('position'));
    }

    public function update(string $position, PositionRequest $request)
    {
        abort_if(!role()->checkPermission('setting.positions.update'), Response::HTTP_NOT_FOUND);

        $unit = Position::whereSubUnitCode($request->sub_unit_code)->firstOrFail();
        $position = Position::findByEncryptedIdOrFail($position);

        if ($position->update(
            ['position_name' => $request->position_name, 'assigned_roles' => implode(',', $request->roles)] +
                $unit->toArray()
        )) {
            PositionUpdated::dispatch($position);
            flash_message('flash_message', 'Posisi berhasil diperbarui');
        } else {
            flash_message('flash_message', 'Posisi gagal diperbarui', State::ERROR);
        }

        return redirect()->route('setting.positions.index');
    }

    public function destroy(string $position)
    {
        abort_if(!role()->checkPermission('setting.positions.destroy'), Response::HTTP_NOT_FOUND);

        $position = Position::findByEncryptedIdOrFail($position);

        $position->delete() ?
            flash_message('flash_message', 'Posisi berhasil dihapus')
            :
            flash_message('flash_message', 'Posisi gagal dihapus', State::ERROR);

        return redirect()->route('setting.positions.index');
    }

    public function get_all()
    {
        $units = cache()->remember(
            'units',
            now()->addMinutes(5),
            function () {
                $units = Position::latest('unit_code')
                    ->get();

                return $units->isEmpty() ? null : $units;
            }
        );

        return response()->json([
            'data' => $units,
            'message' => 'loaded',
        ]);
    }
}
