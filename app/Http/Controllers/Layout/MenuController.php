<?php

namespace App\Http\Controllers\Layout;

use App\Facades\Staff;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class MenuController extends Controller {
    public function compose(View $view) {
        $navMenu = $this->navMenu();
        $view->with('menus', $navMenu);
    }

    protected function navMenu() {
        $menus = [];
        if (Staff::isRoot()) {
            // staff
            $menus[] = [
                'name' => trans('menu.text_staff'),
                'icon' => 'fa fa-dot-circle-o',
                'href' => url('staff'),
                'total' => DB::table('staff')->count() - 1,
            ];

            // position
            $menus[] = [
                'name' => trans('menu.text_position'),
                'icon' => 'fa fa-dot-circle-o',
                'href' => url('position'),
                'total' => DB::table('position')->count(),
            ];

            //part
            $menus[] = [
                'name' => trans('menu.text_part'),
                'icon' => 'fa fa-dot-circle-o',
                'href' => url('part '),
                'total' => DB::table('part')->count(),
            ];

            // profile
            $menus[] = [
                'name' => trans('menu.text_profile'),
                'icon' => 'fa fa-dot-circle-o',
                'href' => url('profile ')
            ];
        } else {
            // staff
            $menus[] = [
                'name' => trans('menu.text_staff_list'),
                'icon' => 'fa fa-dot-circle-o',
                'href' => url('staff')
            ];
        }
        return $menus;
    }
}
