<?php

spl_autoload_register(function ($classname) {
    $dirs = array (
		'./Classes/',
    );

    foreach ($dirs as $dir) {
        $filename = $dir . str_replace('\\', '/', $classname) .'.php';
        if (file_exists($filename)) {
            require_once $filename;
            break;
        }
    }
 
});

class App {
    public static $twig ;
    public static AltoRouter $router;
    public static $debug;
    public static $message = [];
    public static $appName = "";


    static function init(string $appName, bool $debug){
        self::$debug = $debug;
        self::$appName = $appName;
        if ($debug){
            self::debug();
        }
        if (isset($_SESSION['message'])){
            self::$message = $_SESSION['message'];
            unset($_SESSION['message']);
        }
        self::$router = new AltoRouter();
        self::$router->addRoutes(array(
            array('GET','/images/[**:fname]', 'App::load_image', 'app_load_image'),
            array('GET','/documents/[**:fname]', 'App::load_document', 'app_load_document'),
        ));

        include 'router.php';

        $loader = new \Twig\Loader\FilesystemLoader('templates');
        self::$twig = new \Twig\Environment($loader, [
            'cache' => '../twig_cache', 
            'debug' => true,
        ]);
        self::$twig->addExtension(new \Twig\Extension\DebugExtension());
        self::$twig->addExtension(new CustomTwigExtension());

    }

    private static function debug(){
        ini_set('display_errors', '1');
        error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
        ini_set('xdebug.overload_var_dump','2');
        ini_set('xdebug.var_display_max_children','128');
        ini_set('xdebug.var_display_max_data','2048');
        ini_set('xdebug.var_display_max_depth','10');
        ini_set('xdebug.collect_includes','1');  //   ; Noms de fichiers
        ini_set('xdebug.collect_params','2');    //   ; Paramètres de fonctions / méthodes
        ini_set('xdebug.show_exception_trace','0');    
    }

    static function render(string $template, array $variables = []){
        self::$twig->addGlobal('App', [
            'appName' => App::$appName,
            'msg' => App::$message,
        ]);
        return self::$twig->render($template, $variables);
    }

    public static function doRoute(){
        $match = App::$router->match();
          
          // call closure or throw 404 status
        $isMatch = is_array($match);
        $isCallable = is_callable( $match['target']??'' );
        if( $isMatch && $isCallable ) {
            call_user_func_array( $match['target'], $match['params'] );
        } else {
            header( $_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
            var_dump("Pas trouvé...");
            //uo(); // O.C.
        }
    }

    public static function load_image($fname){
        $mimeList =[
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpe' => 'image/jpeg',
            'jif' => 'image/jpeg',
            'jfif' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'svg' => 'image/svg+xml',
            'webp' => 'image/webp',
            'avif' => 'image/avif',
            'apng' => 'image/apng',
            'otf' => 'application/x-font-opentype',
        ];
        $fname = urldecode($fname);

        $pi = pathinfo($fname);
        $ext=strtolower( $pi['extension']??'');
        $mime = $mimeList[$ext] ?? 'image/jpeg';
        header("Content-type: {$mime}");
        readfile("Images/{$fname}");
    }


    public static function load_document($fname){
        $mimeList =[
            'aac' => 'audio/aac',
            'abw' => 'application/x-abiword',
            'arc' => 'application/octet-stream',
            'avi' => 'video/x-msvideo',
            'azw' => 'application/vnd.amazon.ebook',
            'bin' => 'application/octet-stream',
            'bmp' => 'image/bmp',
            'bz' => 'application/x-bzip',
            'bz2' => 'application/x-bzip2',
            'csh' => 'application/x-csh',
            'css' => 'text/css',
            'csv' => 'text/csv',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'eot' => 'application/vnd.ms-fontobject',
            'epub' => 'application/epub+zip',
            'gif' => 'image/gif',
            'htm' => 'text/html',
            'html' => 'text/html',
            'ico' => 'image/x-icon',
            'ics' => 'text/calendar',
            'jar' => 'application/java-archive',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'js' => 'application/javascript',
            'json' => 'application/json',
            'mid' => 'audio/midi',
            'midi' => 'audio/midi',
            'mpeg' => 'video/mpeg',
            'mpkg' => 'application/vnd.apple.installer+xml',
            'odp' => 'application/vnd.oasis.opendocument.presentation',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
            'odt' => 'application/vnd.oasis.opendocument.text',
            'oga' => 'audio/ogg',
            'ogv' => 'video/ogg',
            'ogx' => 'application/ogg',
            'otf' => 'font/otf',
            'png' => 'image/png',
            'pdf' => 'application/pdf',
            'ppt' => 'application/vnd.ms-powerpoint',
            'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'rar' => 'application/x-rar-compressed',
            'rtf' => 'application/rtf',
            'sh' => 'application/x-sh',
            'svg' => 'image/svg+xml',
            'swf' => 'application/x-shockwave-flash',
            'tar' => 'application/x-tar',
            'tif' => 'image/tiff',
            'tiff' => 'image/tiff',
            'ts' => 'application/typescript',
            'ttf' => 'font/ttf',
            'vsd' => 'application/vnd.visio',
            'wav' => 'audio/x-wav',
            'weba' => 'audio/webm',
            'webm' => 'video/webm',
            'webp' => 'image/webp',
            'woff' => 'font/woff',
            'woff2' => 'font/woff2',
            'xhtml' => 'application/xhtml+xml',
            'xls' => 'application/vnd.ms-excel',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'xml' => 'application/xml',
            'xul' => 'application/vnd.mozilla.xul+xml',
            'zip' => 'application/zip',
            '3gp' => 'video/3gpp',
            '3g2' => 'video/3gpp2',
            '7z' => 'application/x-7z-compressed',
        ];

        $pi = pathinfo($fname);
        $ext=strtolower( $pi['extension']??'');
        $mime = $mimeList[$ext] ?? 'image/jpeg';
        header("Content-type: {$mime}");
        readfile("Documents/{$fname}");
    }

}