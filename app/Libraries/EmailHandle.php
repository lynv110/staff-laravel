<?php

namespace App\Libraries;

use Illuminate\Support\Facades\Mail;

class EmailHandle
{
    private $nameFrom;
    private $from;
    private $to;
    private $subject;
    private $view;

    public function init($info = ['name_from' => '', 'from' => '', 'to' => '', 'subject' => '', 'view' => '']){
        $this->from = isset($info['from']) && $info['from'] ? $info['from'] : '';
        $this->to = isset($info['to']) && $info['to'] ? $info['to'] : '';
        $this->subject = isset($info['subject']) && $info['subject'] ? $info['subject'] : '';
        $this->view = isset($info['view']) && $info['view'] ? $info['view'] : '';
    }

    public function send($info = []) {
        Mail::send($this->view, $info, function($message) {
            $message->to($this->to, $this->nameFrom)->subject($this->subject);
            $message->from($this->from, $this->nameFrom);
        });
    }
}