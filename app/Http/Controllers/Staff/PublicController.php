<?php

namespace App\Http\Controllers\Staff;

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
}
