<?php

require_once plugin_dir_path( __FILE__ ) . '../settings/enviroment.php';

function getWoocommerce(){
    $keyWoocommerce = getWoocommerceKey();
    $woocommerce = new \Automattic\WooCommerce\Client(
        getWoocommerceUrl(),
        $keyWoocommerce["public"],
        $keyWoocommerce["private"],
        [
            'wp_api' => true,
            'version' => 'wc/v3',
            'query_string_auth' => true
            ]
        );
    return $woocommerce;
}

function getMoodle(){
    $moodle = new \GuzzleHttp\Client([
        'base_uri' => 'http://179.32.53.160/moodle/',
    ]);
    return $moodle;
}

// function getMoodleTokenTest(){
//     $moodle = getMoodle();
//     $response = $moodle->request('POST', 'login/token.php', [
//         'form_params' => [
//             'username' => 'admin',
//             'password' => 'Cuenta123*',
//             'service' => 'moodle_mobile_app',
//         ]
//     ]);
//     $token = json_decode($response->getBody()->getContents());
//     return $token->token;
// }

function getMoodleUser($id){
    $moodle = getMoodle();
    $response = $moodle->request('GET', '/webservice/rest/server.php', [
        'query' => [
            'wstoken' => getMoodleToken(),
            'moodlewsrestformat' => 'json',
            'wsfunction' => 'core_user_get_users',
            'criteria[0][key]' => 'id',
            'criteria[0][value]' => $id,
        ]
    ]);
    $user = json_decode($response->getBody()->getContents());
    return $user;
}

function getMoodleUserByUsername($username){
    $moodle = getMoodle();
    $response = $moodle->request('GET', 'webservice/rest/server.php', [
        'query' => [
            'wstoken' => getMoodleToken(),
            'moodlewsrestformat' => 'json',
            'wsfunction' => 'core_user_get_users',
            'criteria[0][key]' => 'username',
            'criteria[0][value]' => $username,
        ]
    ]);
    $user = json_decode($response->getBody()->getContents());
    return $user;
}

function getMoodleUserByEmail($email){
    $moodle = getMoodle();
    $response = $moodle->request('GET', 'webservice/rest/server.php', [
        'query' => [
            'wstoken' => getMoodleToken(),
            'moodlewsrestformat' => 'json',
            'wsfunction' => 'core_user_get_users',
            'criteria[0][key]' => 'email',
            'criteria[0][value]' => $email,
        ]
    ]);
    $user = json_decode($response->getBody()->getContents());
    return $user;
}

function createMoodleUser($user){
    $moodle = getMoodle();
    $response = $moodle->request('POST', 'webservice/rest/server.php', [
        'form_params' => [
            'wstoken' => getMoodleToken(),
            'moodlewsrestformat' => 'json',
            'wsfunction' => 'core_user_create_users',
            'users[0][username]' => $user->username,
            'users[0][createpassword]' => 1,
            'users[0][firstname]' => $user->firstname,
            'users[0][lastname]' => $user->lastname,
            'users[0][email]' => $user->email,
            'users[0][city]' => $user->city,
            'users[0][country]' => $user->country,
            'users[0][customfields][0][value]' => $user->document,
            'users[0][customfields][0][type]' => $user->customfield,
        ]
    ]);
    $user = json_decode($response->getBody()->getContents());
    return $user;
}

function updateMoodleUser($id, $data){
    $moodle = getMoodle();
    $response = $moodle->request('POST', 'webservice/rest/server.php', [
        'form_params' => [
            'wstoken' => getMoodleToken(),
            'moodlewsrestformat' => 'json',
            'wsfunction' => 'core_user_update_users',
            'users[0][id]' => $id,
            'users[0][username]' => $data->username,
            'users[0][firstname]' => $data->firstname,
            'users[0][lastname]' => $data->lastname,
            'users[0][email]' => $data->email,
            'users[0][city]' => $data->city,
            'users[0][country]' => $data->country,
            'users[0][customfields][0][value]' => $data->document,
            'users[0][customfields][0][type]' => $data->customfield,
        ]
    ]);
    $user = json_decode($response->getBody()->getContents());
    return $user;
}

function deleteMoodleUser($id){
    $moodle = getMoodle();
    $response = $moodle->request('POST', 'webservice/rest/server.php', [
        'form_params' => [
            'wstoken' => getMoodleToken(),
            'moodlewsrestformat' => 'json',
            'wsfunction' => 'core_user_delete_users',
            'userids[0]' => $id,
        ]
    ]);
    $user = json_decode($response->getBody()->getContents());
    return $user;
}














function getMoodleUsersByField($field, $values){
    $queryValues = [];
    foreach($values as $key => $val){
        $queryValues['values['.$key.']'] = $val->$field;
    }
    
    $moodle = getMoodle();
    $response = $moodle->request('GET', 'webservice/rest/server.php', [
        'query' => [
            'wstoken' => getMoodleToken(),
            'moodlewsrestformat' => 'json',
            'wsfunction' => 'core_user_get_users_by_field',
            'field' => $field,
        ] + $queryValues
    ]);
    $users = json_decode($response->getBody()->getContents());
    return $users;
}


function getMoodleUserByField($field, $value){
    $moodle = getMoodle();
    $response = $moodle->request('GET', 'webservice/rest/server.php', [
        'query' => [
            'wstoken' => getMoodleToken(),
            'moodlewsrestformat' => 'json',
            'wsfunction' => 'core_user_get_users',
            'criteria[0][key]' => $field,
            'criteria[0][value]' => $value,
        ]
    ]);
    $user = json_decode($response->getBody()->getContents());
    return $user;
}


function getMoodleUserCourses($id){
    $moodle = getMoodle();
    $response = $moodle->request('GET', 'webservice/rest/server.php', [
        'query' => [
            'wstoken' => getMoodleToken(),
            'moodlewsrestformat' => 'json',
            'wsfunction' => 'core_enrol_get_users_courses',
            'userid' => $id,
        ]
    ]);
    $courses = json_decode($response->getBody()->getContents());
    return $courses;
}

function getMoodleCourse($id){
    $moodle = getMoodle();
    $response = $moodle->request('GET', 'webservice/rest/server.php', [
        'query' => [
            'wstoken' => getMoodleToken(),
            'moodlewsrestformat' => 'json',
            'wsfunction' => 'core_course_get_courses',
            'options[ids][0]' => $id,
        ]
    ]);
    $course = json_decode($response->getBody()->getContents());
    return $course;
}

function getMoodleCourseByField($field, $value){
    $moodle = getMoodle();
    $response = $moodle->request('GET', 'webservice/rest/server.php', [
        'query' => [
            'wstoken' => getMoodleToken(),
            'moodlewsrestformat' => 'json',
            'wsfunction' => 'core_course_get_courses',
            'options['.$field.']' => $value,
        ]
    ]);
    $course = json_decode($response->getBody()->getContents());
    return $course;
}

function getMoodleCourseByFieldArray($field, $value){
    $moodle = getMoodle();
    $response = $moodle->request('GET', 'webservice/rest/server.php', [
        'query' => [
            'wstoken' => getMoodleToken(),
            'moodlewsrestformat' => 'json',
            'wsfunction' => 'core_course_get_courses',
            'options['.$field.'][]' => $value,
        ]
    ]);
    $course = json_decode($response->getBody()->getContents());
    return $course;
}