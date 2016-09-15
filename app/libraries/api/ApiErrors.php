<?php

namespace Libraries\Api;

class ApiErrors
{
    static $errors = [
        'noPassword' =>                 ['code' => 101, 'message' => 'No password supplied'],
        'noEmail' =>                    ['code' => 102, 'message' => 'No email address supplied'],
        'invalidUsernamePassword' =>    ['code' => 103, 'message' => 'Invalid username or password'],
        'invalidMethod' =>              ['code' => 104, 'message' => 'Invalid api method'],
        'noData' =>                     ['code' => 105, 'message' => 'No data has been passed'],
        'invalidData' =>                ['code' => 106, 'message' => 'Data structure is invalid'],
        'invalidTable' =>               ['code' => 107, 'message' => 'Table name invalid: '],
    ];
}
