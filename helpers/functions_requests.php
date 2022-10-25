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
        'timeout'  => 2.0,
    ]);
    return $moodle;
}

function getMoodleToken(){
    $moodle = getMoodle();
    $response = $moodle->request('POST', 'login/token.php', [
        'form_params' => [
            'username' => 'admin',
            'password' => 'Cuenta123*',
            'service' => 'moodle_mobile_app',
        ]
    ]);
    $token = json_decode($response->getBody()->getContents());
    return $token->token;
}

function getMoodleUser($id){
    $moodle = getMoodle();
    $response = $moodle->request('GET', '/webservice/rest/server.php', [
        'query' => [
            'wstoken' => getMoodleToken(),
            'wsfunction' => 'core_user_get_users',
            'criteria[0][key]' => 'id',
            'criteria[0][value]' => $id,
        ]
    ]);
    $user = json_decode($response->getBody()->getContents());
    return $user;
}

function getMoodleUserByEmail($email){
    $moodle = getMoodle();
    $response = $moodle->request('GET', 'webservice/rest/server.php', [
        'query' => [
            'wstoken' => 'ffdbb4a4f4102cf554cd040dd2ecde94',
            'wsfunction' => 'core_user_get_users_by_field',
            'field' => 'username',
            'values[0]' => 'saitama',
            'moodlewsrestformat' => 'json',
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
            'wsfunction' => 'core_user_get_users',
            'criteria[0][key]' => 'username',
            'criteria[0][value]' => $username,
        ]
    ]);
    $user = json_decode($response->getBody()->getContents());
    return $user;
}


function getMoodleUserByField($field, $value){
    $moodle = getMoodle();
    $response = $moodle->request('GET', '/webservice/rest/server.php', [
        'query' => [
            'wstoken' => getMoodleToken(),
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
    $response = $moodle->request('GET', '/webservice/rest/server.php', [
        'query' => [
            'wstoken' => getMoodleToken(),
            'wsfunction' => 'core_enrol_get_users_courses',
            'userid' => $id,
        ]
    ]);
    $courses = json_decode($response->getBody()->getContents());
    return $courses;
}

function getMoodleCourse($id){
    $moodle = getMoodle();
    $response = $moodle->request('GET', '/webservice/rest/server.php', [
        'query' => [
            'wstoken' => getMoodleToken(),
            'wsfunction' => 'core_course_get_courses',
            'options[ids][0]' => $id,
        ]
    ]);
    $course = json_decode($response->getBody()->getContents());
    return $course;
}

function getMoodleCourseByField($field, $value){
    $moodle = getMoodle();
    $response = $moodle->request('GET', '/webservice/rest/server.php', [
        'query' => [
            'wstoken' => getMoodleToken(),
            'wsfunction' => 'core_course_get_courses',
            'options['.$field.']' => $value,
        ]
    ]);
    $course = json_decode($response->getBody()->getContents());
    return $course;
}

function getMoodleCourseByFieldArray($field, $value){
    $moodle = getMoodle();
    $response = $moodle->request('GET', '/webservice/rest/server.php', [
        'query' => [
            'wstoken' => getMoodleToken(),
            'wsfunction' => 'core_course_get_courses',
            'options['.$field.'][]' => $value,
        ]
    ]);
    $course = json_decode($response->getBody()->getContents());
    return $course;
}