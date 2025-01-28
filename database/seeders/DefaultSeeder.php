<?php

namespace Database\Seeders;

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
                'route' => 'risk',
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
                        'route' => 'risk.profile.index',
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
                ],
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
                    [
                        'name' => 'Menu',
                        'route' => 'rbac.menu.index',
                        'position' => 1,
                    ],
                    [
                        'name' => 'Grup',
                        'route' => 'rbac.role.index',
                        'position' => 2,
                    ],
                    [
                        'name' => 'Hak Akses',
                        'route' => 'rbac.permission.index',
                        'position' => 3,
                    ],
                ],
            ],
        ];

        if (Menu::count() == 0) {
            foreach ($menus as $key => $menu) {
                $children = $menu['children'] ?? [];
                unset($menu['children']);

                $menu = Menu::firstOrCreate(['name' => $menu['name'], 'route' => $menu['route']], $menu + ['position' => $key + 1]);
                if ($children) {
                    $menu->children()->createMany($children);
                }
            }
        }

        /**
         * Generate default permissions
         */
        $menus = Menu::all();
        $actions = [
            [
                'name' => 'risk.worksheet.',
                'permissions' => ['index', 'show', 'create', 'store', 'edit', 'update', 'destroy', 'update_status'],
            ],
            [
                'name' => 'risk.monitoring.',
                'permissions' => ['show_monitoring', 'edit_monitoring', 'update_monitoring', 'update_status_monitoring'],
            ]
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

        $defaultActions = ['index', 'show', 'create', 'store', 'edit', 'update', 'destroy'];
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
            $roles = [['name' => 'root'], ['name' => 'risk admin'], ['name' => 'risk owner'], ['name' => 'risk otorisator'], ['name' => 'risk analis']];
        }
        $permissions = Permission::where('name', 'not like', '%access%')->get();

        if (Role::count() == 0) {
            foreach ($roles as $role) {
                $role = Role::create($role);

                if ($role->name == 'root') {
                    $role->syncPermissions($permissions->pluck('name'));
                    $role->menus()->sync($menus->pluck('id'));
                } else if ($role->name == 'risk otorisator') {
                    $role->syncPermissions($permissions->pluck('name'));
                    $role->menus()->sync(
                        $menus->filter(
                            function ($menu) {
                                return str_contains($menu->route, 'risk.') ||
                                    $menu->route == 'risk' ||
                                    str_contains($menu->route, 'dashboard');
                            }
                        )->pluck('id')
                    );
                } else {
                    $role->syncPermissions($permissions->pluck('name'));
                    $role->menus()->sync(
                        $menus->filter(
                            function ($menu) {
                                return str_contains($menu->route, 'risk.') ||
                                    str_contains($menu->route, 'risk.profile') ||
                                    $menu->route == 'risk' ||
                                    str_contains($menu->route, 'dashboard');
                            }
                        )->pluck('id')
                    );
                }
            }
        }

        $users = $users = [
            [
                [
                    'username' => 'root',
                    'password' => bcrypt('root#321'),
                    'email' => 'root@injourneyairports.id',
                    'employee_name' => 'Administrator',
                    'employee_id' => '9999999',
                    'organization_code' => 'ap.50',
                    'organization_name' => '',
                    'personnel_area_name' => 'Kantor Regional I',
                    'personnel_area_code' => 'REG I',
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
                ['root', 'risk admin', 'risk analis', 'risk owner', 'risk otorisator']
            ],
            [
                [
                    'username' => 'root_analis_pusat',
                    'password' => bcrypt('root#321'),
                    'email' => 'root_analis_pusat@injourneyairports.id',
                    'employee_name' => 'Administrator',
                    'employee_id' => '9999999',
                    'organization_code' => 'ap',
                    'organization_name' => '',
                    'personnel_area_name' => 'Kantor PUSAT',
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
                ['risk analis']
            ],
            [
                [
                    'username' => 'root_analis_reg_1',
                    'password' => bcrypt('root_analis_reg_1#321'),
                    'email' => 'root_analis_reg_1@injourneyairports.id',
                    'employee_name' => 'ANALIS REG 1',
                    'employee_id' => '20008357',
                    'organization_code' => 'ap.51',
                    'organization_name' => 'Kantor Regional I (09 September 2024) - CGK',
                    'personnel_area_name' => 'Kantor Regional I',
                    'personnel_area_code' => 'REG I',
                    'position_name' => 'Regional CEO - Kantor Regional I',
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
                    'username' => 'root_analis_reg_3',
                    'password' => bcrypt('root_analis_reg_3#321'),
                    'email' => 'root_analis_reg_3@injourneyairports.id',
                    'employee_name' => 'ANALIS REG 2',
                    'employee_id' => '20008357',
                    'organization_code' => 'ap.52',
                    'organization_name' => 'Kantor Regional III(09 September 2024) - CGK',
                    'personnel_area_name' => 'Kantor Regional III',
                    'personnel_area_code' => 'REG III',
                    'position_name' => 'Regional CEO - Kantor Regional III',
                    'unit_name' => 'SIDOEL Group',
                    'sub_unit_name' => 'Kantor Regional III (09 September 2024) - CGK',
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
                    'username' => 'agus.haryadi1',
                    'password' => bcrypt('agus.haryadi1#321'),
                    'email' => 'agus.haryadi1@injourneyairports.id',
                    'employee_name' => 'AGUS HARYADI',
                    'employee_id' => '20008357',
                    'organization_code' => 'ap.51',
                    'organization_name' => 'Kantor Regional I (09 September 2024) - CGK',
                    'personnel_area_name' => 'Kantor Regional I',
                    'personnel_area_code' => 'REG I',
                    'position_name' => 'Regional CEO - Kantor Regional I',
                    'unit_name' => 'SIDOEL Group',
                    'sub_unit_name' => 'Kantor Regional I (09 September 2024) - CGK',
                    'unit_code' => 'ap',
                    'sub_unit_code' => 'ap.51',
                    'employee_grade_code' => '-',
                    'employee_grade' => '-',
                    'image_url' => '',
                    'is_active' => true,
                ],
                ['risk otorisator']
            ],
            [
                [
                    'username' => 'dani.irawan',
                    'password' => bcrypt('dani.irawan#321'),
                    'email' => 'dani.irawan@injourneyairports.id',
                    'employee_name' => 'DANI INDRA IRIAWAN',
                    'employee_id' => '20240083',
                    'organization_code' => 'ap.52',
                    'organization_name' => 'Kantor Regional III (09 September 2024) - KNO',
                    'personnel_area_name' => 'Kantor Regional III',
                    'personnel_area_code' => 'REG III',
                    'position_name' => 'Regional CEO - Kantor Regional III',
                    'unit_name' => 'SIDOEL Group',
                    'sub_unit_name' => 'Kantor Regional III (09 September 2024) - KNO',
                    'unit_code' => 'ap',
                    'sub_unit_code' => 'ap.52',
                    'employee_grade_code' => '-',
                    'employee_grade' => '-',
                    'image_url' => '',
                    'is_active' => true,
                ],
                ['risk otorisator']
            ],
            [
                [
                    'username' => 'dwi.ananda',
                    'password' => bcrypt('dwi.ananda#321'),
                    'email' => 'dwi.ananda@injourneyairports.id',
                    'employee_name' => 'DWI ANANDA WICAKSANA',
                    'employee_id' => '20001986',
                    'organization_code' => 'ap.51.6',
                    'organization_name' => 'KC Bandara Internasional Soekarno-Hatta',
                    'personnel_area_name' => 'KC Bandara Soekarno-Hatta',
                    'personnel_area_code' => 'CGK',
                    'position_name' => 'General Manager KC Bandara Internasional Soekarno-Hatta',
                    'unit_name' => 'Kantor Regional I (09 September 2024) - CGK',
                    'sub_unit_name' => 'KC Bandara Internasional Soekarno-Hatta',
                    'unit_code' => 'ap.51',
                    'sub_unit_code' => 'ap.51.6',
                    'employee_grade_code' => '-',
                    'employee_grade' => '-',
                    'image_url' => '',
                    'is_active' => true,
                ],
                ['risk otorisator']
            ],
            [
                [
                    'username' => 'wahyudi',
                    'password' => bcrypt('wahyudi#321'),
                    'email' => 'wahyudi@injourneyairports.id',
                    'employee_name' => 'WAHYUDI',
                    'employee_id' => '20247953',
                    'organization_code' => 'ap.53',
                    'organization_name' => 'Kantor Regional II (09 September 2024) - DPS',
                    'personnel_area_name' => 'Kantor Regional II',
                    'personnel_area_code' => 'REG II',
                    'position_name' => 'Regional CEO - Kantor Regional II',
                    'unit_name' => 'SIDOEL Group',
                    'sub_unit_name' => 'Kantor Regional II (09 September 2024) - DPS',
                    'unit_code' => 'ap',
                    'sub_unit_code' => 'ap.53',
                    'employee_grade_code' => '-',
                    'employee_grade' => '-',
                    'image_url' => '',
                    'is_active' => true,
                ],
                ['risk otorisator']
            ],
            [
                [
                    'username' => 'ahmad.shahab',
                    'password' => bcrypt('ahmad.shahab#321'),
                    'email' => 'ahmad.shahab@injourneyairports.id',
                    'employee_id' => '20240584',
                    'employee_name' => 'AHMAD SYAUGI SHAHAB',
                    'organization_code' => 'ap.53.2',
                    'organization_name' => 'KC Bandara Internasional I Gusti Ngurah Rai',
                    'personnel_area_name' => 'KC Bandara Ngurah Rai',
                    'personnel_area_code' => 'DPS',
                    'position_name' => 'General Manager KC Bandara Internasional I Gusti Ngurah Rai',
                    'unit_name' => 'Kantor Regional II (09 September 2024) - DPS',
                    'sub_unit_name' => 'KC Bandara Internasional I Gusti Ngurah Rai',
                    'unit_code' => 'ap.53',
                    'sub_unit_code' => 'ap.53.2',
                    'employee_grade_code' => '-',
                    'employee_grade' => '-',
                    'image_url' => '',
                    'is_active' => true,
                ],
                ['risk otorisator']
            ],
            [
                [
                    'username' => 'ibnu.solikin',
                    'password' => bcrypt('ibnu.solikin#321'),
                    'email' => 'ibnu.solikin@injourneyairports.id',
                    'employee_name' => 'Ibnu Solikin',
                    'employee_id' => '20240501',
                    'organization_code' => 'ap.53.2.1',
                    'organization_name' => 'Airport Operation & Security Services',
                    'personnel_area_name' => 'KC Bandara Ngurah Rai',
                    'personnel_area_code' => 'DPS',
                    'position_name' => 'Deputy General Manager Airport Operation & Security Services',
                    'unit_name' => 'KC Bandara Internasional I Gusti Ngurah Rai',
                    'sub_unit_name' => 'Airport Operation & Security Services',
                    'unit_code' => 'ap.53.2',
                    'sub_unit_code' => 'ap.53.2.1',
                    'employee_grade_code' => '-',
                    'employee_grade' => '-',
                    'image_url' => '',
                    'is_active' => true,
                ],
                ['risk otorisator']
            ],
            [
                [
                    'username' => 'randy.wake',
                    'password' => bcrypt('randy.wake#321'),
                    'email' => 'randy.wake@injourneyairports.id',
                    'employee_name' => 'Randy Michael Hirewake',
                    'employee_id' => '20242043',
                    'organization_code' => 'ap.53.2.1.3',
                    'organization_name' => 'Landside Services Support',
                    'personnel_area_name' => 'KC Bandara Ngurah Rai',
                    'personnel_area_code' => 'DPS',
                    'position_name' => 'Landside Services Support Division Head',
                    'unit_name' => 'Airport Operation & Security Services',
                    'sub_unit_name' => 'Landside Services Support',
                    'unit_code' => 'ap.53.2.1',
                    'sub_unit_code' => 'ap.53.2.1.3',
                    'employee_grade_code' => '-',
                    'employee_grade' => '-',
                    'image_url' => '',
                    'is_active' => true,
                ],
                ['risk owner']
            ],
            [
                [
                    'username' => 'budi.santosa',
                    'password' => bcrypt('budi.santosa#321'),
                    'email' => 'budi.santosa@injourneyairports.id',
                    'employee_name' => 'Budi Santosa',
                    'employee_id' => '20240602',
                    'organization_code' => 'ap.53.2.1.1',
                    'organization_name' => 'Airport Airside & ARFF Operation Services',
                    'personnel_area_name' => 'KC Bandara Ngurah Rai',
                    'personnel_area_code' => 'DPS',
                    'position_name' => 'Airport Airside & ARFF Operation Services Division Head',
                    'unit_name' => 'Airport Operation & Security Services',
                    'sub_unit_name' => 'Airport Airside & ARFF Operation Services',
                    'unit_code' => 'ap.53.2.1',
                    'sub_unit_code' => 'ap.53.2.1.1',
                    'employee_grade_code' => '-',
                    'employee_grade' => '-',
                    'image_url' => '',
                    'is_active' => true,
                ],
                ['risk owner']
            ],
            [
                [
                    'username' => 'nicolas.prima',
                    'password'  => bcrypt('nicolas.prima#321'),
                    'email' => 'nicolas.prima@injourneyairports.id',
                    'employee_name' => 'NICOLAS PRIMA K. A.',
                    'employee_id' => '20002891',
                    'organization_code' => 'ap.50.6.1',
                    'organization_name' => 'Governance & Risk Management',
                    'personnel_area_name' => 'Kantor Pusat',
                    'personnel_area_code' => 'PST',
                    'position_name' => 'Governance & Risk Management Group Head',
                    'unit_name' => 'Direktorat Manajemen Risiko',
                    'sub_unit_name' => 'Governance & Risk Management',
                    'unit_code' => 'ap.50.6',
                    'sub_unit_code' => 'ap.50.6.1',
                    'employee_grade_code' => '-',
                    'employee_grade' => '-',
                    'image_url' => '',
                    'is_active' => true,
                ],
                ['risk otorisator']
            ],
            [
                [
                    'username' => 'gede.krisna',
                    'password' => bcrypt('gede.krisna#321'),
                    'email' => 'gede.krisna@injourneyairports.id',
                    'employee_name' => 'Gede Adicahya Krisna',
                    'employee_id' => '20240760',
                    'organization_code' => 'ap.53.2.1.1.1',
                    'organization_name' => 'Airside Operation Services',
                    'personnel_area_name' => 'KC Bandara Ngurah Rai',
                    'personnel_area_code' => 'DPS',
                    'position_name' => 'Airside Operation Services Department Head',
                    'unit_name' => 'Airport Airside & ARFF Operation Services',
                    'sub_unit_name' => 'Airside Operation Services',
                    'unit_code' => 'ap.53.2.1.1',
                    'sub_unit_code' => 'ap.53.2.1.1.1',
                    'employee_grade_code' => '-',
                    'employee_grade' => '-',
                    'image_url' => '',
                    'is_active' => true,
                ],
                ['risk admin']
            ],
            [
                [
                    'username' => 'sulistiyanto.sulis',
                    'password' => bcrypt('sulistiyanto.sulis#321'),
                    'email' => 'sulistiyanto.sulis@injourneyairports.id',
                    'employee_name' => 'Sulistiyanto',
                    'employee_id' => '20241323',
                    'organization_code' => 'ap.53.2.1.1.2',
                    'organization_name' => 'Airport Rescue & Fire Fighting',
                    'personnel_area_name' => 'KC Bandara Ngurah Rai',
                    'personnel_area_code' => 'DPS',
                    'position_name' => 'Airport Rescue & Fire Fighting Department Head',
                    'unit_name' => 'Airport Airside & ARFF Operation Services',
                    'sub_unit_name' => 'Airport Rescue & Fire Fighting',
                    'unit_code' => 'ap.53.2.1.1',
                    'sub_unit_code' => 'ap.53.2.1.1.2',
                    'employee_grade_code' => '-',
                    'employee_grade' => '-',
                    'image_url' => '',
                    'is_active' => true,
                ],
                ['risk admin']
            ],
            [
                [
                    'username' => 'btj.asrp',
                    'password' => bcrypt('btj.asrp#321'),
                    'email' => 'btj.asrp@injourneyairports.id',
                    'employee_name' => 'BTJ ASRP STAFF',
                    'employee_id' => '20242114',
                    'organization_code' => 'ap.52.9.6',
                    'organization_name' => 'Airport Safety, Risk and Performance Management',
                    'personnel_area_name' => 'KC Bandara Sultan Iskandar Muda',
                    'personnel_area_code' => 'BTJ',
                    'position_name' => 'Airport Safety, Risk and Performance Management Department Staff',
                    'unit_name' => 'KC Bandara Internasional Sultan Iskandar Muda',
                    'sub_unit_name' => 'Airport Safety, Risk and Performance Management',
                    'unit_code' => 'ap.52.9',
                    'sub_unit_code' => 'ap.52.9.6',
                    'employee_grade_code' => '-',
                    'employee_grade' => '-',
                    'image_url' => '',
                    'is_active' => true,
                ],
                ['risk admin']
            ]
        ];

        foreach ($users as $user) {
            $newUser = User::firstOrCreate(['username' => $user[0]['username']], $user[0]);
            $newUser->update($user[0]);
            $newUser->syncRoles($user[1]);
        }
    }
}
