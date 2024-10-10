<?php

namespace Ledc\HanLian;

use InvalidArgumentException;

/**
 * 汉连跨境API
 */
class MerchantApi extends HttpClient
{
    /**
     * 新增销售单
     * @param array $order 销售主体(备注:单条)
     * @param array $Items 销售明细集合
     * @param array $FeeItems 销售费用明细集合
     * @return HttpResponse
     */
    public function createOrder(array $order, array $Items, array $FeeItems = []): HttpResponse
    {
        $data = compact('order', 'Items', 'FeeItems');
        return $this->postRequest('/merchant/createOrder', $data);
    }

    /**
     * 销售单审核
     * @param string $OriginOrderNo 来源单号(说明:唯一性,平台订单号)
     * @return HttpResponse
     */
    public function verifyOrder(string $OriginOrderNo): HttpResponse
    {
        return $this->postRequest('/merchant/verify', ['OriginOrderNo' => $OriginOrderNo]);
    }

    /**
     * 分销商授权库存查询
     * @param int $Page 当前页
     * @param int $Rows 每页行数(一页最多显示 100 条)
     * @param string $WarehouseNo 仓库编码
     * @param array $StockQuery 商品明细
     * @return HttpResponse
     */
    public function searchWarehouse(int $Page, int $Rows = 100, string $WarehouseNo = '', array $StockQuery = []): HttpResponse
    {
        $Rows = (int)min(100, max(1, $Rows));
        $data = compact('Page', 'Rows', 'WarehouseNo', 'StockQuery');
        return $this->postRequest('/merchantInventory/search', $data);
    }

    /**
     * 查询销售单
     * @param array $ErpCodes 销售单号集合
     * @param string $ModifyTimeStart 开始下单时间（销售单号为空的情况下不可为空），格式：2018-01-08 13:23:23
     * @param string $ModifyTimeEnd 结束下单时间（销售单号为空的情况下不可为空），，格式：2018-01-08 13:23:23
     * @return HttpResponse
     */
    public function queryOrder(array $ErpCodes = [], string $ModifyTimeStart = '', string $ModifyTimeEnd = ''): HttpResponse
    {
        if (empty($ErpCodes) && (empty($ModifyTimeStart) || empty($ModifyTimeEnd))) {
            throw new InvalidArgumentException('销售单为空时，开始时间和下单时间必填');
        }
        $data = array_filter(compact('ErpCodes', 'ModifyTimeStart', 'ModifyTimeEnd'));

        return $this->postRequest('/merchant/orderquery', $data);
    }

    /**
     * 查询报关状态单
     * @param array $ErpCodes 销售单号集合
     * @param string $ModifyTimeStart 开始下单时间（销售单号为空的情况下不可为空），格式：2018-01-08 13:23:23
     * @param string $ModifyTimeEnd 结束下单时间（销售单号为空的情况下不可为空），，格式：2018-01-08 13:23:23
     * @return HttpResponse
     */
    public function customsStatus(array $ErpCodes = [], string $ModifyTimeStart = '', string $ModifyTimeEnd = ''): HttpResponse
    {
        if (empty($ErpCodes) && (empty($ModifyTimeStart) || empty($ModifyTimeEnd))) {
            throw new InvalidArgumentException('销售单为空时，开始时间和下单时间必填');
        }
        $data = array_filter(compact('ErpCodes', 'ModifyTimeStart', 'ModifyTimeEnd'));
        return $this->postRequest('/merchant/customsStatus', $data);
    }

    /**
     * 报关状态回执
     * - 适用于商家自行报关的客户
     * @param string $OriginOrderNo 来源单号
     * @param int $CustomsStatus 报关状态 -1=报关失败,0=报关中,1=放行,2=查验,传数值
     * @param string $CustomsRemark 报关备注说明
     * @param string $ManifestOrderNo 海关清单编号(放行,必传)
     * @param string $CustomsSuccessTime 海关放行时间(放行,必传)，格式：2018-01-08 13:23:23
     * @return HttpResponse
     */
    public function updateCustoms(string $OriginOrderNo, int $CustomsStatus, string $CustomsRemark, string $ManifestOrderNo, string $CustomsSuccessTime = ''): HttpResponse
    {
        $data = array_filter(compact('OriginOrderNo', 'CustomsStatus', 'CustomsRemark', 'ManifestOrderNo', 'CustomsSuccessTime'));
        return $this->postRequest('/merchant/updateCustoms', $data);
    }
}
