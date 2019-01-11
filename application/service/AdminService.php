<?php
/**
 * Created by PhpStorm.
 * User: hiliq
 * Date: 2019/1/8
 * Time: 17:04
 */

namespace app\service;

use app\model\Admin;
class AdminService
{
    public function GetAll(){
        $data = Admin::order('id','desc');
        $admins =  $data->paginate(5,false,
            [
                'type'     => 'util\AdminPage',
                'var_page' => 'page',
            ]);
        return [
            'admins' => $admins,
            'count' => $data->count()
        ];
    }
}