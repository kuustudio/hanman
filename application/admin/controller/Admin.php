<?php
/**
 * Created by PhpStorm.
 * User: hiliq
 * Date: 2019/1/8
 * Time: 17:03
 */

namespace app\admin\controller;


use app\service\AdminService;

class Admin extends BaseAdmin
{
    protected $adminService;
    protected function initialize()
    {
        $this->adminService = new AdminService();
    }

    public function index(){
        $data = $this->adminService->GetAll();
        $this->assign([
            'admins' => $data['admins'],
            'count' => $data['count']
        ]);
        return view();
    }
}