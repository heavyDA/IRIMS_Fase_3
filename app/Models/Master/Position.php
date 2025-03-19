<?php

namespace App\Models\Master;

use App\Models\RBAC\Role;
use App\Traits\HasEncryptedId;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Position extends Model
{
    use HasEncryptedId;

    protected $table = 'm_positions';

    protected $fillable = [
        'unit_code',
        'unit_code_doc',
        'unit_name',
        'unit_position_name',
        'sub_unit_code',
        'sub_unit_code_doc',
        'sub_unit_name',
        'branch_code',
        'regional_category',
        'position_name',
        'assigned_roles',
    ];

    /**
     * getHierarchy
     * This function is used to get hierarchy data of a unit
     *
     * @param string $unit_code The unit code
     * @return \Illuminate\Database\Query\Builder
     */
    public static function hierarchyQuery(?string $unitCode = '', ?bool $includeParent = true)
    {
        return DB::table('position_hierarchy')
            ->withRecursiveExpression(
                'position_hierarchy',
                DB::table(app(self::class)->getTable())
                    ->selectRaw("
                        branch_code,
                        unit_code,
                        unit_code_doc,
                        unit_name,
                        sub_unit_code,
                        sub_unit_code_doc,
                        sub_unit_name,
                        position_name,
                        (LENGTH(sub_unit_code) - length(replace(sub_unit_code, '.', ''))) as level
                ")
                    ->where('sub_unit_code', $unitCode)
                    ->unionAll(
                        DB::table(app(self::class)->getTable() . ' as p')
                            ->selectRaw("
                                p.branch_code,
                                p.unit_code,
                                p.unit_code_doc,
                                p.unit_name,
                                p.sub_unit_code,
                                p.sub_unit_code_doc,
                                p.sub_unit_name,
                                p.position_name,
                                (LENGTH(p.sub_unit_code) - length(replace(p.sub_unit_code, '.', ''))) as level
                            ")
                            ->join(
                                'position_hierarchy as ph',
                                fn($join) => $join->on('p.unit_code', 'ph.sub_unit_code')
                                    ->whereRaw('p.unit_code != ph.unit_code')
                            )
                    )
            );
    }

    public static function ancestorHierarchyQuery(?string $unitCode = '')
    {
        return DB::table('position_hierarchy')
            ->withRecursiveExpression(
                'position_hierarchy',
                DB::table(app(self::class)->getTable())
                    ->selectRaw("
                        branch_code,
                        unit_code,
                        unit_code_doc,
                        unit_name,
                        sub_unit_code,
                        sub_unit_code_doc,
                        sub_unit_name,
                        position_name,
                        (LENGTH(sub_unit_code) - length(replace(sub_unit_code, '.', ''))) as level
                ")
                    ->where('sub_unit_code', $unitCode)
                    ->unionAll(
                        DB::table(app(self::class)->getTable() . ' as p')
                            ->selectRaw("
                                p.branch_code,
                                p.unit_code,
                                p.unit_code_doc,
                                p.unit_name,
                                p.sub_unit_code,
                                p.sub_unit_code_doc,
                                p.sub_unit_name,
                                p.position_name,
                                (LENGTH(p.sub_unit_code) - length(replace(p.sub_unit_code, '.', ''))) as level
                            ")
                            ->join(
                                'position_hierarchy as ph',
                                'p.sub_unit_code',
                                'ph.unit_code'
                            )
                    )
            );
    }

    public static function hierarchyWithTraverseQuery(?string $table = 'children', ?string $unitCode = '')
    {
        return DB::table($table)->withRecursiveExpression(
            'children',
            DB::table('m_positions as p')
                ->select('*')
                ->where('p.unit_code', $unitCode)
        )->withRecursiveExpression(
            'position_hierarchy',
            DB::table('children')
                ->selectRaw("
                    branch_code,
                    sub_unit_code_doc as unit_code_doc,
                    sub_unit_code as unit_code,
                    sub_unit_name as unit_name,
                    sub_unit_code,
                    sub_unit_code_doc,
                    sub_unit_name,
                    position_name,
                    assigned_roles,
                    (LENGTH(sub_unit_code) - length(replace(sub_unit_code, '.', ''))) as level
                ")
                ->unionAll(
                    DB::table('position_hierarchy as ph')
                        ->selectRaw("
                            ph.branch_code,
                            ph.unit_code_doc,
                            ph.unit_code,
                            ph.unit_name,
                            p.sub_unit_code,
                            p.sub_unit_code_doc,
                            p.sub_unit_name,
                            p.position_name,
                            p.assigned_roles,
                            (LENGTH(p.sub_unit_code) - length(replace(p.sub_unit_code, '.', ''))) as level
                        ")
                        ->join('m_positions as p', 'p.unit_code', 'ph.sub_unit_code')
                )
        );
    }

    public function scopeUserAssignedRoles($query, string $personnel_area_code, string $position_name)
    {
        return $query
            ->where('personnel_area_code', $personnel_area_code)
            ->where('position_name', $position_name);
    }

    public function scopeUnitOnly($query)
    {
        return $query->distinct()->select('personnel_area_code', 'unit_name');
    }

    public function scopeBranch($query)
    {
        return $query->whereRaw("
        (branch_code like 'PST' OR branch_code like 'REG%') 
        AND (LENGTH(unit_code) - LENGTH(REPLACE(unit_code, '.', ''))) = 1
        ");
    }

    public function scopeGetSubUnitOnly($query)
    {
        return $query->distinct()->selectRaw('
            unit_code as sub_unit_code, 
            unit_name as sub_unit_name, 
            personnel_area_code
        ')->oldest('sub_unit_code');
    }

    public function scopeFilterByRole($query)
    {
        $unit = Role::getDefaultSubUnit();
        return $query->whereLike('unit_code', $unit)
            ->orWhereLike('unit_code', str_replace('.%', '', $unit));
    }
}
