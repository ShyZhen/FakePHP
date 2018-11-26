<?php
/**
 * @Author huaixiu.zhen
 * http://litblc.com
 * User: z00455118
 * Date: 2018/8/30
 */

namespace App\Controllers\Web;

use App\Controllers\Controller;
use App\Models\UserModel;

class Index extends Controller
{
    /**
     * 调用视图例子
     *
     * @Author huaixiu.zhen
     * http://litblc.com
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function index()
    {
        $data = ['name' => 'litblc'];
        echo $this->view->render('welcome.html', $data);
    }

    /**
     * 数据库连接测试例子
     *
     * @Author huaixiu.zhen
     * http://litblc.com
     */
    public function dbTest()
    {
        $user = UserModel::getUser();
        return print_r($user);
    }

}