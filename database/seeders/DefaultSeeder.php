<?php

namespace Database\Seeders;

use App\Models\Master\Official;
use App\Models\Master\Position;
use App\Models\RBAC\Menu;
use App\Models\RBAC\Permission;
use App\Models\RBAC\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

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
                'position' => 1,
                'children' => [
                    [
                        'name' => 'Dashboard',
                        'route' => 'dashboard.index',
                        'position' => 1,
                    ],
                    // [
                    //     'name' => 'Residual Top Risk',
                    //     'route' => 'dashboard.residual_top_risk.index',
                    //     'position' => 2,
                    // ],
                    // [
                    //     'name' => 'Top Risk',
                    //     'route' => 'dashboard.top_risk.index',
                    //     'position' => 3,
                    // ],
                    // [
                    //     'name' => 'Operational Risk',
                    //     'route' => 'dashboard.operational_risk,index',
                    //     'position' => 4,
                    // ],
                    // [
                    //     'name' => 'KRIs Dashboard',
                    //     'route' => 'dashboard.kris.index',
                    //     'position' => 5,
                    // ],
                    // [
                    //     'name' => 'Risk Profile Dashboard',
                    //     'route' => 'dashboard.risk_profile.index',
                    //     'position' => 6,
                    // ]
                ]
            ],
            // Risk Process BUMN section
            [
                'name' => 'Risk Process',
                'route' => 'risk.process',
                'icon_name' => 'presentation',
                'position' => 2,
                'children' => [
                    [
                        'name' => 'Risk Assessment',
                        'route' => 'risk.assessment.index',
                        'icon_name' => 'list',
                        'position' => 1,
                    ],
                    [
                        'name' => 'Risk Monitoring',
                        'route' => 'risk.monitoring.index',
                        'icon_name' => 'grid',
                        'position' => 2,
                    ],
                    [
                        'name' => 'Top Risk',
                        'route' => 'risk.top_risk.index',
                        'icon_name' => 'graph',
                        'position' => 3,
                    ]
                ],
            ],
            [
                'name' => 'Risk Report',
                'route' => 'risk.report',
                'icon_name' => 'clipboard-text',
                'position' => 3,
                'children' => [
                    [
                        'name' => 'Risk Profile',
                        'route' => 'risk.report.risk_profile.index',
                        'icon_name' => 'graph',
                        'position' => 1,
                    ],
                    [
                        'name' => 'Risk Monitoring',
                        'route' => 'risk.report.risk_monitoring.index',
                        'icon_name' => 'graph',
                        'position' => 2,
                    ],
                ],
            ],
            [
                'name' => 'Master Data',
                'route' => 'master',
                'icon_name' => 'cube',
                'position' => 8,
                'children' => [
                    [
                        'name' => 'Skala',
                        'route' => 'master.bumn_scales.index',
                        'position' => 0
                    ],
                    [
                        'name' => 'Jenis Existing Control',
                        'route' => 'master.existing_control_types.index',
                        'position' => 1
                    ],
                    [
                        'name' => 'Kategori Risiko',
                        'route' => 'master.risk_categories.index',
                        'position' => 3
                    ],
                    [
                        'name' => 'Opsi Perlakuan Risiko',
                        'route' => 'master.risk_treatment_options.index',
                        'position' => 4
                    ],
                    [
                        'name' => 'Jenis Rencana Perlakuan Risiko',
                        'route' => 'master.risk_treatment_types.index',
                        'position' => 5
                    ],
                    [
                        'name' => 'Kategori Kejadian',
                        'route' => 'master.incident_categories.index',
                        'position' => 6
                    ],
                ]
            ],
            [
                'name' => 'Pengaturan',
                'route' => 'setting',
                'icon_name' => 'settings',
                'position' => 9,
                'children' => [
                    [
                        'name' => 'Matrik Strategi Risiko',
                        'route' => 'setting.risk_metrics.index',
                        'position' => 0,
                    ],
                    [
                        'name' => 'Posisi',
                        'route' => 'setting.positions.index',
                        'position' => 1,
                    ],
                ]
            ],
            [
                'name' => 'Akses',
                'route' => 'access',
                'icon_name' => 'shield-lock',
                'position' => 10,
                'children' => [
                    [
                        'name' => 'Pengguna',
                        'route' => 'rbac.user.index',
                        'position' => 0,
                    ],
                    // [
                    //     'name' => 'Menu',
                    //     'route' => 'rbac.menu.index',
                    //     'position' => 1,
                    // ],
                    // [
                    //     'name' => 'Grup',
                    //     'route' => 'rbac.role.index',
                    //     'position' => 2,
                    // ],
                    // [
                    //     'name' => 'Hak Akses',
                    //     'route' => 'rbac.permission.index',
                    //     'position' => 3,
                    // ],
                ],
            ],
        ];

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
        $menus = Menu::all();

        $defaultActions = ['index', 'show', 'create', 'store', 'edit', 'update', 'destroy'];
        $actions = [
            [
                'name' => 'risk.worksheet.',
                'permissions' => ['index', 'show', 'create', 'store', 'edit', 'update', 'destroy', 'update_status'],
            ],
            [
                'name' => 'risk.monitoring.',
                'permissions' => ['show_monitoring', 'edit_monitoring', 'update_monitoring', 'update_status_monitoring', 'destroy_monitoring'],
            ],
            [
                'name' => 'bumn_scales',
                'permissions' => $defaultActions,
            ],
            [
                'name' => 'existing_control_types',
                'permissions' => $defaultActions,
            ],
            [
                'name' => 'incident_categories',
                'permissions' => $defaultActions,
            ],
            [
                'name' => 'risk_categories',
                'permissions' => $defaultActions,
            ],
            [
                'name' => 'risk_treatment_types',
                'permissions' => $defaultActions,
            ],
            [
                'name' => 'risk_treatment_options',
                'permissions' => $defaultActions,
            ],
        ];

        $permissions = [];
        foreach ($actions as $action) {
            foreach ($action['permissions'] as $permission) {
                $permissions[] = [
                    'name' => $action['name'] . $permission,
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        foreach ($menus as $menu) {
            if (str_contains($menu->route, 'index')) {
                foreach ($defaultActions as $action) {
                    $permissions[] = [
                        'name' => str_replace('index', $action, $menu->route),
                        'guard_name' => 'web',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            } elseif ($menu->route !== '#') {
                $permissions[] = [
                    'name' => $menu->route,
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        if (Permission::count() == 0) {
            $permissions = Permission::insert($permissions);
        }

        $roles = [['name' => 'root'], ['name' => 'administrator'], ['name' => 'risk admin'], ['name' => 'risk owner'], ['name' => 'risk otorisator'], ['name' => 'risk analis'], ['name' => 'risk reviewer']];
        foreach ($roles as $role) {
            $role = Role::firstOrCreate($role);

            if (in_array($role->name, ['root', 'administrator'])) {
                $permissions = Permission::all();

                $role->syncPermissions($permissions->pluck('name'));
                $role->menus()->sync($menus->pluck('id'));
            } else if ($role->name == 'risk reviewer') {
                $permissions = Permission::where('name', 'not like', '%access%')
                    ->where(
                        fn($q) => $q
                            ->whereNotIn(
                                'name',
                                [
                                    'risk.worksheet.create',
                                    'risk.worksheet.store',
                                    'risk.worksheet.edit',
                                    'risk.worksheet.update',
                                    'risk.worksheet.destroy',
                                    'risk.monitoring.create',
                                    'risk.monitoring.store',
                                    'risk.monitoring.edit',
                                    'risk.monitoring.update',
                                    'risk.monitoring.destroy',
                                    'risk.monitoring.edit_monitoring',
                                    'risk.monitoring.update_monitoring',
                                    'riks.top_risk.store',
                                ]
                            )
                    )
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
            } else if ($role->name == 'risk analis') {
                $permissions = Permission::where('name', 'not like', '%access%')->get();
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
                    ->where(
                        fn($q) => $q->whereNotIn(
                            'name',
                            [
                                'risk.worksheet.create',
                                'risk.worksheet.store',
                                'risk.worksheet.edit',
                                'risk.worksheet.update',
                                'risk.worksheet.destroy',
                                'risk.monitoring.create',
                                'risk.monitoring.store',
                                'risk.monitoring.edit',
                                'risk.monitoring.update',
                                'risk.monitoring.destroy',
                                'risk.monitoring.edit_monitoring',
                                'risk.monitoring.update_monitoring',
                            ]
                        )
                    )

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
                $permissions = Permission::where('name', 'not like', '%access%')
                    ->orWhereNotLike('name', 'risk.top_risk%')
                    ->get();

                $role->syncPermissions($permissions->pluck('name'));
                $role->menus()->sync(
                    $menus->filter(
                        function ($menu) {
                            return
                                str_contains($menu->route, 'risk.assessment') ||
                                str_contains($menu->route, 'risk.worksheet') ||
                                str_contains($menu->route, 'risk.monitoring') ||
                                str_contains($menu->route, 'risk.process') ||
                                str_contains($menu->route, 'risk.report') ||
                                str_contains($menu->route, 'dashboard');
                        }
                    )->pluck('id')
                );
            } else if ($role->name == 'risk admin') {
                $permissions = Permission::where('name', 'not like', '%access%')
                    ->where(
                        fn($q) => $q->orWhereNotLike('name', 'risk.report%')
                            ->orWhereNotLike('name', 'risk.top_risk%')
                    )
                    ->get();

                $role->syncPermissions($permissions->pluck('name'));
                $role->menus()->sync(
                    $menus->filter(
                        function ($menu) {
                            return
                                str_contains($menu->route, 'risk.assessment') ||
                                str_contains($menu->route, 'risk.worksheet') ||
                                str_contains($menu->route, 'risk.monitoring') ||
                                str_contains($menu->route, 'risk.process') ||
                                str_contains($menu->route, 'risk.report') ||
                                str_contains($menu->route, 'dashboard');
                        }
                    )->pluck('id')
                );
            }
        }

        $users = [
            [
                [
                    'username' => 'rahasia',
                    'password' => bcrypt('rahasia#321'),
                    'email' => 'root@injourneyairports.id',
                    'employee_name' => 'Administrator',
                    'employee_id' => 'x9999999',
                    'organization_code' => 'ap',
                    'organization_name' => '',
                    'personnel_area_name' => 'Kantor Pusat',
                    'personnel_area_code' => 'PST',
                    'position_name' => 'Administrator',
                    'unit_name' => '',
                    'sub_unit_name' => '',
                    'unit_code' => 'ap',
                    'sub_unit_code' => 'ap',
                    'employee_grade_code' => '-',
                    'employee_grade' => '-',
                    'image_url' => '',
                    'is_active' => true,
                ],
                ['root', 'risk admin', 'risk analis', 'risk owner', 'risk otorisator']
            ],
            [
                [
                    'username' => 'reviewer',
                    'password' => bcrypt('reviewer#321'),
                    'email' => 'reviewer@injourneyairports.id',
                    'employee_name' => 'Administrator',
                    'employee_id' => 'x9999998',
                    'organization_code' => 'ap',
                    'organization_name' => '',
                    'personnel_area_name' => 'Sidoel Group',
                    'personnel_area_code' => '',
                    'position_name' => 'Reviewer',
                    'unit_name' => '',
                    'sub_unit_name' => '',
                    'unit_code' => 'ap',
                    'sub_unit_code' => 'ap',
                    'employee_grade_code' => '-',
                    'employee_grade' => '-',
                    'image_url' => '',
                    'is_active' => true,
                ],
                ['risk reviewer']
            ],
            [
                [
                    'username' => 'user_analis_all',
                    'password' => bcrypt('user_analis_all#321'),
                    'email' => 'user_analis_all@injourneyairports.id',
                    'employee_name' => 'Administrator',
                    'employee_id' => 'x9999997',
                    'organization_code' => 'ap',
                    'organization_name' => '',
                    'personnel_area_name' => 'Sidoel Group',
                    'personnel_area_code' => '',
                    'position_name' => 'Administrator',
                    'unit_name' => '',
                    'sub_unit_name' => '',
                    'unit_code' => 'ap',
                    'sub_unit_code' => 'ap',
                    'employee_grade_code' => '-',
                    'employee_grade' => '-',
                    'image_url' => '',
                    'is_active' => true,
                ],
                ['risk analis']
            ],
            [
                [
                    'username' => 'user_analis_pusat',
                    'password' => bcrypt('user_analis_pusat#321'),
                    'email' => 'user_analis_pusat@injourneyairports.id',
                    'employee_name' => 'Administrator',
                    'employee_id' => 'x9999996',
                    'organization_code' => 'ap.50',
                    'organization_name' => '',
                    'personnel_area_name' => 'Kantor PUSAT',
                    'personnel_area_code' => 'PST',
                    'position_name' => 'Administrator',
                    'unit_name' => '',
                    'sub_unit_name' => '',
                    'unit_code' => 'ap',
                    'sub_unit_code' => 'ap.50',
                    'employee_grade_code' => '-',
                    'employee_grade' => '-',
                    'image_url' => '',
                    'is_active' => true,
                ],
                ['risk analis']
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
                    'unit_name' => 'SIDOEL Group',
                    'sub_unit_name' => 'Kantor Regional I (09 September 2024) - CGK',
                    'unit_code' => 'ap',
                    'sub_unit_code' => 'ap.51',
                    'employee_grade_code' => '-',
                    'employee_grade' => '-',
                    'image_url' => '',
                    'is_active' => true,
                ],
                ['risk analis']
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
                    'personnel_area_code' => 'REG III',
                    'position_name' => 'Risk Analis - Kantor Regional III',
                    'unit_name' => 'SIDOEL Group',
                    'sub_unit_name' => 'Kantor Regional III (09 September 2024) - KNO',
                    'unit_code' => 'ap',
                    'sub_unit_code' => 'ap.52',
                    'employee_grade_code' => '-',
                    'employee_grade' => '-',
                    'image_url' => '',
                    'is_active' => true,
                ],
                ['risk analis']
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
                    'personnel_area_code' => 'REG II',
                    'position_name' => 'Risk Analis - Kantor Regional II',
                    'unit_name' => 'SIDOEL Group',
                    'sub_unit_name' => 'Kantor Regional II (09 September 2024) - DPS',
                    'unit_code' => 'ap',
                    'sub_unit_code' => 'ap.53',
                    'employee_grade_code' => '-',
                    'employee_grade' => '-',
                    'image_url' => '',
                    'is_active' => true,
                ],
                ['risk analis']
            ],
        ];

        foreach ($users as $user) {
            $newUser = User::firstOrCreate(['username' => $user[0]['username']], $user[0]);
            $newUser->update($user[0]);
            $newUser->syncRoles($user[1]);
        }

        $officials_to_users = [
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
            ['personnel_area_code' => 'REG II', 'position_name' => 'Regional CEO - Kantor Regional II'],
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

            $user = User::updateOrCreate(
                ['employee_id' => $official->employee_id],
                $official->toArray() +
                    [
                        'password' => bcrypt($official->username . '#321'),
                        'image_url' => '',
                        'is_active' => true,
                    ]
            );

            $position = Position::whereLike('position_name', '%' . $official->position_name . '%')->first();
            if (!$position) {
                logger()->error('[DefaultSeeder] Position not found: ' . $official->position_name);
                $user->syncRoles('risk admin');
                continue;
            }

            $user->syncRoles($position->assigned_roles);
        }
    }
}
