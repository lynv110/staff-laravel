<?php

namespace App\Libraries;

use Illuminate\Support\Facades\Mail;

class EmailHandle
{
    public function send($init = [], $info = [], $view) {
        $data = [
            'to' => isset($init['to']) ? $init['to'] : '',
            'from' => isset($init['from']) ? $init['from'] : '',
            'name_to' => isset($init['name_to']) ? $init['name_to'] : '',
            'name_from' => isset($init['name_from']) ? $init['name_from'] : '',
            'subject' => isset($init['subject']) ? $init['subject'] : '',
        ];

        Mail::send($view, $info, function($message) use ($data){
            $message->to($data['to'], $data['name_to'])->subject($data['subject']);
            $message->from($data['from'], $data['name_from']);
        });
    }
}