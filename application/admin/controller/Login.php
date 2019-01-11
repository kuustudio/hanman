<?php
/**
 * Created by PhpStorm.
 * User: zhangxiang
 * Date: 2018/10/19
 * Time: 下午6:11
 */

namespace app\admin\controller;


use think\Controller;
use think\Request;
use app\model\Admin;

class Login extends Controller
{
    public function index(){
        return view();
    }

    public function login(Request $request){
        if ($request->isPost()){
            $verify_code = $request->param('verify_code');
            if( !captcha_check($verify_code ))
            {
                $this->error('验证码错误','/admin/login/index','',1);
            }
            $username = $request->param('admin');
            $password = md5($request->param('password').config('site.salt'));
            if (!Admin::where('username','=',$request->param('admin')){
                $this->error('用户名错误','/admin/login/index','',1);
            }
            $password = config('site.password');
            if ($password != $request->param('password')){
                $this->error('密码错误','/admin/login/index','',1);
            }
            session('admin',$admin);
            $this->success('登录成功','admin/index/index','',1);
        }else{
            return view('index');
        }
    }

    public function logout(){
        session('admin',null);
        $this->redirect('/admin/login/index');
    }
}