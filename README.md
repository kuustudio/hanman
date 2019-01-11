# 小涴熊漫画cms，开源有态度的漫画连载系统

- 首次安装，运行：你的url/install
- 将网站运行目录设置为public目录
- 如果是NGINX，添加以下伪静态规则：
```
  if (!-e $request_filename) {  
      rewrite  ^(.*)$  /index.php?s=/$1  last;  
      break;  
	}  
```  
