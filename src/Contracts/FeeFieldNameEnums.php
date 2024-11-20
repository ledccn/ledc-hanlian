<?php

namespace Ledc\HanLian\Contracts;

/**
 * 费用标识名枚举
 * - 新增销售单时，FeeItems字段数据集内容
 */
class FeeFieldNameEnums
{
    /**
     * 运费
     */
    public const ShippingPrice = 'ShippingPrice';
    /**
     * 税费
     */
    public const ProductTax = 'ProductTax';
    /**
     * 优惠金额
     */
    public const DiscountAmount = 'DiscountAmount';
    /**
     * 保险费用
     */
    public const InsuranceFee = 'InsuranceFee';
    /**
     * 其他
     */
    public const SaleOtherFee = 'SaleOtherFee';
}
