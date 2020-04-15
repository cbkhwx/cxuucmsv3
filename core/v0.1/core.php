<?php
use z\debug;
use z\router;
use z\z;
function AppRun($entry)
{
    error_reporting(E_ALL);
    ini_set('date.timezone', 'Asia/Shanghai');
    define('TIME', $_SERVER['REQUEST_TIME']);
    define('MTIME', microtime(true));
    define('ZPHP_VER', '4.0.1');
    define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 'xmlhttprequest' === strtolower($_SERVER['HTTP_X_REQUESTED_WITH']));
    define('IS_WX', false !== strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger'));
    define('METHOD', $_SERVER['REQUEST_METHOD']);
    define('P_IN', str_replace('\\', '/', dirname($entry)) . '/');
    define('P_CORE', str_replace('\\', '/', dirname(__FILE__) . '/'));
    define('P_ROOT', dirname(dirname(P_CORE)) . '/');
    define('P_TMP', P_ROOT . 'tmp/');
    define('P_BASE', P_ROOT . 'base/');
    define('P_LOG', P_ROOT . 'tmp/log/');
    define('P_RUN', P_ROOT . 'tmp/run/');
    define('P_HTML', P_ROOT . 'tmp/html/');
    define('P_CACHE', P_ROOT . 'tmp/cache/');
    define('P_APP', P_ROOT . 'app/' . APP_NAME . '/');
    define('P_COMMON', P_ROOT . 'common/');
    define('LEN_IN', strlen(P_IN));
    define('P_PUBLIC', P_IN === P_ROOT ? P_IN . 'public/' : P_IN);
    define('P_RES', P_PUBLIC . 'res/');

    $GLOBALS['ZPHP_MAPPING'] = [
        'z' => P_CORE . 'z/',
        'ext' => P_CORE . 'ext/',
        'root' => P_ROOT,
        'libs' => P_ROOT . 'libs/',
        'common' => P_COMMON,
    ];
    require P_CORE . 'z/z.class.php';
    set_exception_handler('\z\debug::exceptionHandler');
    spl_autoload_register('\z\z::AutoLoad');
    router::init();
    if ($GLOBALS['ZPHP_CONFIG']['DEBUG'] ?? $GLOBALS['ZPHP_CONFIG']['DEBUG'] = 1) {
        ini_set('display_errors', 'On');
        set_error_handler('\z\debug::errorHandler');
        ini_set('expose_php', 'Off');
    } else {
        ini_set('display_errors', 'Off');
        ini_set('expose_php', 'Off');
    }
    z::start();
}
function Zautoload(string $act)
{
    $GLOBALS['ZPHP_AUTOLOAD'] = $act;
}
function Debug(int $i, $msg = '')
{
    $GLOBALS['ZPHP_CONFIG']['DEBUG'] = $i;
    $msg && $GLOBALS['ZPHP_CONFIG']['DEBUG_MSG'] = $msg;
}
function IsFullPath(string $path): bool
{
    return 0 === stripos(PHP_OS, 'WIN') ? ':' === $path[1] : '/' === $path[0];
}
function SetConfig(string $key, $value)
{
    if (isset($GLOBALS['ZPHP_CONFIG'][$key]) && is_array($value)) {
        $GLOBALS['ZPHP_CONFIG'][$key] = $value + $GLOBALS['ZPHP_CONFIG'][$key];
    } else {
        $GLOBALS['ZPHP_CONFIG'][$key] = $value;
    }
}
function P($var, bool $echo = true)
{
    ob_start();
    var_dump($var);
    $html = '<pre>' . preg_replace('/\]\=\>\n(\s+)/m', '] =>', htmlspecialchars_decode(ob_get_clean())) . '</pre>';
    if ($echo) {
        echo $html;
    } else {
        return $html;
    }
}
function FileSizeFormat(int $size = 0, int $dec = 2): string
{
    $unit = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];
    $pos = 0;
    while ($size >= 1024) {
        $size /= 1024;
        ++$pos;
    }
    return round($size, $dec) . $unit[$pos];
}
function TransCode($str)
{
    $encode = mb_detect_encoding($str, ['ASCII', 'UTF-8', 'GB2312', 'GBK', 'BIG5', 'EUC-CN']);
    return 'UTF-8' === $encode ? $str : mb_convert_encoding($str, 'UTF-8', $encode);
}
function make_dir($dir, $mode = 0755, $recursive = true)
{
    if (!file_exists($dir) && !mkdir(iconv('UTF-8', 'GBK', $dir), $mode, $recursive)) {
        throw new Error("创建目录{$dir}失败,请检查权限");
    }
    return true;
}
