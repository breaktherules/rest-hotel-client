<?php

namespace HotelTest\Mock;

use ZendRest\Client\RestClient;
use Zend\Http\Response;

/**
 * Created by PhpStorm.
 * User: Najam.Haque
 * Date: 11/8/2015
 * Time: 1:13 PM
 */
class ZendRestMock extends RestClient
{
    public function __construct($apiUri)
    {
        // do absolutely nothing :)
        // not even parent constructor call
    }

    /**
     * Mock the actual rest call
     */
    public function restGet($path, array $query = null)
    {
        /**
         * We could simulate a connection failure by supplyng
         * $responseText = file_get_contents(ROOT_PATH . "/test/HotelTest/connectionError.txt");
         * or simulate invalid json coming from API ... etc
         * But its getting late .. :)
         */
        $responseText = file_get_contents(ROOT_PATH . "/test/HotelTest/hotels.txt");
        return Response::fromString($responseText);
    }

    public function setUri($uri)
    {
        // ignore
    }
}