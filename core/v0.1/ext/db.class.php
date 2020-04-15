<?php
namespace ext;

use z\pdo;
use z\router;

class db
{
    private static $DB_INSTANCE;
    private $DB_PREFIX,
    $DB_CONFIG,
    $DB_BASE,
    $DB_ERROR,
    $DB_VALID,
    $DB_I = 0,
    $DB_BIND,
    $DB_PAGE,
    $DB_PAGED,
    $DB_TABLE,
    $DB_TABLED,
    $DB_TABLES,
    $DB_WHERE,
    $DB_WHERED,
    $DB_FIELD = '*',
    $DB_JOIN = [],
    $DB_JOIND,
    $DB_JOINMAP,
    $DB_HAVING,
    $DB_HAVINGD,
    $DB_GROUP,
    $DB_ORDER,
    $DB_MERGE,
    $DB_CALL,
    $DB_LIMIT,
        $DB_TMP;
    public $PDO;
    public static function Init($table = '', $c = null)
    {
        $pdo = pdo::Init($c);
        $key = $pdo->getKey();
        $key = md5($key . $table);
        if (isset(self::$DB_INSTANCE[$key])) {
            $table && self::$DB_INSTANCE[$key]->Table($table);
            return self::$DB_INSTANCE[$key];
        }
        return new self($table, $c, $pdo, $key);
    }
    public function __construct($table = '', $c = null, $pdo = null, $key = null)
    {
        if ($pdo && $key) {
            $this->PDO = $pdo;
        } else {
            $this->PDO = pdo::Init($c);
            $key = $this->PDO->getKey();
            $key = md5($key . $table);
        }
        $table && $this->table($table);
        self::$DB_INSTANCE[$key] = $this;
        $this->DB_CONFIG = $this->PDO->GetConfig();
        $this->DB_PREFIX = $this->DB_CONFIG['prefix'] ?? '';
        $this->DB_getBase();
    }
    public function Add($data, $ignore = false)
    {
        return $this->Insert($data, $ignore);
    }
    public function IfInsert($insert, $update = null)
    {
        return $this->IfUpdate($insert, $update);
    }
    public function Save($data)
    {
        return $this->Update($data);
    }
    public function GetError($sp = ';')
    {
        return $sp && $this->DB_ERROR ? implode($sp, $this->DB_ERROR) : $this->DB_ERROR;
    }
    public function GetPrefix()
    {
        return $this->DB_PREFIX;
    }
    public function Begin($i = 0)
    {
        $this->DB_CALL = [];
        return $this->PDO->Begin($i);
    }
    public function Rollback($i = 0)
    {
        $this->DB_CALL = null;
        return $this->PDO->Rollback($i);
    }
    public function Commit($i = 0)
    {
        $result = $this->PDO->Commit($i);
        if ($result && $this->DB_CALL) {
            foreach ($this->DB_CALL as $v) {
                $v[0]($v[1], $this);
            }
        }
        $this->DB_CALL = null;
        return $result;
    }
    public function Tmp($sql, $alias = 'z')
    {
        $this->DB_TMP = "({$sql}) AS {$alias}";
        return $this;
    }
    public function Table($table)
    {
        $this->DB_TABLE = $table;
        $this->DB_TABLES = [];
        $this->DB_TABLED = null;
        $this->DB_ERROR = null;
        return $this;
    }
    public function Cache($expire = null)
    {
        $this->PDO->Cache($expire);
        return $this;
    }
    public function Field($field = '')
    {
        $field && $this->DB_FIELD = $field;
        return $this;
    }
    public function Group($group = '')
    {
        $group && $this->DB_GROUP = $group;
        return $this;
    }
    public function Order($order = '')
    {
        $order && $this->DB_ORDER = $order;
        return $this;
    }
    public function Limit($limit = '')
    {
        $limit && $this->DB_LIMIT = $limit;
        return $this;
    }
    public function Where($where = '', $bind = null)
    {
        $where && $this->DB_WHERE[] = [$where, $bind];
        return $this;
    }
    public function Having($having = '', $bind = null)
    {
        $having && $this->DB_HAVING = [$having, $bind];
        return $this;
    }
    public function Join($join = '')
    {
        $join && (is_array($join) ? $this->DB_JOIN = array_merge($this->DB_JOIN, $join) : $this->DB_JOIN[] = $join);
        return $this;
    }
    public function SubQuery($field = '', $lock = false)
    {
        $field && $this->DB_FIELD = $field;
        $sql = $this->DB_sql();
        $field = $this->DB_field();
        $sql = "SELECT {$field} FROM " . $sql;
        $lock && $sql .= ' FOR UPDATE';
        $this->DB_WHERE = null;
        $this->DB_WHERED = null;
        $this->DB_TMP = null;
        $this->DB_FIELD = '*';
        $this->DB_PAGE = null;
        $this->DB_JOIN = [];
        $this->DB_JOIND = null;
        $this->DB_JOINMAP = null;
        $this->DB_GROUP = null;
        $this->DB_ORDER = null;
        $this->DB_LIMIT = null;
        $this->DB_HAVING = null;
        $this->DB_SQLD = null;
        $this->DB_MERGE = null;
        return $sql;
    }
    public function Merge($sql, $type = null)
    {
        // type='ALL'不去除重复
        if (is_array($sql)) {
            if (is_array($type)) {
                foreach ($sql as $k => $v) {
                    $t = empty($type[$k]) ? ' UNION ' : " UNION {$type[$k]} ";
                    $this->DB_MERGE .= $t . $v;
                }
            } else {
                $t = $type ? " UNION {$type} " : ' UNION ';
                $this->DB_MERGE = $t . implode($t, $sql);
            }
        } else {
            $type && $type .= ' ';
            $this->DB_MERGE = $type . $sql;
        }
        return $this;
    }
    public function Fetch($lock = false)
    {
        $sql = $this->DB_sql();
        $field = $this->DB_field();
        $sql = "SELECT {$field} FROM " . $sql;
        $lock && $sql .= ' FOR UPDATE';
        $pre = $this->PDO->SetSql($sql)->fetchResult(0, null, $this->DB_BIND);
        $this->DB_done();
        return $pre;
    }
    public function Find($field = null, $lock = false)
    {
        $fetch = \PDO::FETCH_ASSOC;
        $field && ($this->DB_FIELD = $field) && $fetch = \PDO::FETCH_COLUMN;
        $sql = $this->DB_sql();
        $field = $this->DB_field();
        $sql = "SELECT {$field} FROM " . $sql;
        $lock && $sql .= ' FOR UPDATE';
        $act = 2 === $fetch ? 'QueryOne' : 'QueryField';
        $result = $this->PDO->$act($sql, $this->DB_BIND);
        $this->DB_done();
        return $result;
    }
    public function GetPage()
    {
        return $this->DB_PAGED;
    }
    public function Select($field = null, $lock = false)
    {
        $fetch = \PDO::FETCH_ASSOC;
        $field && ($this->DB_FIELD = $field) && $fetch = \PDO::FETCH_COLUMN;
        if (isset($this->DB_PAGE)) {
            $field = $this->DB_field();
            $sql = "SELECT {$field} FROM ";
            if (!$lock && $cached = $this->PDO->getCached()) {
                $this->DB_LIMIT = $this->DB_pageLimit();
                $sqlc = $sql . $this->DB_sql();
                $key = "{$sqlc}|2|{$fetch}" . serialize($this->DB_BIND) . serialize($this->DB_PAGE);
                $pkey = md5("p{$key}");
                if (empty($this->DB_CONFIG['cache_mod'])) {
                    $path = P_CACHE . "DB_{$this->DB_CONFIG['db']}/{$this->DB_CONFIG['prefix']}" . (strstr($this->DB_TABLE, ' ', true) ?: $this->DB_TABLE);
                    $ckey = md5($key);
                    $ckey = "{$path}/{$ckey}/{$this->DB_PAGED['p']}.cache";
                    $pkey = "{$path}/page/{$pkey}.cache";
                } else {
                    $ckey = md5("{$key}{$this->DB_PAGED['p']}");
                }
                $result = $this->PDO->getCache($ckey);
                if (0 > $cached || false === $result || !$page = $this->PDO->getCache($pkey)) {
                    $this->DB_page();
                    $sql .= $this->DB_sql(true);
                    $result = $this->PDO->setCache($ckey, function () use ($sql, $fetch) {
                        return $this->PDO->SetSql($sql)->fetchResult(2, $fetch, $this->DB_BIND);
                    });
                    $this->PDO->setCache($pkey, $this->DB_PAGED);
                    $this->PDO->Cache(null);
                } else {
                    $this->DB_PAGED = $page;
                }
            } else {
                $this->DB_page();
                $sql .= $this->DB_sql(true);
                $lock && $sql .= ' FOR UPDATE';
                $result = $this->PDO->SetSql($sql)->fetchResult(2, $fetch, $this->DB_BIND);
            }
        } else {
            $sql = $this->DB_sql(true);
            $field = $this->DB_field();
            $sql = "SELECT {$field} FROM " . $sql;
            $act = 2 === $fetch ? 'QueryAll' : 'QueryFields';
            $lock && $sql .= ' FOR UPDATE';
            $result = $this->PDO->$act($sql, $this->DB_BIND);
        }
        $this->DB_done();
        return $result;
    }

