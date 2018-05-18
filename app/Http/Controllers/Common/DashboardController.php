<?php

namespace App\Http\Controllers\Common;

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

        return view('common.dashboard', $data);
    }
}
