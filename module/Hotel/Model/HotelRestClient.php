<?php
/**
 * Created by PhpStorm.
 * User: Najam.Haque
 * Date: 11/7/2015
 * Time: 9:44 AM
 */

namespace Hotel\Model;

use Hotel\Entity\Hotel;
use Hotel\Exception\ConnectionException;
use Hotel\Exception\JsonException;
use Hotel\Exception\HttpException;

use HotelTest\ZendRestMock;

use Zend\Config\Config;
use ZendRest\Client\RestClient;


/**
 * A class to funnel all request to ApiServer
 * The class only deals with Hotel related calls.
 * It would be great ir we can implement Repository interface
 * That way, it will be easier to use a DB later if want to replace REST calls from DB calls
 * Class HotelRestClient
 * @package Hotel\Model
 */
class HotelRestClient
{
    /**
     * @todo use DI to control access to actual API
     */
    /**
     * @todo .. if I have enough time .. we will try to implement all methods of a Repository
     *  that will make the code using this class very much portable to use a DB
     */

    const CONNECTION_ERROR = "Error Communicating to API";
    const API_RESPONSE_ERROR = "API Sent invalid JSON response.";
    /** @var */
    protected $_rest;

    /** @var  Config $_config */
    protected $_config;

    public function __construct(Config $config, RestClient $restClient = null)
    {
        $this->_config = $config;
        $this->_rest = $restClient;
        $this->_rest->setUri($config->apiConnectionPoint);
    }


    /**
     * Get all hotels.
     * if we implement repository interface, this will work just as is.
     * @return array
     * @throws ConnectionException
     * @throws HttpException
     * @throws JsonException
     */
    public function findAll()
    {
        $hotels = $this->getHotels();
        $this->sortHotels($hotels);
        return $hotels;
    }

    /**
     * Get the Hotels from API and apply a price filter.
     * Named in anticipation that we need to implement Repository interface,
     * @param array $criteria
     * @return array
     * @throws ConnectionException
     * @throws HttpException
     * @throws JsonException
     */
     public function findBy(array $criteria )
    {
        $minPrice = $criteria['min'];
        $maxPrice = $criteria['max'];
        $hotels = $this->getHotels();
        $this->sortHotels($hotels);
        $hotels = array_filter($hotels,
            function (Hotel $hotel) use ($minPrice, $maxPrice) {
                $effectivePrice = $this->getEffectivePrice($hotel);
                return $effectivePrice >= $minPrice && $effectivePrice <= $maxPrice;
            }
        );
        return $hotels;
    }

    /**
     * Sorting is not required in the original task list.
     * However it makes sense from user's perspective to sort the result.
     *  1) Sorting IMHO should be ideally pushed to DB [or in this case the API, which currently lacks sorting].
     *  2) If we don't use byRef php will duplicate arrays in passing back and forth
     * which will be a problem for larger arrays.
     * byRef create confusion IMHO
     * @param array $hotels
     */
    private function sortHotels(array &$hotels)
    {
        usort($hotels, function (Hotel $leftHotel, Hotel $rightHotel) {

            $leftEffectivePrice = $this->getEffectivePrice($leftHotel);
            $rightEffectivePrice = $this->getEffectivePrice($rightHotel);

            return $leftEffectivePrice > $rightEffectivePrice;
        });
    }

    /**
     * Make the REST call to get Hotels
     * @return array of Hotel
     * @throws ConnectionException
     * @throws HttpException
     * @throws JsonException
     */
    private function getHotels()
    {
        /** @var \Zend\Http\Response $response */
        $response = $this->_rest->restGet($this->_config->getHotel);
        if ($response->getStatusCode() != \Zend\Http\Response::STATUS_CODE_200) {
            /** @todo .. if I have enough time .. we need to use monolog */
            $message = self::CONNECTION_ERROR;
            error_log($message);
            throw new HttpException($message, $response->getStatusCode());
        }

        $apiResponse = json_decode($response->getBody());
        if (!$apiResponse) {
            $message = json_last_error_msg();
            error_log($response->getBody());
            throw new JsonException($message, 500);
        }

        if (isset($apiResponse->error) AND is_object($apiResponse->error)) {
            error_log($apiResponse->error->message);
            throw new ConnectionException($apiResponse->error->message, (int)$apiResponse->error->code);
        }
        /**
         * At this point we could just return the object,
         * which is now an array unsorted Hotels.
         * But to ensure our classes are usable in a real world application in a flexible manner
         * we will convert Hotels to entities collection
         */
        return $this->hydrate($apiResponse);
    }

    /**
     * Convert stdClass object to our business entities
     * @param array $hotels
     * @return array
     */
    protected function hydrate(array $hotels)
    {
        $hydrated = [];
        foreach ($hotels as $hotel) {
            $hydrated[] = new Hotel($hotel);
        }
        return $hydrated;
    }

    /**
     * Get Effective Price taking into consideration of any promo
     * @param Hotel $hotel
     * @return float|null
     */
    protected function getEffectivePrice(Hotel $hotel)
    {
        /** @var \Hotel\Entity\Price $leftPrice */
        $leftPrice = $hotel->getPrice();
        if ($leftPrice) {
            return $leftPrice->getPromoPrice() ? $leftPrice->getPromoPrice() : $leftPrice->getRegularPrice();
        }

        /**
         * I like to return explicit null,
         * just to make a point that I am aware
         */
        return null;

    }


}