    public function Update($data)
    {
        $table = $this->DB_table();
        $where = $this->DB_WHERE ? $this->DB_sqlWhere() : '';
        $join = $this->DB_JOIN ? $this->DB_sqlJoin() : '';
        if (!$sql = $this->DB_bindData($data, 'update')) {
            return false;
        }

        $sql = "UPDATE {$table}{$join} SET {$sql}{$where}";
        $result = $this->PDO->SetSql($sql)->fetchResult(3, null, $this->DB_BIND);
        $result && $this->DB_call('update', ['result' => $result, 'where' => $this->DB_WHERE, 'data' => $data, 'sql' => $sql, 'bind' => $this->DB_BIND]);
        $this->DB_done();
        return $result;
    }
    private function DB_call($name, $params)
    {
        if ($this->PDO->inTransaction()) {
            foreach ($this->DB_TABLES as $table => $a) {
                if ($act = $this->DB_BASE[$table]['call'][$name] ?? false) {
                    $this->DB_CALL[] = [$act, $params];
                }
            }
        } else {
            foreach ($this->DB_TABLES as $table => $a) {
                isset($this->DB_BASE[$table]['call'][$name]) && $this->DB_BASE[$table]['call'][$name]($params, $this);
            }
        }
    }
    public function Delete($alias = '')
    {
        $alias && $alias = " {$alias}";
        $table = $this->DB_table();
        $where = $this->DB_WHERE ? $this->DB_sqlWhere() : '';
        $join = $this->DB_JOIN ? $this->DB_sqlJoin() : '';
        $sql = "DELETE{$alias} FROM {$table}{$join}{$where}";
        $result = $this->PDO->SetSql($sql)->fetchResult(3, null, $this->DB_BIND);
        $result && $this->DB_call('delete', ['result' => $result, 'where' => $this->DB_WHERE, 'sql' => $sql, 'bind' => $this->DB_BIND]);
        $this->DB_done();
        return $result;
    }

