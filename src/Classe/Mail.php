<?php

namespace App\Classe;

use Mailjet\Client;
use Mailjet\Resources;

class Mail 
{
    private $api_key = '9dc60346899385718dbc8dd8f406feaf';
    private $api_key_secret = '6ae50699a85ef2414a9641bd92cf498a';

    public function send($to_email, $to_name, $subject, $content )
    {
        $mj = new Client($this->api_key, $this->api_key_secret, true,['version' => 'v3.1']);
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "BoucheriePaux@gmail.com",
                        'Name' => "La boucherie Paux"
                    ],
                    'To' => [
                        [
                            'Email' => $to_email,
                            'Name' => $to_name
                        ]
                    ],
                'TemplateID' => 3660720,
                'TemplateLanguage' => true,
                'Subject' => $subject,
                'Variables' => [
                    'content' => $content,
                ]
            ]
        ]
    ];
    $response = $mj->post(Resources::$Email, ['body' => $body]);
    $response->success();

    }
}