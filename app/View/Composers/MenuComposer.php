<?php

namespace App\View\Composers;

use App\Models\RBAC\Menu;
use App\Models\RBAC\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;
use Spatie\Menu\Html;
use Spatie\Menu\Link;
use Spatie\Menu\Menu as SpatieMenu;

class MenuComposer
{
    public function compose(View $view)
    {
        $role = session()->get('current_role') ?? null;
        $menus = session()->get('current_menu');

        if (!$menus) {
            $menus = Menu::with([
                'children' => fn($q) => $q->when($role?->name !== 'root', fn($qw) => $qw->whereHas('roles', fn($qr) => $qr->whereRoleId($role?->id)))
            ])
                ->when($role?->name !== 'root', fn($qw) => $qw->whereHas('roles', fn($qr) => $qr->whereRoleId($role?->id)))
                ->whereNull('menu_id')
                ->orderBy('position', 'asc')
                ->get();

            session()->put('current_menu', $menus);
        }

        $currentRoute = get_current_route_name(false) ?? '#';
        $spatieMenu = SpatieMenu::new()
            ->addClass('main-menu');
        foreach ($menus as $menu) {
            if ($menu->children->isEmpty()) {
                $link = Link::to(
                    Route::has($menu->route) ? route($menu->route) : 'javascript:void(0);',
                    Html::raw("
                        <span class='side-menu__icon'><i class='{$menu->icon_alias}-{$menu->icon_name}'></i></span>
                        <span class='side-menu__label'>{$menu->name}</span>
                    ")->render()
                )
                    ->addClass('side-menu__item')
                    ->addParentClass('slide');

                if (check_current_route_name(remove_route_action($menu->route), remove_route_action($currentRoute))) {
                    $link->setActive();
                }

                $spatieMenu->add($link);
            } else {
                if ($menu->children->count() == 0) continue;
                $subMenu = SpatieMenu::new()->addParentClass('slide has-sub')
                    ->addClass('slide-menu child1');

                foreach ($menu->children as $child) {
                    $link = Link::to(
                        Route::has($child->route) ? route($child->route) : 'javascript:void(0);',
                        $child->name
                    )
                        ->addClass('side-menu__item')
                        ->addParentClass('slide');

                    if (check_current_route_name(remove_route_action($child->route), remove_route_action($currentRoute))) {
                        $subMenu->addParentClass('open')->addClass('active');
                        $link->addClass('active');
                    }

                    $subMenu->add($link);
                }

                $spatieMenu->submenu(
                    Link::to(
                        '#',
                        Html::raw("
                            <span class='side-menu__icon'><i class='{$menu->icon_alias}-{$menu->icon_name}'></i></span>
                            <span class='side-menu__label'>{$menu->name}</span>
                            <i class='ri-arrow-right-s-line side-menu__angle'></i>
                        ")->render()
                    )
                        ->addClass('side-menu__item'),
                    $subMenu
                );
            }
        }

        $view->with('menus', $spatieMenu->render());
    }
}
