# FakePHP
a framework for learning php

准备开发一款简单的框架,满足基本要求即可。

# Use Guider
 - `composer install`
 - `cp config.php.example config.php`
 - edit`config.php`

# Change List

#### Config
 - 配置文件在/config目录下，copy`config.php.example` 并重命名为`config.php`即可。
 - 每次需要同步更改`config.php.example`文件，并加入版本控制。

#### Route
 - 基本的路由解析功能，支持基本参数格式以及`pathinfo`格式。
 例如`/public/Web/Index/dbTest`和`?module=Web&controller=Index&action=dbTest`相同，即访问`Web`控制器目录中的`Index`控制器中的`dbTest`方法。

#### Autoload 
 - 基本的自动加载功能，满足psr规范，引入对应命名空间即可。
 
#### 基本的MVC结构
 - 推荐使用默认目录结构，也可以定制化，但是要注意命名空间要书写正确。
 - 每个控制器需要继承基类控制器，包含视图渲染功能，目前集成`twig`为前端视图模板。
 - 每个模型需要继承基类模型，包含数据库类，目前功能还不完善。
 
# Runtime
 - `Bootstrap::$config`返回当前配置信息

# Feature
 - Request
 - Response
 - Validator
 - QueryBuilder
 - Container