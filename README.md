# 漫画cms，自带采集

- 将网站运行目录设置为public目录
- 如果是NGINX，添加以下伪静态规则：
```
  if (!-e $request_filename) {  
      rewrite  ^(.*)$  /index.php?s=/$1  last;  
      break;  
	}  
```  
