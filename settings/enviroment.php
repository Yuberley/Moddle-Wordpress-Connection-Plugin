<?php

function getWoocommerceKey(){
    $key = [
        "public" => "your public key woocommerce",
        "private" => "your private key woocommerce",
   
    ];
    return $key;
}

function getWoocommerceUrl(){
    $url = "your  wordpress /";
    return $url;
}

function getMoodleToken(){
    $key = "your token moodle";
    return $key;
}

function getMoodleUrl(){
    $url = "your url moodle /webservice/rest/server.php?wstoken=".getMoodleToken()."&moodlewsrestformat=json";
    return $url;
}

function getMoodleCategoryId(){
    $category = [
        "basic" => "your category id basic",
        "premium" => "your category id premium",
    ];
    return $category;
}

function getMoodle(){
    $moodle = new \GuzzleHttp\Client([
        'base_uri' => 'your url moodle /',
    ]);
    return $moodle;
}

