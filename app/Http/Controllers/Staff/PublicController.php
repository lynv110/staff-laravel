<?php

namespace App\Http\Controllers\Staff;

use App\Facades\Export;
use App\Facades\Staff;
use App\Http\Controllers\Controller;
use App\Models\PartModel;
use App\Models\PositionModel;
use App\Models\PublicModel;
use App\Models\StaffModel;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Request;

class PublicController extends Controller {
    private $positionModel;
    private $partModel;
    private $staffModel;
    private $publicModel;

    public function __construct(PositionModel $positionModel, PartModel $partModel, StaffModel $staffModel, PublicModel $publicModel) {
        $this->positionModel = $positionModel;
        $this->partModel = $partModel;
        $this->staffModel = $staffModel;
        $this->publicModel = $publicModel;
    }

    public function index() {
        $filterName = Request::get('filter_name') ? Request::get('filter_name') : '';


        $filter = [
            'filter_name' => $filterName,
        ];

        $staffs = $this->publicModel->getList($filter);

        $url = url('staff-list');
        if ($filterName) {
            $url .= '?filter&filter_name=' . $filterName;
        }

        // Get information of my self and compare
        $thisPartIds = [];
        $thisPositionPmss = [];

        $thisPartIdTmps = $this->staffModel->getIdPartByStaff(Staff::getId());
        $thisPositionPmsTmps = $this->staffModel->getPermissionPositionByStaff(Staff::getId());

        foreach ($thisPartIdTmps as $thisPositionIdTmp) {
            $thisPartIds[] = $thisPositionIdTmp->part_id;
        }

        foreach ($thisPositionPmsTmps as $thisPositionPmsTmp) {
            $thisPositionPmss[] = $thisPositionPmsTmp->sort_permission;
        }

        $data['staffTmps'] = [];
        foreach ($staffs as $staff) {
            // Get information of $staff->id and compare
            $partViewInfo = false;
            $positionViewInfo = false;

            $partIdTmps = $this->staffModel->getIdPartByStaff($staff->id);
            $positionPmsTmps = $this->staffModel->getPermissionPositionByStaff($staff->id);

            foreach ($partIdTmps as $partIdTmp) {
                if (in_array($partIdTmp->part_id, $thisPartIds)) {
                    $partViewInfo = true;
                    break;
                }
            }

            $positionPmsArrayTmps = [];
            foreach ($positionPmsTmps as $positionPmsTmp) {
                $positionPmsArrayTmps[] = $positionPmsTmp->sort_permission;
            }

            if ($thisPositionPmss && $positionPmsArrayTmps && (min($thisPositionPmss) < min($positionPmsArrayTmps))) {
                $positionViewInfo = true;
            }

            if ($partViewInfo) {
                $data['staffTmps'][] = [
                    'id' => $staff->id,
                    'name' => $staff->name,
                    'info' => ($partViewInfo && $positionViewInfo) || (Staff::getId() == $staff->id),
                ];
            }
        }

        $collection = collect($data['staffTmps']);

        $data['count_staff'] = count($collection);

        $data['staffs'] = $this->paginate($collection, config('main.limit'));
        $data['staffs']->setPath($url);

        $data['filter_name'] = $filterName;

        return view('staff.public_list', $data);
    }