    public function Insert($data, $ignore = false)
    {
        //$ignore=true:主键重复则不执行
        $table = $this->DB_table();
        if (!$sql = $this->DB_bindData($data, 'insert')) {
            return false;
        }

        $ignore && $ignore = ' IGNORE';
        $sql = "INSERT{$ignore} INTO {$table} {$sql}";
        $result = $this->PDO->SetSql($sql)->fetchResult(4, null, $this->DB_BIND);
        $result && $this->DB_call('insert', ['result' => $result, 'data' => $data, 'sql' => $sql, 'bind' => $this->DB_BIND]);
        $this->DB_done();
        return $result;
    }

    public function IfUpdate($insert, $update = null)
    {
        $table = $this->DB_table();
        $update || $update = $insert;
        if ((!$add_sql = $this->DB_bindData($insert, 'insert')) || (!$update_sql = $this->DB_bindData($update, 'update'))) {
            return false;
        }

        $sql = "INSERT INTO {$table} {$add_sql} ON DUPLICATE KEY UPDATE {$update_sql}";
        switch ($this->PDO->SetSql($sql)->fetchResult(3, null, $this->DB_BIND)) {
            case 1:
                $result = $this->PDO->LastId() ?: true;
                break;
            case 2:
                $result = -1;
                break;
            default:
                $result = 0;
                break;
        }
        $result && $this->DB_call('ifupdate', ['result' => $result, 'insert' => $insert, 'update' => $update, 'sql' => $sql, 'bind' => $this->DB_BIND]);
        $this->DB_done();
        return $result;
    }
    public function Page($params)
    {
        $this->DB_PAGE = $params;
        return $this;
        /**
         * $params[
         *  'p' => 当前页码, 默认：$_GET[$params['var']] ?? 1
         *  'num' => 每页的数据量, 默认：10
         *  'max' => 最大页码数, 默认：0（不限制）
         *  'var' => 参数名($_GET[var]), 默认：p
         *  'ver' => 版本号, 默认：当前版本号
         *  'mod' => url模式, 默认：当前模式
         *  'nourl' => 空链接的地址, 默认：javascript:;
         *  'return' => 需要返回的参数：默认：无
         *             [
         *               'prev',   上一页
         *               'next',   下一页
         *               'first',  第一页
         *               'last',   最后一页
         *               'list'    分页列表
         *             ]
         * ]
         */
    }
    public function Count($field = '')
    {
        $field || $field = 'DISTINCT' === trim(strtoupper(substr($this->DB_FIELD, 0, 8))) ? $this->DB_FIELD : '*';
        $sql = $this->DB_sql(true, true);
        $sql = $this->DB_GROUP ? "SELECT COUNT(*) FROM (SELECT 1 FROM {$sql}) DB_n" : "SELECT COUNT({$field}) FROM {$sql}";
        if ($this->DB_PAGE) {
            $pre = $this->PDO->Query($sql, $this->DB_BIND);
            $result = $pre->fetch(\PDO::FETCH_COLUMN);
        } else {
            $result = $this->PDO->QueryField($sql, $this->DB_BIND);
        }
        return $result;
    }
    public function GetWhereByKey($key, $op = '=', $where = [])
    {
        if ($where || $where = $this->DB_WHERE) {
            $preg = "/{$key}`?\s*{$op}\s*\(?(\w+)\)?/";
            foreach ($where as $w) {
                if (is_array($w[0])) {
                    $val = $w[0][$key] ?? $w[0]["{$key} {$op}"] ?? $w[0]["{$key}{$op}"] ?? null;
                    if (isset($val)) {
                        break;
                    }
                } elseif (preg_match($preg, $w[0], $match)) {
                    if (isset($match[1])) {
                        if (strpos($match[1], ',')) {
                            $binds = explode(',', $match[1]);
                            foreach ($binds as $a) {
                                isset($w[1][$a]) && $val[] = $w[1][$a];
                            }
                        } else {
                            $val = $match[1];
                        }
                    }
                    break;
                }
            }
        }
        return $val ?? null;
    }
    private function DB_getBase()
    {
        $ver_base = P_APP_VER . "base/{$this->DB_CONFIG['db']}.base.php";
        $app_base = P_APP . "{$this->DB_CONFIG['db']}.base.php";
        $root_base = P_ROOT . "base/{$this->DB_CONFIG['db']}.base.php";
        $this->DB_BASE = is_file($ver_base) && is_array($base = require $ver_base) ? $base : [];
        is_file($app_base) && is_array($base = require $app_base) && $this->DB_BASE += $base;
        is_file($root_base) && is_array($base = require $root_base) && $this->DB_BASE += $base;
        defined('P_MODULE') && is_file($file = P_MODULE . "base/base.php") && is_array($base = require $file) && $this->DB_BASE = $base + $this->DB_BASE;
    }
    private function DB_pageLimit($pmax = 0)
    {
        $var = $this->DB_PAGE['var'] ?? 'p';
        $this->DB_PAGED['num'] || $this->DB_PAGED['num'] = (int) $this->DB_PAGE['num'] ?? 10;
        $this->DB_PAGED['p'] = empty($this->DB_PAGE['p']) ? (empty($_GET[$var]) ? 1 : (int) $_GET[$var]) : (int) $this->DB_PAGE['p'];
        $pmax && $this->DB_PAGED['p'] > $pmax && $this->DB_PAGED['p'] = $pmax;
        $start = ($this->DB_PAGED['p'] - 1) * $this->DB_PAGED['num'];
        return "{$start},{$this->DB_PAGED['num']}";
    }
    private function DB_page()
    {
        if (empty($this->DB_PAGE['return'])) {
            return $this->DB_pageLimit();
        }

        $rows = (int) $this->count();
        $this->DB_PAGED['num'] = (int) $this->DB_PAGE['num'] ?? 10;
        $pages = $this->DB_PAGED['pages'] = $rows ? (int) ceil($rows / $this->DB_PAGED['num']) : 1;
        $max = empty($this->DB_PAGE['max']) ? 0 : $this->DB_PAGED['num'] * $this->DB_PAGE['max'];
        $max && $rows > $max && ($rows = $max) && $this->DB_PAGED['pages'] = $this->DB_PAGE['max'];
        $this->DB_PAGED['rows'] = $rows;
        $this->DB_LIMIT = $this->DB_pageLimit($this->DB_PAGED['pages']);
        $p = $this->DB_PAGED['p'];
        $var = $this->DB_PAGE['var'] ?? 'p';
        $ver = $this->DB_PAGE['ver'] ?? '';
        $mod = $this->DB_PAGE['mod'] ?? null;
        $nourl = $this->DB_PAGE['nourl'] ?? 'javascript:;';
        $params = ROUTE['params'] ?? false;
        $query = $_GET;
        if (is_array($this->DB_PAGE['return'])) {
            foreach ($this->DB_PAGE['return'] as $v) {
                switch ($v) {
                    case 'prev':
                        $params[$var] = $p - 1;
                        $this->DB_PAGED['prev'] = $params[$var] && $p !== $params[$var] ? router::url([ROUTE['ctrl'], ROUTE['act']], ['params' => $params, 'query' => $query], $ver, $mod) : $nourl;
                        break;
                    case 'next':
                        $params[$var] = $p + 1;
                        $this->DB_PAGED['next'] = $pages > $p ? router::url([ROUTE['ctrl'], ROUTE['act']], ['params' => $params, 'query' => $query], $ver, $mod) : $nourl;
                        break;
                    case 'first':
                        $params[$var] = 1;
                        $this->DB_PAGED['first'] = 1 === $p || 1 === $pages ? $nourl : router::url([ROUTE['ctrl'], ROUTE['act']], ['params' => $params, 'query' => $query], $ver, $mod);
                        break;
                    case 'last':
                        $params[$var] = $pages;
                        $this->DB_PAGED['last'] = 1 === $pages || $pages === $p ? $nourl : router::url([ROUTE['ctrl'], ROUTE['act']], ['params' => $params, 'query' => $query], $ver, $mod);
                        break;
                    case 'list':
                        (int) $rolls = $this->DB_PAGE['rolls'] ?? 10;
                        if (1 < $pages) {
                            $pos = intval($rolls / 2);
                            if ($pos < $p && $pages > $rolls) {
                                $i = $p - $pos;
                                $end = $i + $rolls - 1;
                                $end > $pages && ($end = $pages) && ($i = $end - $rolls + 1);
                            } else {
                                $i = 1;
                                $end = $rolls > $pages ? $pages : $rolls;
                            }
                            for ($i; $i <= $end; $i++) {
                                $params[$var] = $i;
                                $this->DB_PAGED['list'][$i] = $p == $i ? 'javascript:;' : router::url([ROUTE['ctrl'], ROUTE['act']], ['params' => $params, 'query' => $query], $ver, $mod);
                            }
                        } else {
                            $this->DB_PAGED['list'] = [];
                        }
                        break;
                }
            }
        }
    }
    private function DB_done()
    {
        $this->DB_I = 0;
        $this->DB_FIELD = '*';
        $this->DB_PAGE = null;
        $this->DB_WHERE = null;
        $this->DB_WHERED = null;
        $this->DB_JOIN = [];
        $this->DB_JOIND = null;
        $this->DB_JOINMAP = null;
        $this->DB_BIND = null;
        $this->DB_GROUP = null;
        $this->DB_ORDER = null;
        $this->DB_LIMIT = null;
        $this->DB_HAVING = null;
        $this->DB_SQLD = null;
        $this->DB_MERGE = null;
        if ($this->DB_VALID) {
            foreach ($this->DB_VALID as $k => $v) {
                if (isset($this->DB_TABLES[$k])) {
                    unset($this->DB_VALID[$k]);
                }

            }
        }
    }
    private function DB_field()
    {
        if (!$this->DB_TABLES) {
            return $this->DB_FIELD;
        }

        if ('*' === $this->DB_FIELD) {
            $field = '';
            $fields = [];
            $alias = [];
            foreach ($this->DB_TABLES as $table => $a) {
                if (empty($this->DB_BASE[$table]['columns'])) {
                    return '*';
                }

                $a = $table === $a ? '`' : "`{$a}.";
                if (empty($this->DB_BASE[$table]['alias'])) {
                    $field .= $a . implode("`,{$a}", $this->DB_BASE[$table]['columns']) . '`,';
                } else {
                    foreach ($this->DB_BASE[$table]['columns'] as $v) {
                        $as = $this->DB_BASE[$table]['alias'][$v] ?? false;
                        $v = $a ? "{$a}{$v}" : "`{$v}`";
                        if ($as && !isset($alias[$as])) {
                            $field .= "{$v} `{$as}`,";
                            $alias[$as] = 1;
                        } elseif (!isset($fields[$v])) {
                            $field .= "{$v},";
                            $fields[$v] = 1;
                        }
                    }
                }
            }
            $field = rtrim($field, ',');
        } else {
            $alias = [];
            foreach ($this->DB_TABLES as $table => $a) {
                if (isset($this->DB_BASE[$table]['alias'])) {
                    $a = $table === $a ? '' : "{$a}.";
                    foreach ($this->DB_BASE[$table]['alias'] as $k => $v) {
                        if (!isset($alias[$v])) {
                            $find[] = "{$a}{$k},";
                            $find[] = "{$k}`,";
                            $replace[] = "{$a}{$k} `{$v}`,";
                            $replace[] = "{$k}` `{$v}`,";
                            $alias[$v] = 1;
                        }
                    }
                }
            }
            $field = isset($find) ? rtrim(str_replace($find, $replace, $this->DB_FIELD . ','), ',') : $this->DB_FIELD;
        }
        return $field;
    }
    public function Valid(array $data, $act = 'insert', $return = 1)
    {
        $data = $this->DB_valid($this->DB_TABLE, $data, $act, $return);
        $this->DB_VALID[$this->DB_TABLE] = $data ? true : false;
        return $data;
    }
    private function DB_valid($table, $data, $type, $return, $as = '')
    {
        if (!$valids = $this->DB_BASE[$table]['valid'] ?? false) {
            throw new \PDOException("没有找到{$table}表的valid数据");
        }
        $as && $as .= '.';
        foreach ($valids as $field => $roles) {
            if (isset($roles['when']) && 'both' !== $roles['when'] && $roles['when'] !== $type) {
                continue;
            }

            $value = $data[$field] ?? $data["{$as}{$field}"] ?? null;
            $must = $roles['must'] ?? false;
            if (null === $value && !$must) {
                continue;
            }

            if (isset($roles['must'])) {
                unset($roles['must']);
            }

            if (isset($roles['when'])) {
                unset($roles['when']);
            }

            foreach ($roles as $k => $role) {
                $result = true;
                if (is_numeric($k) && is_callable($role)) {
                    $msg = $role($value, $data, $this);
                    $result = !$msg;
                } else {
                    switch ($k) {
                        case 'notnull':
                            $result = mb_strlen($value);
                            break;
                        case 'length':
                            $len = mb_strlen($value);
                            $result = is_array($role['value']) ? $len >= $role['value'][0] && $len <= $role['value'][1] : $len <= $role['value'];
                            break;
                        case 'preg':
                            $result = preg_match($role['value'], $value);
                            break;
                        case 'unique':
                            $tb = "`{$this->DB_PREFIX}{$table}`";
                            $sql = "SELECT * FROM {$tb} WHERE `{$field}` = :value";
                            $R = $this->PDO->QueryOne($sql, [':value' => $value]);
                            if ($R && 'update' === $type && $pk = $this->DB_BASE[$table]['prikey'] ?? false) {
                                if (isset($data[$pk])) {
                                    $result = $R[$pk] == $data[$pk];
                                } elseif ($this->DB_WHERE) {
                                    $found = false;
                                    $preg = "/^{$as}`?({$pk})`?\s*=\s*(.+)$/";
                                    foreach ($this->DB_WHERE as $v) {
                                        if (is_array($v[0])) {
                                            foreach ($v[0] as $k => $val) {
                                                if ($k == $pk) {
                                                    $found = true;
                                                    $result = $val == $R[$pk];
                                                    break 2;
                                                }
                                            }
                                        } elseif (preg_match($preg, $v[0], $match)) {
                                            $found = true;
                                            $result = $R[$pk] == ($v[1][$match[2]] ?? $match[2]);
                                            break;
                                        }
                                    }
                                    if (!$found) {
                                        $where = $this->DB_sqlWhere();
                                        $tb = "{$this->DB_PREFIX}{$this->DB_TABLE}";
                                        $sql = "SELECT `{$pk}` FROM {$tb}{$where}";
                                        $ori = $this->PDO->QueryField($sql, $this->DB_BIND);
                                        $result = $ori == $R[$pk];
                                    }
                                } else {
                                    $result = true;
                                }
                            } else {
                                $result = !$R;
                            }
                            break;
                        case 'number':
                            $result = is_numeric($value);
                            break;
                        case 'ip':
                            $result = filter_var($value, FILTER_VALIDATE_IP);
                            break;
                        case 'url':
                            $result = filter_var($value, FILTER_VALIDATE_URL);
                            break;
                        case 'email':
                            $result = filter_var($value, FILTER_VALIDATE_EMAIL);
                            break;
                        case 'phone':
                            $result = preg_match('/^1[3578]\d{9}$/', $value);
                            break;
                        case 'int':
                            if (is_array($role['value'])) {
                                $options = ['options' => ['min_range' => $role['value'][0], 'max_range' => $role['value'][1]]];
                            } else {
                                $options = ['options' => ['min_range' => 0, 'max_range' => $role['value']]];
                            }
                            $result = filter_var($value, FILTER_VALIDATE_INT, $options);
                            break;
                        case 'filter':
                            $result = call_user_func_array('filter_var', $role['value'] ?? [FILTER_DEFAULT]);
                            if (false === $result) {
                                $data[$field] = $result;
                                $result = true;
                            }
                            break;
                        default:
                            throw new \PDOException("验证类型错误:{$k}");
                    }
                }
                is_array($role) && (empty($role['invert']) || $result = !$result);
                if (!$result) {
                    $this->DB_ERROR[] = empty($msg) ? ($role['msg'] ?? $role) : $msg;
                    if (1 === $return) {
                        return false;
                    }

                }
            }
            if (isset($this->DB_ERROR) && 2 === $return) {
                return false;
            }

        }
        return isset($this->DB_ERROR) ? false : $data;
    }
    private function DB_bindData($data, $act = 'update')
    {
        foreach ($this->DB_TABLES as $table => $a) {
            $as = $table === $a ? '' : $a;
            if (isset($this->DB_BASE[$table]['columns'])) {
                if ($as) {
                    foreach ($this->DB_BASE[$table]['columns'] as $v) {
                        $cols[$v] = $cols["{$as}.{$v}"] = 1;
                    }
                } else {
                    $cols = array_fill_keys($this->DB_BASE[$table]['columns'], 1);
                }
                isset($columns) ? $columns += $cols : $columns = $cols;
            }
            if (isset($this->DB_VALID[$table])) {
                if (!$this->DB_VALID[$table]) {
                    return false;
                }

            } else {
                $return = $this->DB_BASE[$table]['valid']['!'] ?? 0;
                if ($return && !$data = $this->DB_valid($table, $data, $act, $return, $as)) {
                    return false;
                }

            }
        }
        foreach ($data as $k => $v) {
            if (isset($columns) && !isset($columns[$k])) {
                continue;
            }

            $_key = $this->DB_key($k);
            $keys[] = $_key;
            /**
             * $v被 {{}} 包裹时不绑定参数，按sql语句处理
             */
            if (preg_match('/^{{(.+)}}$/', $v, $match)) {
                $sets[] = "{$_key} = {$match[1]}";
                $values[] = $match[1];
            } else {
                $bind_key = $this->DB_bindKey($k);
                isset($this->DB_BIND[$bind_key]) && $bind_key .= ++$this->DB_I;
                $this->DB_BIND[$bind_key] = $v;
                $sets[] = "{$_key}={$bind_key}";
                $values[] = $bind_key;
            }
        }
        if (!isset($keys)) {
            throw new \PDOException("绑定参数错误，没有可添加/更新的字段，请检查base文件columns是否正确");
        }

        return 'insert' === $act ? '(' . implode(',', $keys) . ') VALUES (' . implode(',', $values) . ')' : implode(',', $sets);
    }
    private function DB_table()
    {
        if ($this->DB_TMP) {
            return $this->DB_TMP;
        }

        if (!isset($this->DB_TABLED)) {
            if (strpos($this->DB_TABLE, ',')) {
                $table = explode(',', $this->DB_TABLE);
                foreach ($table as $v) {
                    $v = trim($v);
                    if (strpos($v, ' ')) {
                        $tableName_arr = explode(' ', $v);
                        $tableName = array_shift($tableName_arr);
                        $tableArr[] = "{$tableName}` " . implode(' ', $tableName_arr);
                        $this->DB_TABLES[$tableName] = end($tableName_arr);
                    } else {
                        $tableArr[] = "{$v}`";
                        $this->DB_TABLES[$v] = $v;
                    }
                }
                $tabled = "`{$this->DB_PREFIX}" . implode(",`{$this->DB_PREFIX}", $tableArr);
            } else {
                if (strpos($this->DB_TABLE, ' ')) {
                    $tableName_arr = explode(' ', $this->DB_TABLE);
                    $tableName = array_shift($tableName_arr);
                    $this->DB_TABLES[$tableName] = end($tableName_arr);
                    $tabled = "`{$this->DB_PREFIX}{$tableName}` " . implode(' ', $tableName_arr);
                } else {
                    $this->DB_TABLES[$this->DB_TABLE] = $this->DB_TABLE;
                    $tabled = "`{$this->DB_PREFIX}{$this->DB_TABLE}`";
                }
            }
            $this->DB_TABLED = $tabled;
        }
        return $this->DB_TABLED;
    }
    private function DB_sql($r = false, $count = false)
    {
        if ($r || !isset($this->DB_SQLD)) {
            $table = $this->DB_table();
            $where = $this->DB_WHERE ? $this->DB_sqlWhere() : '';
            $join = $this->DB_JOIN ? $this->DB_sqlJoin() : '';
            $having = $this->DB_HAVING ? $this->DB_sqlHaving() : '';
            $group = $this->DB_GROUP ? " GROUP BY {$this->DB_GROUP}" : '';
            $limit = !$count && $this->DB_LIMIT ? " LIMIT {$this->DB_LIMIT}" : '';
            $order = !$count && $this->DB_ORDER ? " ORDER BY {$this->DB_ORDER}" : '';
            $this->DB_SQLD = $table . $join . $where . $group . $having . $order . $limit;
            $this->DB_MERGE && $this->DB_SQLD .= $this->DB_MERGE;
        }
        return $this->DB_SQLD;
    }
    private function DB_sqlJoin()
    {
        if ($this->DB_JOIN && !isset($this->DB_JOIND)) {
            $SQL = [];
            foreach ($this->DB_JOIN as $join) {
                stristr($join, 'join') || $join = "RIGHT JOIN {$join}";
                $preg = '/(.+join\s+)(\w+)\s+(as\s+)?(\w+)(.+)/i';
                $sql = preg_replace_callback($preg, function ($match) {
                    $this->DB_JOINMAP[$match[4]] = $match[2];
                    $this->DB_TABLES[$match[2]] = $match[4];
                    return "{$match[1]}`{$this->DB_PREFIX}{$match[2]}` {$match[4]}{$match[5]}";
                }, $join);
                $SQL[] = $sql ?: $join;
            }
            $this->DB_JOIND = ' ' . implode(' ', $SQL);
        }
        return $this->DB_JOIND;
    }
    private function DB_sqlHaving()
    {
        if ($this->DB_HAVING && !isset($this->DB_HAVINGD)) {
            if (is_array($this->DB_HAVING[0])) {
                $sql = $this->DB_whereArr($this->DB_HAVING[0]);
            } else {
                $sql = $this->DB_HAVING[1] ? $this->DB_whereStr($this->DB_HAVING[0], $this->DB_HAVING[1]) : $this->DB_HAVING[0];
            }
            $this->DB_HAVINGD = ' HAVING ' . $sql;
        }
        return $this->DB_HAVINGD;
    }
    private function DB_sqlWhere()
    {
        if ($this->DB_WHERE && !isset($this->DB_WHERED)) {
            $sql = '';
            foreach ($this->DB_WHERE as $where) {
                if (is_array($where[0])) {
                    $Q = $this->DB_whereArr($where[0]);
                    $sql ? $sql .= " {$Q[1]} ({$Q[0]})" : $sql .= $Q[0];
                } else {
                    $sql .= $where[1] ? $this->DB_whereStr($where[0], $where[1]) : $where[0];
                }
            }
            $this->DB_WHERED = ' WHERE ' . $sql;
        }
        return $this->DB_WHERED;
    }
    private function DB_whereArr($where)
    {
        $sql = '';
        foreach ($where as $k => $value) {
            $ch = $this->DB_checkKey($k);
            $key = $ch['key'];
            $logic = $ch['logic'] ?: 'AND';
            $operator = $ch['operator'] ? strtoupper($ch['operator']) : false;
            $sql || $lc = $logic;

            if (is_array($value)) {
                if (!$value) {
                    continue;
                }

                switch ($operator) {
                    case '<>':
                    case '!=':
                        $operator = 'NOT IN';
                        break;
                    default:
                        $operator = 'IN';
                        break;
                }
            } elseif ('SELECT' === strtoupper(substr($value, 0, 6))) {
                $operator || $operator = 'IN';
                $sql && $sql .= " {$logic} ";
                $sql .= "{$key} {$operator} ({$value})";
                continue;
            }

            if (is_array($key)) {
                $subSql = [];
                foreach ($key as $kk) {
                    $subSql[] = $this->DB_bindWhere($kk, $value, $operator);
                }
                $sql && $sql .= " {$logic} ";
                $sql .= '(' . implode(' OR ', $subSql) . ')';
            } else {
                $sql && $sql .= " {$logic} ";
                $sql .= $this->DB_bindWhere($key, $value, $operator);
            }
        }
        return [$sql, $lc];
    }
    private function DB_key($key)
    {
        return preg_match('/^[^\.\(\)]+$/', $key) ? "`{$key}`" : $key;
    }
    private function DB_bindKey($key)
    {
        return ':' . str_replace(['(', ')', '.'], ['', '', '_'], $key);
    }
    private function DB_bindWhere($key, $value, $operator = '')
    {
        $key = trim($key);
        $operator || $operator = '=';
        $bind_key = $this->DB_bindKey($key);
        $_key = $this->DB_key($key);
        if (is_array($value)) {
            if (false !== strpos($operator, 'BETWEEN')) {
                $bind_key1 = $bind_key . (++$this->DB_I);
                $this->DB_BIND[$bind_key1] = $value[0];
                $bind_key2 = $bind_key . (++$this->DB_I);
                $this->DB_BIND[$bind_key2] = $value[1];
                $where = "{$_key} {$operator} {$bind_key1} AND {$bind_key2}";
            } else {
                foreach ($value as $v) {
                    $sub_key_arr[] = $sub_key = $bind_key . (++$this->DB_I);
                    $this->DB_BIND[$sub_key] = $v;
                }
                $where = "{$_key} {$operator} (" . implode(',', $sub_key_arr) . ')';
            }
        } else {
            if (false !== strpos($value, '`')) {
                $where = "{$_key} {$operator} {$value}";
            } else {
                isset($this->DB_BIND[$bind_key]) && $bind_key = $bind_key . (++$this->DB_I);
                $where = "{$_key} {$operator} {$bind_key}";
                $this->DB_BIND[$bind_key] = $value;
            }
        }
        return $where;
    }
    private function DB_whereStr($where, $bind)
    {
        foreach ($bind as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $a) {
                    $bind_keys[] = $bind_key = $k . (++$this->DB_I);
                    $this->DB_BIND[$bind_key] = $a;
                }
                $find[] = $k;
                $replace[] = implode(',', $bind_keys);
            } else {
                if (isset($this->DB_BIND[$k])) {
                    $bind_key = $k . (++$this->DB_I);
                    $find[] = $k;
                    $replace[] = $bind_key;
                } else {
                    $bind_key = $k;
                }
                $this->DB_BIND[$bind_key] = $v;
            }
        }
        isset($find) && isset($replace) && $where = str_replace($find, $replace, $where);
        return $where;
    }
    private function DB_checkKey($key)
    {
        $preg = '/(\&|\|AND\s+|OR\s+)?\s*(\S+)(\s*[\<\>\=\!]+|\s+(IN|NOT\s+IN|BETWEEN|NOT\s+BETWEEN|LIKE|NOT\s+LIKE))?/i';
        if (preg_match($preg, $key, $match)) {
            switch ($match[1]) {
                case '&':
                    $return['logic'] = 'AND';
                    break;
                case '|':
                    $return['logic'] = 'OR';
                    break;
                default:
                    $return['logic'] = trim($match[1] ?? '');
                    break;
            }
            $return['key'] = $match[2];
            $return['operator'] = trim($match[3] ?? '');
        } else {
            $return['key'] = $key;
            $return['logic'] = false;
            $return['operator'] = false;
        }
        strpos($return['key'], '|') && $return['key'] = explode('|', $return['key']);
        return $return;
    }
}
