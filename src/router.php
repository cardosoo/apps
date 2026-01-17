<?php

// pour le site général
App::$router->addRoutes([
    ['GET',      '/',                             'Main::home',                'main_home'],
    ['GET',      '/favicon.ico',                  'Main::favicon',             'main_favicon'],
]);


// pour les tests
App::$router->addRoutes([
    ['GET',      '/test1',                        'Test::test1',                'test_test1'],
    ['GET',      '/test2',                        'Test::test2',                'test_test2'],
    ['GET',      '/test3',                        'Test::test3',                'test_test3'],
    ['GET',      '/test4',                        'Test::test4',                'test_test4'],
    ['GET',      '/test5',                        'Test::test5',                'test_test5'],
]);

