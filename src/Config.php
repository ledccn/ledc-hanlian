<?php

namespace Ledc\HanLian;

use Ledc\HanLian\Contracts\Config as ConfigContract;

/**
 * 汉连跨境ERP的api配置
 * @property bool $use_test 启用测试模式
 * @property string $api_host 生产环境服务器地址
 * @property string $app_key 生产环境appKey
 * @property string $app_secret 生产环境appSecret
 * @property string $warehouse_no 仓库编码
 * @property string $logistics_no 物流简码
 * @property string $shop_no 门店编码
 * @property string $partner_no 分销商编码
 */
class Config extends ConfigContract
{
    /**
     * 测试服务器地址
     */
    const API_HOST_TEST = 'http://yun.nitago.cn:7075/api';
    /**
     * 测试APP_KEY
     */
    const APP_KEY = '95F61DCF23129314A6B1965A59A78146';
    /**
     * 测试APP_SECRET
     */
    const APP_SECRET = 'C845578EEBAA4600A7F098CD688FC6ED9A4158AD3DAA4600';
    /**
     * 测试仓库编码
     */
    const WARE_HOUSE_NO = 'W005';
    /**
     * 测试门店编码
     */
    const SHOP_NO = 'SH0048';

    /**
     * 必填项
     * @var array<string>
     */
    protected array $requiredKeys = ['api_host', 'app_key', 'app_secret', 'warehouse_no', 'use_test', 'logistics_no', 'shop_no', 'partner_no'];
}
