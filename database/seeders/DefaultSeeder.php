<?php

namespace Database\Seeders;

use App\Models\RBAC\Menu;
use App\Models\RBAC\Permission;
use App\Models\RBAC\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
                'children' => [
                    [
                        'name' => 'Dashboard',
                        'route' => 'dashboard.index',
                        'position' => 1,
                    ],
                    [
                        'name' => 'Residual Top Risk',
                        'route' => 'dashboard.residual_top_risk.index',
                        'position' => 2,
                    ],
                    [
                        'name' => 'Top Risk',
                        'route' => 'dashboard.top_risk.index',
                        'position' => 3,
                    ],
                    [
                        'name' => 'Operational Risk',
                        'route' => 'dashboard.operational_risk,index',
                        'position' => 4,
                    ],
                    [
                        'name' => 'KRIs Dashboard',
                        'route' => 'dashboard.kris.index',
                        'position' => 5,
                    ],
                    [
                        'name' => 'Risk Profile Dashboard',
                        'route' => 'dashboard.risk_profile.index',
                        'position' => 6,
                    ]
                ]
            ],
            // Risk Process BUMN section
            [
                'name' => 'Risk Process',
                'route' => 'risk',
                'icon_name' => 'presentation',
                'position' => 4,
                'children' => [
                    [
                        'name' => 'Risk Assessment BUMN',
                        'route' => 'risk.assessment.index',
                        'icon_name' => 'list',
                        'position' => 1,
                    ],
                    [
                        'name' => 'Risk Worksheet',
                        'route' => 'risk.assessment.worksheet.index',
                        'icon_name' => 'grid',
                        'position' => 2,
                    ],
                    [
                        'name' => 'Risk Monitoring BUMN',
                        'route' => 'risk.monitoring.index',
                        'icon_name' => 'grid',
                        'position' => 3,
                    ],
                    [
                        'name' => 'Monev Risk BUMN',
                        'route' => 'risk.monitoring-evaluation.index',
                        'icon_name' => 'grid',
                        'position' => 4,
                    ],
                ],
            ],
            [
                'name' => 'Risk Report',
                'route' => 'risk_report',
                'icon_name' => 'clipboard-text',
                'position' => 3,
                'children' => [
                    [
                        'name' => 'Risk Register Card',
                        'route' => 'risk_report.assessment_report.register_card.index',
                        'icon_name' => 'graph',
                        'position' => 1,
                    ],
                    [
                        'name' => 'Risk Progress',
                        'route' => 'risk_report.assessment_report.index',
                        'icon_name' => 'graph',
                        'position' => 2,
                    ],
                    [
                        'name' => 'Risk Progress Head',
                        'route' => 'risk_report.assessment_report.head.index',
                        'icon_name' => 'graph',
                        'position' => 3,
                    ],
                    [
                        'name' => 'Risk Progress Owner',
                        'route' => 'risk_report.assessment_report.owner.index',
                        'icon_name' => 'graph',
                        'position' => 4,
                    ],
                    [
                        'name' => 'Risk Progress GM',
                        'route' => 'risk_report.assessment_report.gm.index',
                        'icon_name' => 'graph',
                        'position' => 5,
                    ],
                    [
                        'name' => 'Risk Progress Officer',
                        'route' => 'risk_report.assessment_report.officer.index',
                        'icon_name' => 'graph',
                        'position' => 6,
                    ],
                    [
                        'name' => 'Risk Progress Branch',
                        'route' => 'risk_report.assessment_report.branch.index',
                        'icon_name' => 'graph',
                        'position' => 7,
                    ],
                    [
                        'name' => 'Risk Monitoring Map',
                        'route' => 'risk_report.map.index',
                        'icon_name' => 'graph',
                        'position' => 8,
                    ],
                    [
                        'name' => 'Risk Mitigation Map',
                        'route' => 'risk_report.risk_map.index_mitigated.index',
                        'icon_name' => 'graph',
                        'position' => 9,
                    ],
                    [
                        'name' => 'Report Risk Baru',
                        'route' => 'risk_report.report_risk_new.index',
                        'icon_name' => 'graph',
                        'position' => 10,
                    ],
                ],
            ],
            // KRI section
            [
                'name' => 'Key Risk Indicator (KRI)',
                'route' => 'key_risk_indicator.index',
                'icon_name' => 'chart-bar-popular',
                'position' => 6,
                'children' => [],
            ],
            // Risk Document section
            [
                'name' => 'Risk Document',
                'route' => 'risk-document',
                'icon_name' => 'folder',
                'position' => 7,
                'children' => [
                    [
                        'name' => 'E-Library',
                        'route' => 'elibrary.elibrary.index',
                        'icon_name' => 'grid',
                        'position' => 1,
                    ],
                ],
            ],
            // Additional Master items
            [
                'name' => 'Master',
                'route' => 'master',
                'icon_name' => 'settings',
                'position' => 8,
                'children' => [
                    [
                        'name' => 'Risk Impact',
                        'route' => 'master.risk_impact.index',
                        'icon_name' => 'list',
                        'position' => 6,
                    ],
                    [
                        'name' => 'Risk Impact Category',
                        'route' => 'master.risk_impact_category.index',
                        'icon_name' => 'list',
                        'position' => 7,
                    ],
                    [
                        'name' => 'Risk Impact Indicator',
                        'route' => 'master.risk_impact_indicator.index',
                        'icon_name' => 'list',
                        'position' => 8,
                    ],
                    [
                        'name' => 'Risk Directorate',
                        'route' => 'master.risk_directorate.index',
                        'icon_name' => 'list',
                        'position' => 9,
                    ],
                    [
                        'name' => 'Risk PIC',
                        'route' => 'master.risk_pic.index',
                        'icon_name' => 'list',
                        'position' => 10,
                    ],
                    [
                        'name' => 'Status Dokumen',
                        'route' => 'master.status_dokumen.index',
                        'icon_name' => 'list',
                        'position' => 11,
                    ],
                    [
                        'name' => 'Cabang',
                        'route' => 'master.branch.index',
                        'icon_name' => 'list',
                        'position' => 12,
                    ],
                    [
                        'name' => 'Risk Target',
                        'route' => 'master.risk_target.index',
                        'icon_name' => 'list',
                        'position' => 13,
                    ],
                    [
                        'name' => 'Risk Factor',
                        'route' => 'master.risk_factor.index',
                        'icon_name' => 'list',
                        'position' => 14,
                    ],
                    [
                        'name' => 'Risk KPI',
                        'route' => 'master.risk_kpi.index',
                        'icon_name' => 'list',
                        'position' => 15,
                    ],
                    [
                        'name' => 'Kategori Risiko T3',
                        'route' => 'master.kategori_risiko_t3.index',
                        'icon_name' => 'grid',
                        'position' => 16,
                    ],
                    [
                        'name' => 'Kategori Risiko T2',
                        'route' => 'master.kategori_risiko_t2.index',
                        'icon_name' => 'grid',
                        'position' => 17,
                    ],
                    [
                        'name' => 'Master Data Satuan',
                        'route' => 'master.unit.index',
                        'icon_name' => 'grid',
                        'position' => 18,
                    ],
                    [
                        'name' => 'Information Detail',
                        'route' => 'master.control_information.index',
                        'icon_name' => 'grid',
                        'position' => 7,
                    ],
                    [
                        'name' => 'Metrix Strategi Risiko',
                        'route' => 'master.metrik_strategi_risiko.index',
                        'icon_name' => 'grid',
                        'position' => 8,
                    ],
                ],
            ],
            [
                'name' => 'Akses',
                'route' => 'access',
                'icon_name' => 'shield-lock',
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
                    [
                        'name' => 'Grup Pengguna PLH/PLT',
                        'route' => 'rbac.role.pjs.index',
                        'icon_name' => 'grid',
                        'position' => 9,
                    ],
                    [
                        'name' => 'Risk Unit Assignment',
                        'route' => 'rbac.role.risk.index',
                        'icon_name' => 'grid',
                        'position' => 10,
                    ],
                ],
            ],
        ];

        foreach ($menus as $key => $menu) {
            $children = $menu['children'] ?? [];
            unset($menu['children']);

            $menu = Menu::firstOrCreate(['name' => $menu['name'], 'route' => $menu['route']], $menu + ['position' => $key + 1]);
            if ($children) {
                $menu->children()->createMany($children);
            }
        }

        /**
         * Generate default permissions
         */
        $menus = Menu::all();
        $actions = ['index', 'show', 'create', 'store', 'edit', 'update', 'destroy'];
        $permissions = [];
        foreach ($menus as $menu) {
            if (str_contains($menu->route, 'index')) {
                foreach ($actions as $action) {
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

        $permissions = Permission::insert($permissions);
        $roles = [['name' => 'root'], ['name' => 'admin'], ['name' => 'risk owner'], ['name' => 'risk otorisator'], ['name' => 'risk analis']];

        $permissions = Permission::where('name', 'not like', '%access%')->get();

        foreach ($roles as $role) {
            $role = Role::create($role);

            if ($role->name == 'root') {
                $role->syncPermissions($permissions->pluck('name'));
                $role->menus()->sync($menus->pluck('id'));
            } else if ($role->name == 'admin') {
                $role->syncPermissions($permissions->pluck('name'));
                $role->menus()->sync($menus->filter(fn($menu) => !str_contains($menu->route, 'access') || str_contains($menu->route, 'master.') || $menu->route == 'master')->pluck('id'));
            }
        }

        $users = [
            [
                [
                    'email' => 'root@example.com',
                    'password' => bcrypt('root'),
                    'first_name' => 'Root',
                    'last_name' => '',
                    'username' => 'root',
                    'is_active' => true,
                    'photo' => null,
                    'created_by' => null,
                    'updated_by' => null,
                    'expired_at' => null,
                    'company_id' => 1,
                ],
                ['root', 'admin', 'risk owner', 'risk otorisator', 'risk analis'],
            ],
            [
                [
                    'email' => 'analis@example.com',
                    'password' => bcrypt('analis'),
                    'first_name' => 'Analis',
                    'last_name' => '',
                    'username' => 'analis',
                    'is_active' => 1,
                    'photo' => null,
                    'created_by' => null,
                    'updated_by' => null,
                    'expired_at' => null,
                    'company_id' => 1
                ],
                ['risk analis', 'admin'],
            ],
            [
                [
                    'email' => 'otorisator@example.com',
                    'password' => bcrypt('otorisator'),
                    'first_name' => 'Otorisator',
                    'last_name' => '',
                    'username' => 'otorisator',
                    'is_active' => 1,
                    'photo' => null,
                    'created_by' => null,
                    'updated_by' => null,
                    'expired_at' => null,
                    'company_id' => 1
                ],
                ['risk otorisator', 'admin'],
            ],
            [
                [
                    'email' => 'owner@example.com',
                    'password' => bcrypt('owner'),
                    'first_name' => 'Owner',
                    'last_name' => '',
                    'username' => 'owner',
                    'is_active' => 1,
                    'photo' => null,
                    'created_by' => null,
                    'updated_by' => null,
                    'expired_at' => null,
                    'company_id' => 1
                ],
                ['risk owner', 'admin'],
            ],
            [
                [
                    'email' => 'admin@example.com',
                    'password' => bcrypt('admin'),
                    'first_name' => 'Admin',
                    'last_name' => '',
                    'username' => 'admin',
                    'is_active' => 1,
                    'photo' => null,
                    'created_by' => null,
                    'updated_by' => null,
                    'expired_at' => null,
                    'company_id' => 1
                ],
                ['admin'],
            ],
        ];

        foreach ($users as $user) {
            $newUser = User::create($user[0]);
            $newUser->assignRole($user[1]);
        }
    }
}
