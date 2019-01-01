<?php
/**
 * Created by PhpStorm.
 * User: zhangxiang
 * Date: 2018/10/16
 * Time: 下午9:14
 */

namespace app\admin\controller;


use think\Controller;
use app\model\Banner as BannerModel;
use think\Image;
use think\Request;
use think\facade\App;

class Banner extends BaseAdmin
{
    public function index(){
        $banners = BannerModel::with('book')->paginate(5,true);
        $count = count($banners);
        $this->assign([
            'banners' => $banners,
            'count' => $count
        ]);
        return view();
    }

    public function create(){
        return view();
    }

    public function save(Request $request)
    {
        $data = $request->param();
        $validate = new \app\admin\validate\Banner();
        if ($validate->check($data)) {
            $pic = $request->file('pic_name');
            if ($pic) {
                $dir = App::getRootPath() . '/public/static/upload/banner/';
                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }
                $info = $pic->validate(['size' => 2048000, 'ext' => 'jpg,jpeg,png'])->rule('md5')->move($dir);
                if ($info){
                    $data['pic_name'] = $info->getSaveName();
                }
            }
            $result = BannerModel::create($data);
            if ($result) {

                $this->success('添加成功','index','',1);
            }else{
                $this->error('添加失败');
            }
        }else{
            $this->error($validate->getError());
        }
    }

    public function edit($id){
        $banner = BannerModel::get($id);
        $this->assign('banner',$banner);
        return view();
    }

    public function update(Request $request){
        $data = $request->param();
        $validate = new \app\admin\validate\Banner();
        if ($validate->check($data)) {
            $pic = $request->file('pic_name');
            if ($pic) {
                $dir = App::getRootPath() . '/public/static/upload/banner/';
                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }
                $info = $pic->validate(['size' => 2048000, 'ext' => 'jpg,jpeg,png'])->rule('md5')->move($dir);
                if ($info){
                    $data['pic_name'] = $info->getSaveName();
                }
            }
            $result = BannerModel::update($data);
            if ($result) {

                $this->success('修改成功','index','',1);
            }else{
                $this->error('修改失败');
            }
        }else{
            $this->error($validate->getError());
        }
    }
    public function delete($id){
        $result = BannerModel::destroy($id);
        if ($result){
            return ['err' => 0,'msg' => '删除成功'];
        }else{
            return ['err' => 1,'msg' => '删除失败'];
        }
    }
}