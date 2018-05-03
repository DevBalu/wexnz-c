<?php

namespace madmis\WexnzApi\Model;

/**
 * Class GeneratedCoupon
 * @package madmis\WexnzApi\Model
 */
class GeneratedCoupon
{
    /**
     * Generated coupon.
     * @var string
     */
    protected $coupon;

    /**
     * Transaction ID.
     * @var number
     */
    protected $transID;

    /**
     * Balance after request.
     * @var object
     */
    protected $funds;

    /**
     * @return string
     */
    public function getCoupon(): string
    {
        return $this->coupon;
    }

    /**
     * @param string $coupon
     */
    public function setCoupon(string $coupon): void
    {
        $this->coupon = $coupon;
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