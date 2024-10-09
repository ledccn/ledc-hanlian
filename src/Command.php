<?php

namespace Ledc\HanLian;

use think\console\Input;
use think\console\input\Argument;
use think\console\input\Option;
use think\console\Output;
use Throwable;

/**
 * 构建命令
 */
class Command extends \think\console\Command
{
    /**
     * @return void
     */
    protected function configure()
    {
        // 指令配置
        $this->setName('test:hanlian')->setDescription('测试汉连跨境ERP接口');
    }

    /**
     * @param Input $input
     * @param Output $output
     * @return void
     */
    protected function execute(Input $input, Output $output)
    {
        try {
            $env_config = [
                'use_test' => true,
                'api_host' => Config::API_HOST_TEST,
                'app_key' => Config::APP_KEY,
                'app_secret' => Config::APP_SECRET,
                'warehouse_no' => Config::WARE_HOUSE_NO
            ];
            $config = new Config($env_config);
            $api = new MerchantApi($config);
            // 分销商授权库存查询
            $result = $api->searchWarehouse(1, 20, Config::WARE_HOUSE_NO);
            var_dump($result->jsonSerialize());

            // 指令输出
            $output->writeln('测试汉连跨境ERP接口，完成！');
        } catch (Throwable $throwable) {
            $output->writeln($throwable->getMessage());
        }
    }
}
