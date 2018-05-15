<?php

namespace App\Libraries;

use Illuminate\Support\Facades\Session;

class FlashHandle
{
    public function message($message, $level = 'info', $icon = 'info-circle'){
        session()->flash('flash_notification.message', $message);
        session()->flash('flash_notification.level', $level);
        session()->flash('flash_notification.icon', $icon);
    }

    public function info($message) {
        $this->message($message, 'info', 'info-circle');
    }

    public function success($message) {
        $this->message($message, 'success', 'check-circle');
    }

    public function error($message) {
        $this->message($message, 'danger', 'times-circle');
    }

    public function warning($message) {
        $this->message($message, 'warning', 'exclamation-circle');
    }
}