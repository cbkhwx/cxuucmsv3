<?php
namespace z;

class cache
{
    private static $Z_REDIS, $Z_MEMCACHED;
    public static function Redis(array $c = null, bool $new = false)
    {
        $c || $c = $GLOBALS['ZPHP_CONFIG']['REDIS'] ?? null;
        if (!$c) {
            throw new \Exception("没有配置redis连接参数");
        }

        if ($new) {
            $new = new \Redis();
            $new->connect($c['host'], $c['port'], $c['timeout'] ?? 1);
            return $new;
        }
        $key = "{$c['host']}:{$c['port']}";
        if (!isset(self::$Z_REDIS[$key])) {
            self::$Z_REDIS[$key] = new \Redis();
            self::$Z_REDIS[$key]->connect($c['host'], $c['port'], $c['timeout'] ?? 1);
            empty($c['pass']) || self::$Z_REDIS[$key]->auth($c['pass']);
            empty($c['database']) || self::$Z_REDIS[$key]->select($c['database']);
        }
        return self::$Z_REDIS[$key];
    }
    public static function Memcached(array $c = null)
    {
        $c || $c = $GLOBALS['ZPHP_CONFIG']['MEMCACHED'] ?? null;
        if (!$c) {
            throw new \Exception("没有配置memcached连接参数");
        }

        $key = md5(serialize($c));
        if (!isset(self::$Z_MEMCACHED[$key])) {
            self::$Z_MEMCACHED[$key] = new Memcached();
            self::$Z_MEMCACHED[$key]->addServers($c);
        }
        return self::$Z_MEMCACHED[$key];
    }
    public static function R(string $key, $data = null, int $expire = null, int $lock = 0)
    {
        $redis = self::Redis();
        isset($expire) || $expire = $GLOBALS['ZPHP_CONFIG']['REDIS']['expire'] ?? 600;
        if (null === $data) {
            $result = $redis->get($key);
            $result && $result = unserialize($result);
        } elseif ($expire) {
            if ($lock) {
                $lock_key = "lock:{$key}";
                if (2 === $lock) {
                    if ($redis->set($lock_key, 1, ['nx', 'ex' => 30])) {
                        is_callable($data) && $data = $data() ?: '';
                        if ($redis->setex($key, $expire, serialize($data))) {
                            $redis->del($lock_key);
                            $result = $data;
                        } else {
                            $result = false;
                        }
                    } else {
                        do {
                            usleep(2000);
                            $result = $redis->get($key);
                        } while (false === $result);
                        $result = unserialize($result);
                    }
                } else {
                    $ld = session_id() ?: uniqid('', true);
                    while (!$redis->set($lock_key, 1, ['nx', 'ex' => 30])) {
                        if (3 === $lock) {
                            return false;
                        }

                        usleep(2000);
                    }
                    is_callable($data) && $data = $data() ?: '';
                    if ($redis->setex($key, $expire, serialize($data))) {
                        $ld == $redis->get($lock_key) && $redis->del($lock_key);
                        $result = $data;
                    } else {
                        $result = false;
                    }
                }
            } else {
                is_callable($data) && $data = $data() ?: '';
                $result = $redis->setex($key, $expire, serialize($data)) ? $data : false;
            }
        } else {
            $result = $redis->del($key);
        }
        return $result;
    }

    public static function M($key, $data = null, $expire = null, $lock = 0)
    {
        $mem = self::Memcached();
        isset($expire) || $expire = $GLOBALS['ZPHP_CONFIG']['MEMCACHED']['expire'] ?? 600;
        if (null === $data) {
            $result = $mem->get($key);
            $result && $result = unserialize($result);
        } elseif ($expire) {
            if ($lock) {
                $lock_key = "lock:{$key}";
                if (2 === $lock) {
                    if ($mem->add($lock_key, 1, 30)) {
                        is_callable($data) && $data = $data() ?: '';
                        if ($mem->set($key, serialize($data), $expire)) {
                            $mem->delete($lock_key);
                            $result = $data;
                        } else {
                            $result = false;
                        }
                    } else {
                        do {
                            usleep(2000);
                            $result = $mem->get($key);
                        } while (false === $result);
                        $result = unserialize($result);
                    }
                } else {
                    $ld = session_id() ?: uniqid('', true);
                    while (!$mem->add($lock_key, $ld, 30)) {
                        if (3 === $lock) {
                            return false;
                        }

                        usleep(2000);
                    }
                    is_callable($data) && $data = $data() ?: '';
                    if ($mem->set($key, serialize($data), $expire)) {
                        $ld == $mem->get($lock_key) && $mem->del($lock_key);
                        $result = $data;
                    } else {
                        $result = false;
                    }
                }
            } else {
                is_callable($data) && $data = $data() ?: '';
                $result = $mem->set($key, serialize($data), $expire) ? $data : false;
            }
        } else {
            $result = $mem->delete($key);
        }
        return $result;
    }
    public static function F($file, $data = null, $expire = null, $lock = 0)
    {
        IsFullPath($file) || $file = P_CACHE_ . $file;
        if (null === $data) {
            if (!is_file($file) || !$str = file_get_contents($file)) {
                return false;
            }

            $result = unserialize($str);
            if (isset($result['Z-PHP-CACHE-TIME-OUT'])) {
                if (TIME < $result['Z-PHP-CACHE-TIME-OUT']) {
                    $result = $result['Z-PHP-CACHE-DATA'];
                } else {
                    unlink($file);
                    $result = false;
                }
            }
        } else {
            if (0 === $expire) {
                $result = is_file($file) && unlink($file);
            } else {
                file_exists($dir = dirname($file)) || mkdir($dir, 0755, true);
                if (2 === $lock && is_file($file) && filemtime($file) >= TIME) {
                    usleep(1000);
                    $h = fopen($file, 'r');
                    flock($h, LOCK_SH);
                    $result = fread($h, filesize($file));
                    $result && $result = unserialize($str);
                    $result = $result['Z-PHP-CACHE-DATA'] ?? $result;
                } else {
                    is_callable($data) && $data = $data() ?: '';
                    $DATA = $expire ? ['Z-PHP-CACHE-DATA' => $data, 'Z-PHP-CACHE-TIME-OUT' => TIME + $expire] : $data;
                    $result = false === file_put_contents($file, serialize($DATA), LOCK_EX) ? false : $data;
                }
            }
        }
        return $result;
    }
}
