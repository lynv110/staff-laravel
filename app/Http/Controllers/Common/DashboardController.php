<?php

namespace App\Http\Controllers\Common;

use App\Facades\Staff;
use App\Models\PartModel;
use App\Models\PositionModel;
use App\Models\StaffModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    private $staffModel;
    private $partModel;
    private $positionModel;

    public function __construct(StaffModel $staffModel, PartModel $partModel, PositionModel $positionModel) {
        $this->staffModel = $staffModel;
        $this->partModel = $partModel;
        $this->positionModel = $positionModel;
    }

    public function index(){
        $data['total_staff'] = $this->staffModel->getMax();
        $data['total_part'] = $this->partModel->getMax();
        $data['total_position'] = $this->positionModel->getMax();

        $data['latests'] = $this->staffModel->latestLogged();

        $data['info'] = $this->staffModel->getById(Staff::getId());

        $parts = $this->staffModel->getPartByStaff(Staff::getId());
        $data['parts'] = [];
        if ($parts) {
            foreach ($parts as $part) {
                $data['parts'][] = $part->name;
            }
        }

        $positions = $this->staffModel->getPositionByStaff(Staff::getId());
        $data['positions'] = [];
        if ($positions) {
            foreach ($positions as $position) {
                $data['positions'][] = $position->name;
            }
        }

        return view('common.dashboard', $data);
    }
}
