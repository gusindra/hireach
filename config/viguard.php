<?php

return [

    /*
    |--------------------------------------------------------------------------
    | ViGuard Server List
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'server' => [
        'local-test' => [
            'url' => url('api/sample/server-viguard'),
            'auth' => 'eyJhbG'
        ],
        'aicsp' => [
            'url'=>'http://218.3.11.19:8091/aicsp',
            'auth' => 'eyJhbGciOiJIUzI1NiJ9.eyJqdGkiOiJmM2I4NzhlMS0wNTI4LTQ1YjQtYjM2Yy05MWU1YTkxMDk1NDYiLCJpYXQiOjE3MTY5NDgwNjYsInN1YiI6IntcIlN5c1VzZXJJZFwiOjF9IiwiZXhwIjoxNzE5NTQwMDY2fQ.kHoUPiNrQGahxX3ZeFY50p-P1nQHmPlVUve4Udy7VkE'
        ],
    ],

];
