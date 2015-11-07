<?php
/**
 * Created by PhpStorm.
 * User: Najam.Haque
 * Date: 11/7/2015
 * Time: 9:44 AM
 */

namespace Hotel\Model;


class RestClient
{
    /**
     * @todo .. if I have enough time .. we will try to implement all methods of a Repository
     *  that will make the code using this class very much portable to use a DB
     */

    const CONNECTION_ERROR = "Error Communicating to API";
    const API_RESPONSE_ERROR = "API Sent invalid JSON response.";
    /** @var */
    protected $_rest;

    public function __construct()
    {
        $this->_rest = new \ZendRest\Client\RestClient("http://api.travelbrands.com/");
    }


    public function findAll()
    {
        $unsortedHotels = $this->getHotels();
        $this->sortHotels($unsortedHotels);
        return $unsortedHotels;
    }

    public function filterByPrice($minPrice = null, $maxPrice = null)
    {
        $unsortedHotels = $this->getHotels();
        $this->sortHotels($unsortedHotels);
        return $unsortedHotels;
    }

    /**
     *  1) Sorting IMHO should be ideally pushed to DB [or in this case the API, which currently lacks sorting].
     *  2) If we don't use byRef php will duplicate arrays in passing back and forth
     * which will be a problem for larger arrays.
     * byRef create confusion IMHO
     * @param array $hotels
     * @return array
     */
    private function sortHotels(array &$hotels)
    {
        usort($hotels, function ($left, $right) {
            return $left->price->hotelPrice > $right->price->hotelPrice;
        });
    }

    private function getHotels()
    {
        /** @var \Zend\Http\Response $response */
        $response = $this->_rest->restGet("/interview-test/index.php");
        if ($response->getStatusCode() != \Zend\Http\Response::STATUS_CODE_200) {
            /** @todo .. if I have enough time .. we need to use monolog */
            $message = self::CONNECTION_ERROR;
            error_log($message);
            throw new \Exception($message, $response->getStatusCode());
        }
        $apiResponse = json_decode($response->getBody());
        if ($apiResponse) {
            if (isset($apiResponse->error) AND is_object($apiResponse->error)) {
                error_log($apiResponse->error->message);
                throw new \Exception($apiResponse->error->message, (int) $apiResponse->error->code);
            }
            return $apiResponse;
        }

        $message = json_last_error_msg();
        error_log($response->getBody());
        throw new \Exception($message, 500);
    }


}