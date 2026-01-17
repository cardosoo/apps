<?php

class Main{

    static function home(){
        echo App::render("Main/home.html.twig", []);
    }

    static function favicon(){
		App::load_image('icones/favicon.ico');
    }
}