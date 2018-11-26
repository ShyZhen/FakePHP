<?php
/**
 * @Author huaixiu.zhen
 * http://litblc.com
 * User: z00455118
 * Date: 2018/11/26
 * Time: 19:06
 */

namespace App\Models;

class UserModel extends Model
{
    private static $table = 'users';

    /**
     * 获取所有用户信息
     *
     * @Author huaixiu.zhen
     * http://litblc.com
     * @return array|string
     */
    public static function getUser()
    {
        $table = self::$table;
        $sql = "select * from $table";
        $res = self::DB()->fetchAll($sql);
        return $res;
    }
}