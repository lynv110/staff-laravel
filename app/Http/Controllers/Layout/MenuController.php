<?php

namespace App\Http\Controllers\Layout;

use App\Facades\Staff;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class MenuController extends Controller
{
    public function compose(View $view)
    {
        $navMenu = $this->navMenu();
        $view->with('menus', $navMenu);
    }

    protected function navMenu()
    {
        $menus = [];
        if (Staff::isRoot()) {
            // staff
            $menus[] = [
                'name' => trans('menu.txt_staff'),
                'icon' => 'fa fa-dot-circle-o',
                'href' => url('staff')
            ];

            // position
            $menus[] = [
                'name' => trans('menu.txt_position'),
                'icon' => 'fa fa-dot-circle-o',
                'href' => url('position')
            ];

            //part
            $menus[] = [
                'name' => trans('menu.txt_part'),
                'icon' => 'fa fa-dot-circle-o',
                'href' => url('part ')
            ];
        } else {
            // staff
            $menus[] = [
                'name' => trans('menu.txt_staff_list'),
                'icon' => 'fa fa-dot-circle-o',
                'href' => url('staff')
            ];
        }
        return $menus;
    }
}
