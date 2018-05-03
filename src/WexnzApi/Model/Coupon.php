<?php

namespace madmis\WexnzApi\Model;

/**
 * Class Coupon
 * @package madmis\WexnzApi\Model
 */
class Coupon
{
    /**
     * Coupon amount.
     * @var string
     */
    protected $couponAmount;

    /**
     * Coupon currency.
     * @var string
     */
    protected $couponCurrency;

    /**
     * Coupon transaction id.
     * @var int
     */
    protected $transID;

    /**
     * Balance after coupon redeem.
     * @var object
     */
    protected $funds;

    /**
     * @return string
     */
    public function getCouponAmount(): string
    {
        return $this->couponAmount;
    }

    /**
     * @param string $couponAmount
     */
    public function setCouponAmount(string $couponAmount): void
    {
        $this->couponAmount = $couponAmount;
    }

    /**
     * @return string
     */
    public function getCouponCurrency(): string
    {
        return $this->couponCurrency;
    }

    /**
     * @param string $couponCurrency
     */
    public function setCouponCurrency(string $couponCurrency): void
    {
        $this->couponCurrency = $couponCurrency;
    }

    /**
     * @return number
     */
    public function getTransID(): number
    {
        return $this->transID;
    }

    /**
     * @param number $transID
     */
    public function setTransID(number $transID): void
    {
        $this->transID = $transID;
    }

    /**
     * @return object
     */
    public function getFunds(): object
    {
        return $this->funds;
    }

    /**
     * @param object $funds
     */
    public function setFunds(object $funds): void
    {
        $this->funds = $funds;
    }
}