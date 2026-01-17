<?php

class CustomTwigExtension extends \Twig\Extension\AbstractExtension{
    
    
    public function getFunctions(){
        return [
            // new \Twig\TwigFunction('getAuth', [$this, 'getAuth']),
            // new \Twig\TwigFunction('getAuthMail', [$this, 'getAuthMail']),
        ];
    }
    /*
    public function getAuth(){
        return Auth::getAuth();
    }

    public function getAuthMail(){
        return Auth::getAuthMail();
    }
    */
}