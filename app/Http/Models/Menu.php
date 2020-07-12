<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menu'; //Database table used by the model

    public function buildMenu($user)
    {
        $menu_parents = self::whereNull('parent_id')->orderBy("weight", 'ASC')->get();
        $result = '<li class="m-menu__section">
								<h4 class="m-menu__section-text">
									Navegación
								</h4>
								<i class="m-menu__section-icon flaticon-more-v3"></i>
							</li>';
        foreach ($menu_parents as $menu_parent) {
            $link = $menu_parent->link;
            $render_item = true;
            if ($link !== '#') {
                $link = url($menu_parent->link);
                $render_item = $user->can('GET ' . $menu_parent->link);
            }

            if ($user->id == 1 || $render_item && $this->isVisibleAllChild($user, $menu_parent->id)) {
                $activeClass = isActiveURL($link) || $this->isActiveChild($menu_parent->id) ? 'm-menu__item--active' : '';
                $sub_menu = $this->buildSubMenu($user, $menu_parent->id);
                $result .= "<li class='m-menu__item m-menu__item--submenu m-menu__item--open {$activeClass}' aria-haspopup='true' data-menu-submenu-toggle='hover'>";
                $result .= "<a href='{$link}' class='m-menu__link m-menu__toggle'>";
                $result .= "{$menu_parent->icon}";
                $result .= "<span class='m-menu__link-text'>{$menu_parent->name}</span>";
                if ($sub_menu != '') {
                    $result .= ' <i class="m-menu__ver-arrow la la-angle-right"></i>';
                }
//                dd($sub_menu);
                $result .= "</a>";
                $result .= $sub_menu;
                $result .= '</li>';
            }
        }
//        $result .= '</ul>';
        return $result;
    }

    public function buildSubMenu($user, $parent_id)
    {
        $actions = self::where('parent_id', '=', $parent_id)->orderBy("weight", 'ASC')->get();

        if (count($actions) == 0)
            return '';

        $result = '<div class="m-menu__submenu" style="display: block;"><span class="m-menu__arrow"></span>';
        $isActiveChild = false;
        $childItems='';
        foreach ($actions as $action) {
            $r = $user->can('GET ' . $action->link);
            if ($user->id == 1 || $r) {
                $link = url($action->link);
                $activeClass = '';
                if (isActiveURL($link)) {
                    $isActiveChild = true;
                    $activeClass = 'm-menu__item--active';
                }
                $childItems .= "<li class='m-menu__item {$activeClass}'>";
                $childItems .= "<a href='{$link}' class='m-menu__link'> ";
                $childItems.='<i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>';
                $childItems .='<span class="m-menu__link-text">'. $action->name.'</span>';
                $childItems .= '</a>';
                $childItems .= '</li>';
            }
        }
        if (count($actions) > 0) {
            $classIn = $isActiveChild ? 'in' : '';
            $result .= "<ul class='m-menu__subnav {$classIn}'>" ;
            $result .= $childItems ;
            $result .= '</ul>';
        }

        $result .= '</div>';
        return $result;
    }

    public function isActiveChild($parent_id)
    {
        $actions = self::where('parent_id', '=', $parent_id)->get();

        if (count($actions) == 0)
            return false;
        foreach ($actions as $action) {
            $link = url($action->link);
            if (isActiveURL($link)) {
                return true;
            }
        }
        return false;
    }

    public function isVisibleAllChild($user, $parent_id)
    {
        $actions = self::where('parent_id', '=', $parent_id)->get();

        if (count($actions) == 0)
            return false;
        foreach ($actions as $action) {
            $r = $user->can('GET ' . $action->link);
            if ($r) {
                return true;
            }
        }
        return false;
    }

}