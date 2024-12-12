<?php

namespace Database\Seeders;

use App\Models\ACL\Menu;
use App\Models\ACL\Permission;
use App\Models\ACL\Role;
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
            ],
            [
                'name' => 'Master Data',
                'route' => 'master',
                'icon_name' => 'topology-star-3',
                'children' => [
                    [
                        'name' => 'Daerah',
                        'route' => 'master.region.index',
                        'position' => 0,
                    ],
                ]
                ],
            [
                'name' => 'Hak Akses',
                'route' => 'access',
                'icon_name' => 'shield-lock',
                'children' => [
                    [
                        'name' => 'Pengguna',
                        'route' => 'access.user.index',
                        'position' => 0,
                    ],
                    [
                        'name' => 'Menu',
                        'route' => 'access.menu.index',
                        'position' => 1,
                    ],
                    [
                        'name' => 'Grup',
                        'route' => 'access.role.index',
                        'position' => 2,
                    ],
                    [
                        'name' => 'Hak Akses',
                        'route' => 'access.permission.index',
                        'position' => 3,
                    ],
                ]
            ],
        ];

        foreach ($menus as $key => $menu) {
            $children = $menu['children'] ?? [];
            unset($menu['children']);

            $menu = Menu::firstOrCreate(['name' => $menu['name'], 'route' => $menu['route']], $menu + ['position' => $key + 1]);
            if ($children) 
                $menu->children()->createMany($children);
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
            } else if ($menu->route !== '#') {
                $permissions[] = [
                    'name' => $menu->route,
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        $permissions = Permission::insert($permissions);
        $roles = [
            ['name' => 'root'],
            ['name' => 'admin'],
        ];

        $permissions = Permission::where('name', 'not like', '%access%')
        ->get();

        foreach ($roles as $role) {
            $role = Role::create($role);

            if ($role->name == 'admin') {
                $role->syncPermissions($permissions->pluck('name'));
                $role->menus()->sync($menus->filter(fn ($menu) => !str_contains($menu->route, 'access'))->pluck('id'));
            }
        }

        $users = [
            [['name' => 'Root', 'email' => 'root@example.com', 'password' => bcrypt('root')], ['root']],
            [['name' => 'Admin', 'email' => 'admin@example.com', 'password' => bcrypt('admin')], ['admin']],
        ];

        foreach ($users as $user) {
            $newUser = User::create($user[0]);
            $newUser->assignRole($user[1]);
        }
    }
}
