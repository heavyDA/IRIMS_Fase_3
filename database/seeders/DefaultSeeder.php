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
        $roles = [['name' => 'root'], ['name' => 'risk admin'], ['name' => 'risk owner'], ['name' => 'risk otorisator'], ['name' => 'risk analis']];

        $permissions = Permission::where('name', 'not like', '%access%')->get();

        foreach ($roles as $role) {
            $role = Role::create($role);

            if ($role->name == 'root') {
                $role->syncPermissions($permissions->pluck('name'));
                $role->menus()->sync($menus->pluck('id'));
            } else {
                $role->syncPermissions($permissions->pluck('name'));
                $role->menus()->sync($menus->filter(fn($menu) => !str_contains($menu->route, 'access') || str_contains($menu->route, 'master.') || $menu->route == 'master')->pluck('id'));
            }
        }

        $users = [
            [
                [
                    'username' => 'root',
                    'email' => 'root@example.com',
                    'password' => bcrypt('root'),
                    'employee_id' => '99999999',
                    'employee_name' => 'ROOT',
                    'unit_code' => 'ap.50.1',
                    'unit_name' => 'Direktorat Strategi & Pengembangan Teknologi',
                    'sub_unit_code' => 'ap.50.1.5',
                    'sub_unit_name' => 'echnology & Digitalization',
                    'organization_code' => 'ap.50.1.5',
                    'organization_name' => 'echnology & Digitalization',
                    'personnel_area_code' => 'PST',
                    'personnel_area_name' => 'Kantor Pusat',
                    'position_name' => 'Staff of Technology & Digitalization',
                    'employee_grade_code' => '-',
                    'employee_grade' => '-',
                    'image_url' => '',
                    'is_active' => true,
                ],
                ['root', 'risk admin', 'risk owner', 'risk otorisator', 'risk analis'],
            ],
            [
                [
                    'username' => 'lilip.rifai',
                    'email' => 'lilip.rifai@injourneyairports.id',
                    'password' => bcrypt('lilip.rifai'),
                    'employee_id' => '20005773',
                    'employee_name' => 'Lilip Rifai',
                    'unit_code' => 'ap.50.1',
                    'unit_name' => 'Direktorat Strategi & Pengembangan Teknologi',
                    'sub_unit_code' => 'ap.50.1.5',
                    'sub_unit_name' => 'Technology & Digitalization',
                    'organization_code' => 'ap.50.1.5',
                    'organization_name' => 'Technology & Digitalization',
                    'personnel_area_code' => 'PST',
                    'personnel_area_name' => 'Kantor Pusat',
                    'position_name' => 'Secretary of Technology & Digitalization',
                    'employee_grade_code' => '-',
                    'employee_grade' => '-',
                    'image_url' => '',
                    'is_active' => true,
                ],
                ['risk owner'],
            ],
            [
                [
                    'username' => 'user.trial',
                    'email' => 'user.trial@injourneyairports.id',
                    'password' => bcrypt('user.trial'),
                    'employee_id' => '200012345678',
                    'employee_name' => 'User Trial',
                    'unit_code' => 'ap.50.1',
                    'unit_name' => 'Direktorat Strategi & Pengembangan Teknologi',
                    'sub_unit_code' => 'ap.50.1.5',
                    'sub_unit_name' => 'Technology & Digitalization',
                    'organization_code' => 'ap.50.1.5',
                    'organization_name' => 'Technology & Digitalization',
                    'personnel_area_code' => 'PST',
                    'personnel_area_name' => 'Kantor Pusat',
                    'position_name' => 'Staff of Technology GH',
                    'employee_grade_code' => '-',
                    'employee_grade' => '-',
                    'image_url' => '',
                    'is_active' => true,
                ],
                ['risk admin'],
            ],
            [
                [
                    'username' => 'restu.pratiwi',
                    'email' => 'restu.pratiwi@injourneyairports.id',
                    'password' => bcrypt('restu.pratiwi'),
                    'employee_id' => '20241632',
                    'employee_name' => 'Restu Pratiwi',
                    'unit_code' => 'ap.50.6.1',
                    'unit_name' => 'Governance & Risk Management',
                    'sub_unit_code' => 'ap.50.6.1.2',
                    'sub_unit_name' => 'Enterprise Risk Management',
                    'organization_code' => 'ap.50.1.5',
                    'organization_name' => 'Enterprise Risk Management',
                    'personnel_area_code' => 'PST',
                    'personnel_area_name' => 'Kantor Pusat',
                    'position_name' => 'Enterprise Risk Management Division Head',
                    'employee_grade_code' => '-',
                    'employee_grade' => '-',
                    'image_url' => '',
                    'is_active' => true,
                ],
                ['risk analis', 'risk owner', 'risk otorisator', 'risk admin'],
            ],
            [
                [
                    'email' => 'wahyu.c@injourneyairports.id',
                    'username' => 'wahyu.c',
                    'password' => bcrypt('wahyu.c'),
                    'employee_id' => '20002554',
                    'employee_name' => 'WAHYU CAHYADI',
                    'unit_code' => 'ap.50.1',
                    'unit_name' => 'Direktorat Strategi & Pengembangan Teknologi',
                    'sub_unit_code' => 'ap.50.1.5',
                    'sub_unit_name' => 'Technology & Digitalization',
                    'organization_code' => 'ap.50.1.5',
                    'organization_name' => 'Technology & Digitalization',
                    'personnel_area_code' => 'PST',
                    'personnel_area_name' => 'Kantor Pusat',
                    'position_name' => 'Technology & Digitalization Group Head',
                    'employee_grade_code' => '-',
                    'employee_grade' => '-',
                    'image_url' => '',
                    'is_active' => true,
                ],
                ['risk otorisator'],
            ],
            [
                [
                    "username" => "nicolas.prima",
                    "password" => bcrypt("nicolas.prima"),
                    "employee_name" => "NICOLAS PRIMA K. A.",
                    "employee_id" => "20002891",
                    "organization_code" => "ap.50.6.1",
                    "organization_name" => "Governance & Risk Management",
                    "email" => "nicolas.prima@injourneyairports.id",
                    "personnel_area_name" => "Kantor Pusat",
                    "personnel_area_code" => "PST",
                    "position_name" => "Governance & Risk Management Group Head",
                    "unit_name" => "Direktorat Manajemen Risiko",
                    "sub_unit_name" => "Governance & Risk Management",
                    "unit_code" => "ap.50.6",
                    "sub_unit_code" => "ap.50.6.1",
                    "employee_grade_code" => "-",
                    "employee_grade" => "-",
                    'is_active' => true,
                ],
                ['risk otorisator']
            ],
            [
                [
                    "username" => "budi.wijayanto",
                    "password" => bcrypt("budi.wijayanto"),
                    "employee_name" => "BUDI TRI WIJAYANTO",
                    "employee_id" => "20241670",
                    "organization_code" => "ap.50.6.1.1",
                    "organization_name" => "Governance Assurance",
                    "email" => "budi.wijayanto@injourneyairports.id",
                    "personnel_area_name" => "Kantor Pusat",
                    "personnel_area_code" => "PST",
                    "position_name" => "Governance Assurance Division Head",
                    "unit_name" => "Governance & Risk Management",
                    "sub_unit_name" => "Governance Assurance",
                    "unit_code" => "ap.50.6.1",
                    "sub_unit_code" => "ap.50.6.1.1",
                    "employee_grade_code" => "-",
                    "employee_grade" => "-",
                    'is_active' => true,
                ],
                ['risk otorisator']
            ],
            [
                [
                    "username" => "restu.pratiwi",
                    "password" => bcrypt("restu.pratiwi"),
                    "employee_name" => "RESTU PRATIWI",
                    "employee_id" => "20241632",
                    "organization_code" => "ap.50.6.1.2",
                    "organization_name" => "Enterprise Risk Management",
                    "email" => "restu.pratiwi@injourneyairports.id",
                    "personnel_area_name" => "Kantor Pusat",
                    "personnel_area_code" => "PST",
                    "position_name" => "Enterprise Risk Management Division Head",
                    "unit_name" => "Governance & Risk Management",
                    "sub_unit_name" => "Enterprise Risk Management",
                    "unit_code" => "ap.50.6.1",
                    "sub_unit_code" => "ap.50.6.1.2",
                    "employee_grade_code" => "-",
                    "employee_grade" => "-",
                    'is_active' => true,
                ],
                ['risk owner', 'risk admin']
            ],
            [
                [
                    "username" => "ahmad.mustofa",
                    "password" => bcrypt("ahmad.mustofa"),
                    "employee_name" => "AHMAD MUSTOFA",
                    "employee_id" => "20002708",
                    "organization_code" => "ap.50.6.1.2",
                    "organization_name" => "Enterprise Risk Management",
                    "email" => "ahmad.mustofa@injourneyairports.id",
                    "personnel_area_name" => "Kantor Pusat",
                    "personnel_area_code" => "PST",
                    "position_name" => "Enterprise Risk Management Specialist",
                    "unit_name" => "Governance & Risk Management",
                    "sub_unit_name" => "Enterprise Risk Management",
                    "unit_code" => "ap.50.6.1",
                    "sub_unit_code" => "ap.50.6.1.2",
                    "employee_grade_code" => "-",
                    "employee_grade" => "-",
                    'is_active' => true,
                    "image_url" => "https://eoffice.injourneyairports.id/assets/img/profile/photoAP2/20002708.JPG"
                ],
                ['risk admin']
            ]

        ];

        foreach ($users as $user) {
            $newUser = User::create($user[0]);
            $newUser->assignRole($user[1]);
        }
    }
}
