<?php
/**
 * Created by PhpStorm.
 * User: zhangxiang
 * Date: 2018/10/19
 * Time: 下午6:11
 */

namespace app\admin\controller;


use think\Controller;
use think\facade\Session;
use think\Request;

class Login extends Controller
{
    public function index(){
        return view();
    }

    public function login(Request $request){
        if ($request->isPost()){
            $admin = config('site.admin');
            if ($admin != $request->param('admin')){
                $this->error('用户名错误');
            }
            $password = config('site.password');
            if ($password != $request->param('password')){
                $this->error('密码错误');
            }
            Session::set('admin',$admin);
            $this->success('登录成功','admin/index/index','',1);
        }else{
            return view('index');
        }
    }
}