    /**
     * @param array|Collection      $items
     * @param int   $perPage
     * @param int  $page
     * @param array $options
     *
     * @return LengthAwarePaginator
     */
    protected function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function export() {

        if (Request::input('id')) {
            $staffs = $this->publicModel->getListWhereIn('id', Request::input('id'));

            // Get information of my self and compare
            $thisPartIds = [];
            $thisPositionPmss = [];

            $thisPartIdTmps = $this->staffModel->getIdPartByStaff(Staff::getId());
            $thisPositionPmsTmps = $this->staffModel->getPermissionPositionByStaff(Staff::getId());

            foreach ($thisPartIdTmps as $thisPositionIdTmp) {
                $thisPartIds[] = $thisPositionIdTmp->part_id;
            }

            foreach ($thisPositionPmsTmps as $thisPositionPmsTmp) {
                $thisPositionPmss[] = $thisPositionPmsTmp->sort_permission;
            }

            $lists = [];
            $row = 1;
            foreach ($staffs as $staff) {
                // Get information of $staff->id and compare
                $partViewInfo = false;
                $positionViewInfo = false;

                $partIdTmps = $this->staffModel->getIdPartByStaff($staff->id);
                $positionPmsTmps = $this->staffModel->getPermissionPositionByStaff($staff->id);

                foreach ($partIdTmps as $partIdTmp) {
                    if (in_array($partIdTmp->part_id, $thisPartIds)) {
                        $partViewInfo = true;
                        break;
                    }
                }

                $positionPmsArrayTmps = [];
                foreach ($positionPmsTmps as $positionPmsTmp) {
                    $positionPmsArrayTmps[] = $positionPmsTmp->sort_permission;
                }

                if ($thisPositionPmss && $positionPmsArrayTmps && (min($thisPositionPmss) < min($positionPmsArrayTmps))) {
                    $positionViewInfo = true;
                }

                if ($partViewInfo) {
                    if ($staff->gender == 0) {
                        $gender = trans('main.text_male');
                    } elseif ($staff->gender == 1) {
                        $gender = trans('main.text_female');
                    } else {
                        $gender = trans('main.text_other');
                    }
                    $lists[] = [
                        'a' => $row,
                        'b' => $staff->name,
                        'c' => ($partViewInfo && $positionViewInfo) || (Staff::getId() == $staff->id) ? $staff->telephone : '',
                        'd' => ($partViewInfo && $positionViewInfo) || (Staff::getId() == $staff->id) ? $staff->address : '',
                        'e' => ($partViewInfo && $positionViewInfo) || (Staff::getId() == $staff->id) ? $gender : '',
                        'f' => ($partViewInfo && $positionViewInfo) || (Staff::getId() == $staff->id) ? $staff->email : '',
                        'g' => ($partViewInfo && $positionViewInfo) || (Staff::getId() == $staff->id) ? $staff->username : '',
                        'h' => ($partViewInfo && $positionViewInfo) || (Staff::getId() == $staff->id) ? date_to_list($staff->birthday) : '',
                    ];
                    $row++;
                }
            }

            $arrayInfo = [
                'title' => trans('main.export_title'),
                'subject' => trans('main.export_title'),
                'file_name' => 'staff-list',
                'column' => [
                    'a' => trans('main.export_column_a'),
                    'b' => trans('main.export_column_b'),
                    'c' => trans('main.export_column_c'),
                    'd' => trans('main.export_column_d'),
                    'e' => trans('main.export_column_e'),
                    'f' => trans('main.export_column_f'),
                    'g' => trans('main.export_column_g'),
                    'h' => trans('main.export_column_h'),
                ],
                'info' => $lists
            ];

            Export::export($arrayInfo);

        } else {

            $staffs = $this->publicModel->getList();
            // Get information of my self and compare
            $thisPartIds = [];
            $thisPositionPmss = [];

            $thisPartIdTmps = $this->staffModel->getIdPartByStaff(Staff::getId());
            $thisPositionPmsTmps = $this->staffModel->getPermissionPositionByStaff(Staff::getId());

            foreach ($thisPartIdTmps as $thisPositionIdTmp) {
                $thisPartIds[] = $thisPositionIdTmp->part_id;
            }

            foreach ($thisPositionPmsTmps as $thisPositionPmsTmp) {
                $thisPositionPmss[] = $thisPositionPmsTmp->sort_permission;
            }

            $lists = [];
            $row = 1;
            foreach ($staffs as $staff) {
                // Get information of $staff->id and compare
                $partViewInfo = false;
                $positionViewInfo = false;

                $partIdTmps = $this->staffModel->getIdPartByStaff($staff->id);
                $positionPmsTmps = $this->staffModel->getPermissionPositionByStaff($staff->id);

                foreach ($partIdTmps as $partIdTmp) {
                    if (in_array($partIdTmp->part_id, $thisPartIds)) {
                        $partViewInfo = true;
                        break;
                    }
                }

                $positionPmsArrayTmps = [];
                foreach ($positionPmsTmps as $positionPmsTmp) {
                    $positionPmsArrayTmps[] = $positionPmsTmp->sort_permission;
                }

                if ($thisPositionPmss && $positionPmsArrayTmps && (min($thisPositionPmss) < min($positionPmsArrayTmps))) {
                    $positionViewInfo = true;
                }

                if ($partViewInfo) {
                    if ($staff->gender == 0) {
                        $gender = trans('main.text_male');
                    } elseif ($staff->gender == 1) {
                        $gender = trans('main.text_female');
                    } else {
                        $gender = trans('main.text_other');
                    }
                    $lists[] = [
                        'a' => $row,
                        'b' => $staff->name,
                        'c' => ($partViewInfo && $positionViewInfo) || (Staff::getId() == $staff->id) ? $staff->telephone : '',
                        'd' => ($partViewInfo && $positionViewInfo) || (Staff::getId() == $staff->id) ? $staff->address : '',
                        'e' => ($partViewInfo && $positionViewInfo) || (Staff::getId() == $staff->id) ? $gender : '',
                        'f' => ($partViewInfo && $positionViewInfo) || (Staff::getId() == $staff->id) ? $staff->email : '',
                        'g' => ($partViewInfo && $positionViewInfo) || (Staff::getId() == $staff->id) ? $staff->username : '',
                        'h' => ($partViewInfo && $positionViewInfo) || (Staff::getId() == $staff->id) ? date_to_list($staff->birthday) : '',
                    ];
                    $row++;
                }
            }

            $arrayInfo = [
                'title' => trans('main.export_title'),
                'subject' => trans('main.export_title'),
                'file_name' => 'staff-list',
                'column' => [
                    'a' => trans('main.export_column_a'),
                    'b' => trans('main.export_column_b'),
                    'c' => trans('main.export_column_c'),
                    'd' => trans('main.export_column_d'),
                    'e' => trans('main.export_column_e'),
                    'f' => trans('main.export_column_f'),
                    'g' => trans('main.export_column_g'),
                    'h' => trans('main.export_column_h'),
                ],
                'info' => $lists
            ];

            Export::export($arrayInfo);
        }

        return redirect('staff-list');
    }
}
