# 汉连跨境ERP系统对接SDK

## 安装

`composer require ledc/hanlian`

## 使用

开箱即用，只需要传入一个配置，初始化一个实例即可：

```php
use Ledc\HanLian\Config;
use Ledc\HanLian\MerchantApi;

$env_config = [
    'use_test' => true,
    'api_host' => Config::API_HOST_TEST, // 服务器地址
    'app_key' => Config::APP_KEY, // 测试环境或正式环境的appKey
    'app_secret' => Config::APP_SECRET, // 测试环境或正式环境的appSecret
    'warehouse_no' => Config::WARE_HOUSE_NO // 测试环境或正式环境的仓库编码
];
$config = new Config($env_config);
$api = new MerchantApi($config);
```

在创建实例后，所有的方法都可以有IDE自动补全；例如：

```php
//新增销售单
$api->createOrder();
//销售单审核
$api->verifyOrder();
//分销商授权库存查询
$api->searchWarehouse();
//查询销售单
$api->queryOrder();
//查询报关状态单
$api->customsStatus();
//报关状态回执（适用于商家自行报关的客户）
$api->updateCustoms();
```

## 二次开发

配置类：`Ledc\HanLian\Config`

HTTP请求客户端基础类：`Ledc\HanLian\HttpClient`

API客户端：`Ledc\HanLian\MerchantApi`

响应类：`Ledc\HanLian\HttpResponse`

你可以继承以上几个类，扩展您需要的功能。

## 捐赠

![reward](reward.png)