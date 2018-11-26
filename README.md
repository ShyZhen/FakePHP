# FakePHP
a framework for learning php

准备开发一款简单的框架,满足基本要求即可。

# Chang List

#### CONFIG
 - 配置文件在/config，目录下，copy`config.php.example` 并重命名为`config.php`即可

#### ROUTE
 - 基本的路由解析功能，支持基本参数格式以及pathinfo格式。
 例如`/public/Web/Index/dbTest`即访问Web控制器目录中的Index控制器中的dbTest方法。

#### AUTOLOAD 
 - 基本的自动加载功能，满足psr规范，引入对应命名空间即可。
 
#### 基本的MVC结构
 - 每个控制器需要继承基类控制器，包含视图渲染功能，目前集成twig为前端视图模板。
 - 每个模型需要继承基类模型，包含数据库类，目前功能还不完善。
 

  
