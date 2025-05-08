<?php

namespace Database\Seeders;

use App\Enums\UnitSourceType;
use App\Models\Master\Official;
use App\Models\Master\Position;
use App\Models\RBAC\Menu;
use App\Models\RBAC\Permission;
use App\Models\RBAC\Role;
use App\Models\User;
use App\Models\UserUnit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DefaultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menus = [
            [
                'name' => 'Dashboard',
                'route' => 'dashboard',
                'icon_name' => 'layout-dashboard',
                'children' => [
                    [
                        'name' => 'Dashboard',
                        'route' => 'dashboard.index',
                        'position' => 0,
                    ],
                ],
            ],

            [
                'name' => 'Risk Process',
                'route' => 'risk',
                'icon_name' => 'presentation',
                'children' => [
                    [
                        'name' => 'Risk Assessment',
                        'route' => 'risk.assessment.index',
                        'position' => 0,
                    ],
                    [
                        'name' => 'Risk Monitoring',
                        'route' => 'risk.monitoring.index',
                        'position' => 0,
                    ],
                    [
                        'name' => 'Top Risk',
                        'route' => 'risk.top_risk.index',
                        'position' => 0,
                    ],
                ],
            ],

            [
                'name' => 'Risk Report',
                'route' => 'risk.report',
                'icon_name' => 'clipboard-text',
                'children' => [
                    [
                        'name' => 'Risk Profile',
                        'route' => 'risk.report.risk_profile.index',
                        'position' => 0,
                    ],
                    [
                        'name' => 'Risk Monitoring',
                        'route' => 'risk.report.risk_monitoring.index',
                        'position' => 0,
                    ],
                    [
                        'name' => 'Ikhtisar Perubahan Profil Risiko',
                        'route' => 'risk.report.alterations.index',
                        'position' => 0,
                    ],
                    [
                        'name' => 'Loss Event Database',
                        'route' => 'risk.report.loss_events.index',
                        'position' => 0,
                    ],
                ],
            ],

            [
                'name' => 'Master Data',
                'route' => 'master',
                'icon_name' => 'cube',
                'children' => [
                    [
                        'name' => 'Skala',
                        'route' => 'master.bumn_scales.index',
                        'position' => 0,
                    ],
                    [
                        'name' => 'KRI Unit',
                        'route' => 'master.kri_units.index',
                        'position' => 0,
                    ],
                    [
                        'name' => 'Jenis Existing Control',
                        'route' => 'master.existing_control_types.index',
                        'position' => 0,
                    ],
                    [
                        'name' => 'Kategori Kejadian',
                        'route' => 'master.incident_categories.index',
                        'position' => 0,
                    ],
                    [
                        'name' => 'Kategori Risiko',
                        'route' => 'master.risk_categories.index',
                        'position' => 0,
                    ],
                    [
                        'name' => 'Opsi Perlakuan Risiko',
                        'route' => 'master.risk_treatment_options.index',
                        'position' => 0,
                    ],
                    [
                        'name' => 'Jenis Rencana Perlakuan Risiko',
                        'route' => 'master.risk_treatment_types.index',
                        'position' => 0,
                    ],
                ],
            ],

            [
                'name' => 'Pengaturan',
                'route' => 'setting',
                'icon_name' => 'settings',
                'children' => [
                    [
                        'name' => 'Matrik Strategi Risiko',
                        'route' => 'setting.risk_metrics.index',
                        'position' => 0,
                    ],
                    [
                        'name' => 'Posisi',
                        'route' => 'setting.positions.index',
                        'position' => 0,
                    ],
                ],
            ],

            [
                'name' => 'Akses',
                'route' => 'rbac',
                'icon_name' => 'shield-lock',
                'children' => [
                    [
                        'name' => 'Pengguna',
                        'route' => 'rbac.users.index',
                        'position' => 0,
                    ],
                ],
            ],
        ];

        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::statement('delete from menu_role');
        Menu::whereRaw('1 = 1')->delete();
        Permission::whereRaw('1 = 1')->delete();

        DB::statement('TRUNCATE menu_role');
        DB::statement('TRUNCATE menus');
        DB::statement('TRUNCATE permissions');
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // if (Menu::count() == 0) {
        foreach ($menus as $key => $menu) {
            $children = $menu['children'] ?? [];
            unset($menu['children']);

            $menu = Menu::firstOrCreate(['route' => $menu['route']], $menu + ['position' => $key + 1]);
            if ($menu->wasRecentlyCreated && $children) {
                foreach ($children as $child) {
                    $menu->children()->updateOrCreate(
                        ['route' => $child['route']],
                        $child
                    );
                }
            }
        }
        // }

        /**
         * Generate default permissions
         */
        $defaultPermissions = ['index', 'create', 'update', 'destroy'];
        $permissions = [
            [
                'route' => 'dashboard',
                'permissions' => $defaultPermissions,
            ],
            [
                'route' => 'risk.assessment',
                'permissions' => $defaultPermissions,
            ],
            [
                'route' => 'risk.worksheet',
                'permissions' => $defaultPermissions + ['update_status'],
            ],
            [
                'route' => 'risk.monitoring',
                'permissions' => $defaultPermissions + ['update_status_monitoring'],
            ],
            [
                'route' => 'risk.top_risk',
                'permissions' => $defaultPermissions,
            ],
            [
                'route' => 'master.bumn_scales',
                'permissions' => $defaultPermissions,
            ],
            [
                'route' => 'master.kri_units',
                'permissions' => $defaultPermissions,
            ],
            [
                'route' => 'master.existing_control_types',
                'permissions' => $defaultPermissions,
            ],
            [
                'route' => 'master.incident_categories',
                'permissions' => $defaultPermissions,
            ],
            [
                'route' => 'master.risk_categories',
                'permissions' => $defaultPermissions,
            ],
            [
                'route' => 'master.risk_treatment_options',
                'permissions' => $defaultPermissions,
            ],
            [
                'route' => 'master.risk_treatment_types',
                'permissions' => $defaultPermissions,
            ],
            [
                'route' => 'rbac.users',
                'permissions' => $defaultPermissions,
            ],

            [
                'route' => 'risk.report.alterations',
                'permissions' => $defaultPermissions,
            ],
            [
                'route' => 'risk.report.loss_events',
                'permissions' => $defaultPermissions,
            ],
            [
                'route' => 'risk.report.risk_profile',
                'permissions' => $defaultPermissions,
            ],
            [
                'route' => 'risk.report.risk_monitoring',
                'permissions' => $defaultPermissions,
            ],
            [
                'route' => 'setting.risk_metrics',
                'permissions' => $defaultPermissions,
            ],
            [
                'route' => 'setting.positions',
                'permissions' => $defaultPermissions,
            ],
        ];

        $generatedPermissions = [];
        foreach ($permissions as $item) {
            foreach ($item['permissions'] as $permission) {
                $generatedPermissions[] = [
                    'name' => "{$item['route']}.{$permission}",
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        Permission::insert($generatedPermissions);
        $menus = Menu::all();
        $permissions = Permission::all();
        $roles = [['name' => 'root'], ['name' => 'administrator'], ['name' => 'risk admin'], ['name' => 'risk owner'], ['name' => 'risk otorisator'], ['name' => 'risk analis'], ['name' => 'risk reviewer'], ['name' => 'risk analis pusat']];
        foreach ($roles as $role) {
            $role = Role::firstOrCreate($role);
            if (in_array($role->name, ['root', 'administrator'])) {

                $role->syncPermissions($permissions->pluck('name'));
                $role->menus()->sync($menus->pluck('id'));
            } else if ($role->name == 'risk reviewer') {
                $role->syncPermissions(
                    $permissions
                        ->filter(
                            fn($p) => (!str_contains($p->name, 'access') ||
                                !str_contains($p->name, 'master') ||
                                !str_contains($p->name, 'setting')) &&
                                (!str_contains($p->name, 'create') ||
                                    !str_contains($p->name, 'update') ||
                                    !str_contains($p->name, 'destroy'))
                        )
                        ->pluck('name')
                );
                $role->menus()->sync(
                    $menus->filter(
                        function ($menu) {
                            return str_contains($menu->route, 'risk') ||
                                str_contains($menu->route, 'dashboard');
                        }
                    )->pluck('id')
                );
            } else if ($role->name == 'risk analis pusat') {
                $permissions = Permission::whereNotLike('name', '%access%')
                    ->get();
                $role->syncPermissions($permissions->pluck('name'));
                $role->menus()->sync(
                    $menus->filter(
                        function ($menu) {
                            return str_contains($menu->route, 'risk') ||
                                str_contains($menu->route, 'master') ||
                                str_contains($menu->route, 'setting') ||
                                str_contains($menu->route, 'dashboard');
                        }
                    )->pluck('id')
                );
            } else if ($role->name == 'risk analis') {
                $permissions = Permission::whereNotLike('name', '%access%')
                    ->orWhereNotLike('name', '%master%')
                    ->orWhereNotLike('name', '%setting%')
                    ->get();
                $role->syncPermissions($permissions->pluck('name'));
                $role->menus()->sync(
                    $menus->filter(
                        function ($menu) {
                            return str_contains($menu->route, 'risk') ||
                                str_contains($menu->route, 'dashboard');
                        }
                    )->pluck('id')
                );
            } else if ($role->name == 'risk otorisator') {
                $permissions = Permission::whereNotLike('name', '%access%')
                    ->orWhereNotLike('name', '%master%')
                    ->orWhereNotLike('name', '%setting%')
                    ->orWhereNotLike('name', '%create%')
                    ->orWhereNotLike('name', '%destroy%')
                    ->orWhere('name', '!=', 'risk.worksheet.update')
                    ->orWhere('name', '!=', 'risk.monitoring.update')
                    ->orWhere('name', 'risk.worksheet.update_status')
                    ->orWhere('name', 'risk.monitoring.update_status_monitoring')
                    ->get();
                $role->syncPermissions($permissions->pluck('name'));
                $role->menus()->sync(
                    $menus->filter(
                        function ($menu) {
                            return
                                str_contains($menu->route, 'risk') ||
                                str_contains($menu->route, 'dashboard');
                        }
                    )->pluck('id')
                );
            } else if ($role->name == 'risk owner') {
                $permissions = Permission::whereNotLike('name', '%access%')
                    ->orWhereNotLike('name', '%master%')
                    ->orWhereNotLike('name', '%setting%')
                    ->orWhereNotLike('name', '%top_risk%')
                    ->get();

                $role->syncPermissions($permissions->pluck('name'));
                $role->menus()->sync(
                    $menus->filter(
                        function ($menu) {
                            return (str_contains($menu->route, 'risk') && !str_contains($menu->route, 'top_risk')) ||
                                str_contains($menu->route, 'dashboard');
                        }
                    )->pluck('id')
                );
            } else if ($role->name == 'risk admin') {
                $permissions = Permission::whereNotLike('name', '%access%')
                    ->orWhereNotLike('name', '%master%')
                    ->orWhereNotLike('name', '%setting%')
                    ->orWhereNotLike('name', '%top_risk%')
                    ->get();

                $role->syncPermissions($permissions->pluck('name'));
                $role->menus()->sync(
                    $menus->filter(
                        function ($menu) {
                            return (str_contains($menu->route, 'risk') && !str_contains($menu->route, 'top_risk')) ||
                                str_contains($menu->route, 'dashboard');
                        }
                    )->pluck('id')
                );
            }
        }

        $users = [
            [
                [
                    'username' => 'secret_root',
                    'password' => bcrypt('53cret#321'),
                    'email' => 'root@injourneyairports.id',
                    'employee_name' => 'Administrator',
                    'employee_id' => 'x999991111',
                    'organization_code' => 'ap',
                    'organization_name' => '',
                    'personnel_area_name' => 'Kantor Pusat',
                    'personnel_area_code' => 'PST',
                    'position_name' => 'Administrator',
                    'unit_name' => '',
                    'sub_unit_name' => '',
                    'unit_code' => 'root',
                    'sub_unit_code' => 'ap',
                    'employee_grade_code' => '-',
                    'employee_grade' => '-',
                    'image_url' => '',
                    'is_active' => true,
                ],
                ['root', 'risk analis'],
                [
                    'organization_code' => 'ap',
                    'organization_name' => '',
                    'personnel_area_name' => 'Kantor Pusat',
                    'personnel_area_code' => 'PST',
                    'position_name' => 'Administrator',
                    'unit_name' => '',
                    'sub_unit_name' => 'Administrator',
                    'unit_code' => 'root',
                    'sub_unit_code' => 'ap',
                    'source_type' => UnitSourceType::SYSTEM->value,
                    'expired_at' => now()->addYears(50),
                ]
            ],
            [
                [
                    'username' => 'rahasia',
                    'password' => bcrypt('rahasia#321'),
                    'email' => 'administrator@injourneyairports.id',
                    'employee_name' => 'Administrator',
                    'employee_id' => 'x9999999',
                    'organization_code' => 'ap',
                    'organization_name' => '',
                    'personnel_area_name' => 'Kantor Pusat',
                    'personnel_area_code' => 'PST',
                    'position_name' => 'Administrator',
                    'unit_name' => '',
                    'sub_unit_name' => '',
                    'unit_code' => 'root',
                    'sub_unit_code' => 'ap',
                    'employee_grade_code' => '-',
                    'employee_grade' => '-',
                    'image_url' => '',
                    'is_active' => true,
                ],
                ['administrator', 'risk analis'],
                [
                    'organization_code' => 'ap',
                    'organization_name' => '',
                    'personnel_area_name' => 'Kantor Pusat',
                    'personnel_area_code' => 'PST',
                    'position_name' => 'Administrator',
                    'unit_name' => '',
                    'sub_unit_name' => '',
                    'unit_code' => 'root',
                    'sub_unit_code' => 'ap',
                    'source_type' => UnitSourceType::SYSTEM->value,
                    'expired_at' => now()->addYears(50),
                ]
            ],
            [
                [
                    'username' => 'reviewer',
                    'password' => bcrypt('reviewer#321'),
                    'email' => 'reviewer@injourneyairports.id',
                    'employee_name' => 'Reviewer',
                    'employee_id' => 'x9999998',
                    'organization_code' => 'ap',
                    'organization_name' => 'Reviewer',
                    'personnel_area_name' => 'Kantor Pusat',
                    'personnel_area_code' => 'PST',
                    'position_name' => 'Reviewer',
                    'unit_name' => '',
                    'sub_unit_name' => 'Reviewer',
                    'unit_code' => 'root',
                    'sub_unit_code' => 'ap',
                    'employee_grade_code' => '-',
                    'employee_grade' => '-',
                    'image_url' => '',
                    'is_active' => true,
                ],
                ['risk reviewer'],
                [
                    'organization_code' => 'ap',
                    'organization_name' => 'Reviewer',
                    'personnel_area_name' => 'Kantor Pusat',
                    'personnel_area_code' => 'PST',
                    'position_name' => 'Reviewer',
                    'unit_name' => '',
                    'sub_unit_name' => 'Reviewer',
                    'unit_code' => 'root',
                    'sub_unit_code' => 'ap',
                    'employee_grade_code' => '-',
                    'employee_grade' => '-',
                    'source_type' => UnitSourceType::SYSTEM->value,
                    'expired_at' => now()->addYears(50),
                ]
            ],
            [
                [
                    'username' => 'user_analis_all',
                    'password' => bcrypt('user_analis_all#321'),
                    'email' => 'user_analis_all@injourneyairports.id',
                    'employee_name' => 'Administrator',
                    'employee_id' => 'x9999997',
                    'organization_code' => 'ap',
                    'organization_name' => 'Risk Analis',
                    'personnel_area_name' => 'Kantor Pusat',
                    'personnel_area_code' => 'PST',
                    'position_name' => 'Risk Analis',
                    'unit_name' => '',
                    'sub_unit_name' => 'Risk Analis',
                    'unit_code' => 'root',
                    'sub_unit_code' => 'ap',
                    'employee_grade_code' => '-',
                    'employee_grade' => '-',
                    'image_url' => '',
                    'is_active' => true,
                ],
                ['risk analis'],
                [
                    'organization_code' => 'ap',
                    'organization_name' => 'Risk Analis',
                    'personnel_area_name' => 'Kantor Pusat',
                    'personnel_area_code' => 'PST',
                    'position_name' => 'Risk Analis',
                    'unit_name' => '',
                    'sub_unit_name' => 'Risk Analis',
                    'unit_code' => 'root',
                    'sub_unit_code' => 'ap',
                    'employee_grade_code' => '-',
                    'employee_grade' => '-',
                    'source_type' => UnitSourceType::SYSTEM->value,
                    'expired_at' => now()->addYears(50),
                ]
            ],
            [
                [
                    'username' => 'user_analis_pusat',
                    'password' => bcrypt('user_analis_pusat#321'),
                    'email' => 'user_analis_pusat@injourneyairports.id',
                    'employee_name' => 'Administrator',
                    'employee_id' => 'x9999996',
                    'organization_code' => 'ap.50',
                    'organization_name' => 'Enterprise Risk Management',
                    'personnel_area_name' => 'Kantor PUSAT',
                    'personnel_area_code' => 'PST',
                    'position_name' => 'Risk Analis',
                    'unit_name' => '',
                    'sub_unit_name' => 'Enterprise Risk Management',
                    'unit_code' => 'ap',
                    'sub_unit_code' => 'ap.50',
                    'employee_grade_code' => '-',
                    'employee_grade' => '-',
                    'image_url' => '',
                    'is_active' => true,
                ],
                ['risk analis'],
                [
                    'organization_code' => 'ap',
                    'organization_name' => 'Enterprise Risk Management',
                    'personnel_area_name' => 'Kantor Pusat',
                    'personnel_area_code' => 'PST',
                    'position_name' => 'Risk Analis',
                    'unit_name' => 'Kantor Pusat',
                    'sub_unit_name' => 'Enterprise Risk Management',
                    'unit_code' => 'root',
                    'sub_unit_code' => 'ap.50',
                    'employee_grade_code' => '-',
                    'employee_grade' => '-',
                    'source_type' => UnitSourceType::SYSTEM->value,
                    'expired_at' => now()->addYears(50),
                ]
            ],
            [
                [
                    'username' => 'user_analis_reg_1',
                    'password' => bcrypt('user_analis_reg_1#321'),
                    'email' => 'user_analis_reg_1@injourneyairports.id',
                    'employee_name' => 'ANALIS REG 1',
                    'employee_id' => 'x9999991',
                    'organization_code' => 'ap.51',
                    'organization_name' => 'Kantor Regional I (09 September 2024) - CGK',
                    'personnel_area_name' => 'Kantor Regional I',
                    'personnel_area_code' => 'REG I',
                    'position_name' => 'Risk Analis - Kantor Regional I',
                    'unit_name' => 'Kantor Pusat',
                    'sub_unit_name' => 'Kantor Regional I (09 September 2024) - CGK',
                    'unit_code' => 'ap',
                    'sub_unit_code' => 'ap.51',
                    'employee_grade_code' => '-',
                    'employee_grade' => '-',
                    'image_url' => '',
                    'is_active' => true,
                ],
                ['risk analis'],
                [
                    'organization_code' => 'ap.51',
                    'organization_name' => 'Kantor Regional I (09 September 2024) - CGK',
                    'personnel_area_name' => 'Kantor Regional I',
                    'personnel_area_code' => 'REG I',
                    'position_name' => 'Risk Analis - Kantor Regional I',
                    'unit_name' => 'Kantor Pusat',
                    'sub_unit_name' => 'Kantor Regional I (09 September 2024) - CGK',
                    'unit_code' => 'ap',
                    'sub_unit_code' => 'ap.51',
                    'employee_grade_code' => '-',
                    'employee_grade' => '-',
                    'source_type' => UnitSourceType::SYSTEM->value,
                    'expired_at' => now()->addYears(50),
                ]
            ],
            [
                [
                    'username' => 'user_analis_reg_3',
                    'password' => bcrypt('user_analis_reg_3#321'),
                    'email' => 'user_analis_reg_3@injourneyairports.id',
                    'employee_name' => 'ANALIS REG 3',
                    'employee_id' => 'x9999993',
                    'organization_code' => 'ap.52',
                    'organization_name' => 'Kantor Regional III (09 September 2024) - KNO',
                    'personnel_area_name' => 'Kantor Regional III',
                    'personnel_area_code' => 'KNO',
                    'position_name' => 'Risk Analis - Kantor Regional III',
                    'unit_name' => 'Kantor Pusat',
                    'sub_unit_name' => 'Kantor Regional III (09 September 2024) - KNO',
                    'unit_code' => 'ap',
                    'sub_unit_code' => 'ap.52',
                    'employee_grade_code' => '-',
                    'employee_grade' => '-',
                    'image_url' => '',
                    'is_active' => true,
                ],
                ['risk analis'],
                [
                    'organization_code' => 'ap.52',
                    'organization_name' => 'Kantor Regional III (09 September 2024) - KNO',
                    'personnel_area_name' => 'Kantor Regional III',
                    'personnel_area_code' => 'KNO',
                    'position_name' => 'Risk Analis - Kantor Regional III',
                    'unit_name' => 'Kantor Pusat',
                    'sub_unit_name' => 'Kantor Regional III (09 September 2024) - KNO',
                    'unit_code' => 'ap',
                    'sub_unit_code' => 'ap.52',
                    'employee_grade_code' => '-',
                    'employee_grade' => '-',
                    'source_type' => UnitSourceType::SYSTEM->value,
                    'expired_at' => now()->addYears(50),
                ]
            ],
            [
                [
                    'username' => 'user_analis_reg_2',
                    'password' => bcrypt('user_analis_reg_2#321'),
                    'email' => 'user_analis_reg_2@injourneyairports.id',
                    'employee_name' => 'ANALIS REG 2',
                    'employee_id' => 'x9999992',
                    'organization_code' => 'ap.53',
                    'organization_name' => 'Kantor Regional II (09 September 2024) - DPS',
                    'personnel_area_name' => 'Kantor Regional II',
                    'personnel_area_code' => 'DPS',
                    'position_name' => 'Risk Analis - Kantor Regional II',
                    'unit_name' => 'Kantor Pusat',
                    'sub_unit_name' => 'Kantor Regional II (09 September 2024) - DPS',
                    'unit_code' => 'ap',
                    'sub_unit_code' => 'ap.53',
                    'employee_grade_code' => '-',
                    'employee_grade' => '-',
                    'image_url' => '',
                    'is_active' => true,
                ],
                ['risk analis'],
                [
                    'organization_code' => 'ap.53',
                    'organization_name' => 'Kantor Regional II (09 September 2024) - DPS',
                    'personnel_area_name' => 'Kantor Regional II',
                    'personnel_area_code' => 'DPS',
                    'position_name' => 'Risk Analis - Kantor Regional II',
                    'unit_name' => 'Kantor Pusat',
                    'sub_unit_name' => 'Kantor Regional II (09 September 2024) - DPS',
                    'unit_code' => 'ap',
                    'sub_unit_code' => 'ap.53',
                    'employee_grade_code' => '-',
                    'employee_grade' => '-',
                    'source_type' => UnitSourceType::SYSTEM->value,
                    'expired_at' => now()->addYears(50),
                ]
            ],
            [
                [
                    'username' => 'user_analis_reg_4',
                    'password' => bcrypt('user_analis_reg_4#321'),
                    'email' => 'user_analis_reg_4@injourneyairports.id',
                    'employee_name' => 'ANALIS REG 4',
                    'employee_id' => 'x9999994',
                    'organization_code' => 'ap.54',
                    'organization_name' => 'Kantor Regional IV (09 September 2024) - YIA',
                    'personnel_area_name' => 'Kantor Regional IV',
                    'personnel_area_code' => 'YIA',
                    'position_name' => 'Risk Analis - Kantor Regional IV',
                    'unit_name' => 'Kantor Pusat',
                    'sub_unit_name' => 'Kantor Regional IV (09 September 2024) - YIA',
                    'unit_code' => 'ap',
                    'sub_unit_code' => 'ap.54',
                    'employee_grade_code' => '-',
                    'employee_grade' => '-',
                    'image_url' => '',
                    'is_active' => true,
                ],
                ['risk analis'],
                [
                    'organization_code' => 'ap.54',
                    'organization_name' => 'Kantor Regional IV (09 September 2024) - YIA',
                    'personnel_area_name' => 'Kantor Regional IV',
                    'personnel_area_code' => 'YIA',
                    'position_name' => 'Risk Analis - Kantor Regional IV',
                    'unit_name' => 'Kantor Pusat',
                    'sub_unit_name' => 'Kantor Regional IV (09 September 2024) - YIA',
                    'unit_code' => 'ap',
                    'sub_unit_code' => 'ap.54',
                    'employee_grade_code' => '-',
                    'employee_grade' => '-',
                    'source_type' => UnitSourceType::SYSTEM->value,
                    'expired_at' => now()->addYears(50),
                ]
            ],
            [
                [
                    'username' => 'user_analis_reg_5',
                    'password' => bcrypt('user_analis_reg_5#321'),
                    'email' => 'user_analis_reg_5@injourneyairports.id',
                    'employee_name' => 'ANALIS REG 5',
                    'employee_id' => 'x9999995',
                    'organization_code' => 'ap.55',
                    'organization_name' => 'Kantor Regional V (09 September 2024) - UPG',
                    'personnel_area_name' => 'Kantor Regional V',
                    'personnel_area_code' => 'UPG',
                    'position_name' => 'Risk Analis - Kantor Regional V',
                    'unit_name' => 'Kantor Pusat',
                    'sub_unit_name' => 'Kantor Regional V (09 September 2024) - UPG',
                    'unit_code' => 'ap',
                    'sub_unit_code' => 'ap.55',
                    'employee_grade_code' => '-',
                    'employee_grade' => '-',
                    'image_url' => '',
                    'is_active' => true,
                ],
                ['risk analis'],
                [
                    'organization_code' => 'ap.55',
                    'organization_name' => 'Kantor Regional V (09 September 2024) - UPG',
                    'personnel_area_name' => 'Kantor Regional V',
                    'personnel_area_code' => 'UPG',
                    'position_name' => 'Risk Analis - Kantor Regional V',
                    'unit_name' => 'Kantor Pusat',
                    'sub_unit_name' => 'Kantor Regional V (09 September 2024) - UPG',
                    'unit_code' => 'ap',
                    'sub_unit_code' => 'ap.55',
                    'employee_grade_code' => '-',
                    'employee_grade' => '-',
                    'source_type' => UnitSourceType::SYSTEM->value,
                    'expired_at' => now()->addYears(50),
                ]
            ],
            [
                [
                    'username' => 'user_analis_reg_6',
                    'password' => bcrypt('user_analis_reg_6#321'),
                    'email' => 'user_analis_reg_6@injourneyairports.id',
                    'employee_name' => 'ANALIS REG 6',
                    'employee_id' => 'x9999996',
                    'organization_code' => 'ap.56',
                    'organization_name' => 'Kantor Regional VI (09 September 2024) - BPN',
                    'personnel_area_name' => 'Kantor Regional VI',
                    'personnel_area_code' => 'BPN',
                    'position_name' => 'Risk Analis - Kantor Regional VI',
                    'unit_name' => 'Kantor Pusat',
                    'sub_unit_name' => 'Kantor Regional VI (09 September 2024) - BPN',
                    'unit_code' => 'ap',
                    'sub_unit_code' => 'ap.56',
                    'employee_grade_code' => '-',
                    'employee_grade' => '-',
                    'image_url' => '',
                    'is_active' => true,
                ],
                ['risk analis'],
                [
                    'organization_code' => 'ap.56',
                    'organization_name' => 'Kantor Regional VI (09 September 2024) - BPN',
                    'personnel_area_name' => 'Kantor Regional VI',
                    'personnel_area_code' => 'BPN',
                    'position_name' => 'Risk Analis - Kantor Regional VI',
                    'unit_name' => 'Kantor Pusat',
                    'sub_unit_name' => 'Kantor Regional VI (09 September 2024) - BPN',
                    'unit_code' => 'ap',
                    'sub_unit_code' => 'ap.56',
                    'employee_grade_code' => '-',
                    'employee_grade' => '-',
                    'source_type' => UnitSourceType::SYSTEM->value,
                    'expired_at' => now()->addYears(50),
                ]
            ],
        ];

        foreach ($users as $user) {
            $newUser = User::firstOrCreate(['username' => $user[0]['username']], $user[0]);
            $newUser->update($user[0]);

            $unit = $newUser->units()->firstOrCreate([
                'sub_unit_code' => $user[2]['sub_unit_code'],
                'position_name' => $user[2]['position_name'],
            ], $user[2]);
            $unit->syncRoles($user[1]);
        }

        $officials_to_users = [
            ['personnel_area_code' => 'PST', 'position_name' => 'Direktur Utama'],
            ['personnel_area_code' => 'PST', 'position_name' => 'Corporate Secretary Group Head'],
            ['personnel_area_code' => 'PST', 'position_name' => 'Corporate Communication Division Head'],
            ['personnel_area_code' => 'PST', 'position_name' => 'Corporate Branding Division Head'],
            ['personnel_area_code' => 'PST', 'position_name' => 'Corporate BOD Office Support Division Head'],
            ['personnel_area_code' => 'PST', 'position_name' => 'Head of Airport Construction Area B'],
            ['personnel_area_code' => 'PST', 'position_name' => 'Project Construction Division Head'],
            ['personnel_area_code' => 'PST', 'position_name' => 'Head of Airport Construction Area A'],
            ['personnel_area_code' => 'PST', 'position_name' => 'Project Construction Division Head'],
            ['personnel_area_code' => 'PST', 'position_name' => 'Project Monitoring & Evaluation Division Head'],
            ['personnel_area_code' => 'REG I', 'position_name' => 'Regional CEO - Kantor Regional I'],
            ['personnel_area_code' => 'REG I', 'position_name' => 'Deputy Regional Airport Operation & Services'],
            ['personnel_area_code' => 'REG I', 'position_name' => 'Deputy Regional Finance, Asset & Risk Management'],
            ['personnel_area_code' => 'REG II', 'position_name' => 'Regional CEO - Kantor Regional II'],
            ['personnel_area_code' => 'REG II', 'position_name' => 'Regional Airport Facility, Equipment, & Technology Readiness'],
            ['personnel_area_code' => 'REG II', 'position_name' => 'Regional Airport Commercial Development'],
            ['personnel_area_code' => 'REG III', 'position_name' => 'Regional CEO - Kantor Regional III'],
            ['personnel_area_code' => 'REG IV', 'position_name' => 'Regional CEO - Kantor Regional IV'],
            ['personnel_area_code' => 'REG V', 'position_name' => 'Regional CEO - Kantor Regional V'],
            ['personnel_area_code' => 'REG VI', 'position_name' => 'Regional CEO - Kantor Regional VI'],
            ['personnel_area_code' => 'CGK', 'position_name' => 'General Manager KC Bandara Internasional Soekarno-Hatta'],
            ['personnel_area_code' => 'CGK', 'position_name' => 'Deputy General Manager Airport Commercial Services'],
            ['personnel_area_code' => 'CGK', 'position_name' => 'Assistant Deputy Airside Operation Services'],
            ['personnel_area_code' => 'CGK', 'position_name' => 'Assistant Deputy Aero Business'],
            ['personnel_area_code' => 'CGK', 'position_name' => 'International Aero Commercial Division Head'],
            ['personnel_area_code' => 'CGK', 'position_name' => 'International Airlines Support Department Head'],
            ['personnel_area_code' => 'CGK', 'position_name' => 'Deputy General Manager Airport Facility, Equipment & Technology Services'],
            ['personnel_area_code' => 'CGK', 'position_name' => 'Assistant Deputy Airport Electrical Services'],
            ['personnel_area_code' => 'CGK', 'position_name' => 'Energy & Power Supply Services Division Head'],
            ['personnel_area_code' => 'CGK', 'position_name' => 'High & Medium Voltage Department Head'],
            ['personnel_area_code' => 'BDO', 'position_name' => 'General Manager KC Bandara Husein Sastranegara'],
            ['personnel_area_code' => 'BDO', 'position_name' => 'Airport Operation, Services & Security Division Head'],
            ['personnel_area_code' => 'BDO', 'position_name' => 'Airport Operation Air Side Department Head'],
            ['personnel_area_code' => 'BDO', 'position_name' => 'Airport Rescue & Fire Fighting Department Head'],
            ['personnel_area_code' => 'DPS', 'position_name' => 'General Manager KC Bandara Internasional I Gusti Ngurah Rai'],
            ['personnel_area_code' => 'DPS', 'position_name' => 'Deputy General Manager Airport Operation & Security Services'],
            ['personnel_area_code' => 'DPS', 'position_name' => 'Airport Airside & ARFF Operation Services Division Head'],
            ['personnel_area_code' => 'DPS', 'position_name' => 'Airside Operation Services Department Head'],
            ['personnel_area_code' => 'DPS', 'position_name' => 'Deputy General Manager Airport Facility & Equipment Readiness'],
            ['personnel_area_code' => 'DPS', 'position_name' => 'Airport Equipment Division Head'],
            ['personnel_area_code' => 'DPS', 'position_name' => 'Mechanical Services Department Head'],
            ['personnel_area_code' => 'LOP', 'position_name' => 'General Manager KC Bandara Internasional Zainuddin Abdul Madjid'],
            ['personnel_area_code' => 'LOP', 'position_name' => 'Airport Safety, Risk and Performance Management Division Head'],
            ['personnel_area_code' => 'LOP', 'position_name' => 'Safety Management System & Ohs Department Head'],
            ['personnel_area_code' => 'BTJ', 'position_name' => 'General Manager KC Bandara Internasional Sultan Iskandar Muda'],
            ['personnel_area_code' => 'BTJ', 'position_name' => 'Airport Safety, Risk and Performance Management Department Head'],
            ['personnel_area_code' => 'BTJ', 'position_name' => 'Airport Technical Division Head'],
        ];

        foreach ($officials_to_users as $area) {
            $official = Official::where('personnel_area_code', $area['personnel_area_code'])
                ->where('position_name', $area['position_name'])
                ->first();

            if (!$official) {
                continue;
            }

            $official = $official->toArray();
            unset($official['id']);

            $user = User::updateOrCreate(
                ['employee_id' => $official['employee_id'], 'personnel_area_code' => $official['personnel_area_code']],
                $official +
                    [
                        'password' => bcrypt($official['username'] . '#321'),
                        'image_url' => '',
                        'is_active' => true,
                    ]
            );

            $unit = $user->units()->firstOrCreate(
                [
                    'sub_unit_code' => $official['sub_unit_code'],
                    'position_name' => $official['position_name'],
                ],
                [
                    'organization_code' => $official['organization_code'],
                    'organization_name' => $official['organization_name'],
                    'personnel_area_name' => $official['personnel_area_name'],
                    'personnel_area_code' => $official['personnel_area_code'],
                    'position_name' => $official['position_name'],
                    'unit_name' => $official['unit_name'],
                    'sub_unit_name' => $official['sub_unit_name'],
                    'unit_code' => $official['unit_code'],
                    'sub_unit_code' => $official['sub_unit_code'],
                    'employee_grade_code' => $official['employee_grade_code'],
                    'employee_grade' => $official['employee_grade'],
                    'source_type' => UnitSourceType::SYSTEM->value,
                    'expired_at' => now()->addYears(50),
                ]
            );

            $position = Position::whereSubUnitCode($official['sub_unit_code'])
                ->where('position_name', $official['position_name'])
                ->first();
            if (!$position) {
                logger()->error('[DefaultSeeder] Position not found: ' . $official['position_name']);
                $unit->syncRoles('risk admin');
                continue;
            }

            $unit->syncRoles(explode(',', $position->assigned_roles));
        }
    }
}
