<?php

namespace app\admin\validate;

use think\Validate;

class Book extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
        'bookname' => 'require',
        'author' => 'require',
    ];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
        'bookname' => '名称必须',
        'author' => '作者必须',
    ];
}
