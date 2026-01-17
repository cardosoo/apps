<?php

require __DIR__ . '/../vendor/autoload.php';
include_once("Classes/App.php");

session_start();
App::init("Apps",true);
App::doRoute();

