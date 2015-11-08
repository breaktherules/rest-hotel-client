<?php
/**
 * Created by PhpStorm.
 * User: Najam.Haque
 * Date: 11/7/2015
 * Time: 7:41 PM
 */

namespace Hotel\Entity;


class Hotel
{
    /** @var  string $name */
    protected $name;

    /** @var Price $price */
    protected $price;

    /** @var  string $ratingUrl */
    protected $ratingUrl;


    public function __construct(\stdClass $hotel = null)
    {
        if (!$hotel) {
            return;
        }

        if (isset($hotel->hotelName)) {
            $this->setName($hotel->hotelName);
        }

        if (isset($hotel->hotelStarUrl)) {
            $this->setRatingUrl($hotel->hotelStarUrl);
        }

        if (isset($hotel->price) AND is_object($hotel->price)) {
            $this->setPrice(new Price($hotel->price));
        }
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Hotel
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return Price
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param Price $price
     * @return Hotel
     */
    public function setPrice(Price $price)
    {
        $this->price = $price;
        return $this;
    }

    /**
     * All our entities should have default conversion to string
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getRatingUrl()
    {
        return $this->ratingUrl;
    }

    /**
     * @param string $ratingUrl
     * @return Hotel
     */
    public function setRatingUrl($ratingUrl)
    {
        $this->ratingUrl = $ratingUrl;
        return $this;
    }


}