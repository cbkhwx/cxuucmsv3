<?php
namespace z;

use z\cache;
use z\debug;

class pdo
{
    const Z_DB_INDEX_KEY = 'ZPHP-DB-INDEX';
    private static $Z_INSTANCE, $Z_PDO;
    private $Z_KEY, $Z_USED, $Z_CONFIG, $Z_CONNECT, $Z_RINDEX, $Z_USEING, $Z_SQL, $Z_ACT, $Z_CACHE, $Z_PARAMS;
    public static function Init($c = null)
    {
        $c || $c = $GLOBALS['ZPHP_CONFIG']['DB'] ?? null;
        if (!$c) {
            throw new \Exception("没有配置数据库连接参数");
        }

        $key = md5(static::class . serialize($c));
        isset(static::$Z_INSTANCE[$key]) || static::$Z_INSTANCE[$key] = new static($c, $key);
        return static::$Z_INSTANCE[$key];
    }
    private function __construct($c, $key)
    {
        $this->Z_KEY = $key;
        $this->Z_CONFIG = isset($c[0]) ? $c : [$c];
        $num = count($this->Z_CONFIG) - 1;
        if (0 === $num) {
            $this->Z_RINDEX = 0;
        } elseif ($redis = cache::Redis()) {
            $n = $redis->Incr(self::Z_DB_INDEX_KEY);
            $this->Z_RINDEX = 1 + $n % $num;
            2147483646 < $n && $redis->set(self::Z_DB_INDEX_KEY, $this->Z_RINDEX);
        } else {
            $this->Z_RINDEX = mt_rand(1, $num);
        }
    }
    private function zpdoConnect($index = 0, $re = false)
    {
        $c = $this->Z_CONFIG[$index];
        $user = $c['user'] ?? null;
        $pass = $c['pass'] ?? null;
        $key = md5("{$c['dsn']}{$user}{$pass}");
        if ($re || !isset(self::$Z_PDO[$key])) {
            $mtime = microtime(true);
            self::$Z_PDO[$key] = null;
            $config = [
                \PDO::ATTR_TIMEOUT => $c['timeout'] ?? 10,
                \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES ' . ($c['charset'] ?? 'utf8'),
                \PDO::ATTR_EMULATE_PREPARES => false, //是否模拟预处理
                \PDO::ATTR_STRINGIFY_FETCHES => false, //是否将数值转换为字符串
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            ];
            self::$Z_PDO[$key] = new \PDO($c['dsn'], $user, $pass, $config);
            $time = microtime(true) - $mtime;
            debug::pdotime($time);
            debug::ErrorHandler(1120, 'connect ', $c['dsn'], round(1000 * $time, 3) . 'ms');
            $this->Z_USED && in_array($key, $this->Z_USED) || $this->Z_USED[] = $key;
        }
        return self::$Z_PDO[$key];
    }
    public function getKey()
    {
        return $this->Z_KEY;
    }
    public function GetConfig($i = null)
    {
        return isset($i) ? $this->Z_CONFIG[$i] : $this->Z_CONFIG[$this->Z_RINDEX];
    }
    /**
     * 建立一个连接（获取一个pdo的实例）
     */
    public function Con($i = 0, $re = false)
    {
        switch ($i) {
            case 'r':
                $index = $this->Z_RINDEX;
                break;
            case 'w':
                $index = 0;
                break;
            default:
                $index = (int) $i;
        }
        $re || !isset($this->Z_CONNECT[$index]) && $this->Z_CONNECT[$index] = $this->zpdoConnect($index, $re);
        return $this->Z_CONNECT[$index];
    }
    public function Cache($expire = null)
    {
        $this->Z_CACHE = $expire ?? $this->Z_CONFIG[0]['cache_time'] ?? 600;
        return $this;
    }
    public function getCached()
    {
        return $this->Z_CACHE;
    }
    public function setCache($ckey, $data)
    {
        $timeout = abs($this->Z_CACHE);
        switch ($this->Z_CONFIG[0]['cache_mod'] ?? 0) {
            case 1:
                return cache::R($ckey, $data, $timeout, 2);
            case 2:
                return cache::M($ckey, $data, $timeout, 2);
            default:
                return cache::F($ckey, $data, $timeout, 2);
        }
    }
    public function getCache($ckey)
    {
        switch ($this->Z_CONFIG[0]['cache_mod'] ?? 0) {
            case 1:
                return cache::R($ckey);
            case 2:
                return cache::M($ckey);
            default:
                return cache::F($ckey);
        }
    }
    private function Z_getTable($sql = '')
    {
        preg_match('/(UPDATE|FROM|INTO|DESC|TABLE|TABLE_INFO)\s+(\S+)/i', $sql ?: $this->Z_SQL, $match);
        return $match[2] ? trim($match[2], '`') : null;
    }
    public function GetSql()
    {
        return $this->Z_SQL;
    }
    public function SetSql($sql)
    {
        $this->Z_SQL = $sql;
        return $this;
    }
    public function GetParams()
    {
        return $this->Z_PARAMS;
    }
    public function Query($sql, $bind = null)
    {
        $this->Z_SQL = $sql;
        return $this->fetchResult(0, null, $bind);
    }
    public function QueryAll($sql, $bind = null)
    {
        $this->Z_SQL = $sql;
        return $this->Z_fetch(2, \PDO::FETCH_ASSOC, $bind);
    }
    public function QueryOne($sql, $bind = null)
    {
        $this->Z_SQL = $sql;
        return $this->Z_fetch(1, \PDO::FETCH_ASSOC, $bind);
    }
    public function QueryFields($sql, $bind = null)
    {
        $this->Z_SQL = $sql;
        return $this->Z_fetch(2, \PDO::FETCH_COLUMN, $bind);
    }
    public function QueryField($sql, $bind = null)
    {
        $this->Z_SQL = $sql;
        return $this->Z_fetch(1, \PDO::FETCH_COLUMN, $bind);
    }
    public function Prepare($sql)
    {
        $this->Z_SQL = $sql;
        return $this->fetchResult(-1);
    }
    public function LastId()
    {
        return $this->Z_CONNECT[$this->Z_USEING]->lastInsertId() ?? null;
    }
    public function Submit($sql, $bind = null)
    {
        $this->Z_SQL = $sql;
        $pre = $this->fetchResult(0, null, $bind);
        switch ($this->Z_ACT) {
            case 'INSERT':
                $num = $pre->rowCount();
                if (preg_match('/\s+ON\s+DUPLICATE\s+KEY\s+UPDATE\s+/i', $sql)) {
                    $r = 1 === $num ? ($this->Z_CONNECT[$this->Z_USEING]->lastInsertId() ?: true): $num;
                } else {
                    $r = $this->Z_CONNECT[$this->Z_USEING]->lastInsertId() ?: true;
                }
                break;
            case 'UPDATE':
            case 'DELETE':
                $r = $pre->rowCount();
                break;
            default:
                $r = $pre;
                break;
        }
        return $r;
    }
    public function Begin($i = 0)
    {
        return $this->Con($i)->beginTransaction();
    }
    public function Rollback($i = 0)
    {
        return $this->Con($i)->rollback();
    }
    public function Commit($i = 0)
    {
        return $this->Con($i)->commit();
    }
    public static function Clear($path)
    {
        $path = P_CACHE . "DB_{$path}";
        return del_dir($path, true);
    }
    private function Z_fetch($type = 1, $fetch = null, $bind = null)
    {
        $this->Z_SQL = trim($this->Z_SQL);
        if (isset($this->Z_CACHE) && (1 === $type || 2 === $type)) {
            $ckey = md5("{$this->Z_SQL}|{$type}|{$fetch}" . serialize($bind));
            empty($this->Z_CONFIG[0]['cache_mod']) && $ckey = P_CACHE . "DB_{$this->Z_CONFIG[0]['db']}/" . self::Z_getTable($this->Z_SQL) . "/{$ckey}.cache";
            $result = $this->getCache($ckey);
            if (0 < $this->Z_CACHE && false !== $result) {
                $this->Z_CACHE = null;
                return $result;
            }
        }
        if (isset($ckey)) {
            $result = $this->setCache($ckey, function () use ($type, $fetch, $bind) {
                return $this->fetchResult($type, $fetch, $bind);
            });
        } else {
            $result = $this->fetchResult($type, $fetch, $bind);
        }
        return $result;
    }
    public function __call($func, $args = null)
    {
        return call_user_func_array([$this->Con(0), $func], $args);
    }
    public function fetchResult($type = 1, $fetch = null, $bind = null, $en = 0)
    {
        $this->Z_PARAMS = $bind;
        $this->Z_ACT = strtoupper(strstr($this->Z_SQL, ' ', true));
        $index = $this->Z_USEING = 'SELECT' === $this->Z_ACT ? $this->Z_RINDEX : 0;
        $db = $this->Con($index);
        $mtime = microtime(true);
        try {
            $pre = $db->prepare($this->Z_SQL);
            if (-1 === $type) {
                $result = $pre;
            } else {
                $pre->execute($bind);
                switch ($type) {
                    case 0:
                        $result = $pre;
                        break;
                    case 1:
                        $result = $pre->fetch($fetch);
                        break;
                    case 2:
                        $result = $pre->fetchAll($fetch);
                        break;
                    case 3:
                        $result = $pre->rowCount();
                        break;
                    case 4:
                        $result = $db->lastInsertId();
                        break;
                }
                $time = microtime(true) - $mtime;
                debug::pdotime($time);
                debug::ErrorHandler(1120, preg_replace('/\s/', ' ', $this->Z_SQL) . ';', trim(json_encode($bind, 320), '{}'), round(1000 * $time, 3) . 'ms');
            }
            return $result;
        } catch (\PDOException $e) {
            method_exists($this, 'DB_done') && $this->DB_done();
            switch ($e->errorInfo[1]) {
                case 2006:
                case 2013:
                case 1120:
                case 1121:
                    $this->Con($index, true);
                    return $this->fetchResult($type, $fetch, $bind);
                case 1054:
                    if (!$en && preg_match('/COUNT\s*\([\s\S]+\)/i', $this->Z_SQL)) {
                        $this->Z_SQL = "SELECT COUNT(*) FROM ({$this->Z_SQL}) DB_n";
                        return $this->fetchResult($type, $fetch, $bind, 1);
                    }
                default:
                    debug::ErrorHandler(1120, "{$this->Z_SQL}; ", trim(json_encode($bind, 320), '{}'), 'error');
                    throw $e;
            }
        }
    }
    public function __destruct()
    {
        if ($this->Z_USED) {
            foreach ($this->Z_USED as $v) {
                self::$Z_PDO[$v] = null;
            }
        }
    }
}
