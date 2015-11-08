<?php
/**
 * Created by PhpStorm.
 * User: Najam.Haque
 * Date: 11/7/2015
 * Time: 7:44 PM
 */

namespace Hotel\Entity;


class Price
{
    /** @var  float $regularPrice */
    protected $regularPrice;

    /** @var  float $promoPrice */
    protected $promoPrice;

    /** @var  string $promoPrice */
    protected $promoDescription;


    public function __construct(\stdClass $price = null)
    {
        if (!$price) {
            /**
             * Early returns help make the code readable
             */
            return;
        }
        if (isset($price->hotelPrice)) {
            $this->setRegularPrice($price->hotelPrice);
        }

        if (isset($price->hotelPromoPrice)) {
            $this->setPromoPrice($price->hotelPromoPrice);
        }

        if (isset($price->hotelPromoDescription)) {
            $this->setPromoDescription($price->hotelPromoDescription);
        }

    }

    /**
     * @return float
     */
    public function getRegularPrice()
    {
        return $this->regularPrice;
    }

    /**
     * @param float $regularPrice
     * @return Price
     */
    public function setRegularPrice($regularPrice)
    {
        $this->regularPrice = $regularPrice;
        return $this;
    }

    /**
     * @return float
     */
    public function getPromoPrice()
    {
        return $this->promoPrice;
    }

    /**
     * @param float $promoPrice
     */
    public function setPromoPrice($promoPrice)
    {
        $this->promoPrice = $promoPrice;
    }

    /**
     * @return string
     */
    public function getPromoDescription()
    {
        return $this->promoDescription;
    }

    /**
     * @param string $promoDescription
     * @return Price
     */
    public function setPromoDescription($promoDescription)
    {
        $this->promoDescription = $promoDescription;
        return $this;
    }


}