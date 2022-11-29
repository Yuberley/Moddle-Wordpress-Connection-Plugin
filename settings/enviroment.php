<?php

function getWoocommerceKey(){
    $key = [
        "public" => "ck_8f0eab38e14f05e4a1df2a78d0dc00876042a326",
        "private" => "cs_370e922e21733e78a06e0ca55a8e4fb5177c1b3f",
   
    ];
    return $key;
}

function getWoocommerceUrl(){
    $url = "http://179.32.53.160/primedigital/";
    return $url;
}

function getMoodleToken(){
    $key = "ffdbb4a4f4102cf554cd040dd2ecde94";
    return $key;
}

function getMoodleUrl(){
    $url = "http://179.32.53.160/moodle/webservice/rest/server.php?wstoken=".getMoodleToken()."&moodlewsrestformat=json";
    return $url;
}

function getMoodleCategoryId(){
    $category = [
        "basic" => 2,
        "premium" => 3,
    ];
    return $category;
}

function getMoodle(){
    $moodle = new \GuzzleHttp\Client([
        'base_uri' => 'http://179.32.53.160/moodle/',
    ]);
    return $moodle;
}

