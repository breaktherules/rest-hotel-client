<?php

/**
 * Created by PhpStorm.
 * User: Najam.Haque
 * Date: 11/8/2015
 * Time: 12:01 PM
 */

namespace HotelTest\Model;

use HotelTest\Bootstrap;
use HotelTest\Mock\ZendRestMock;
use Zend\Mvc\Router\Http\TreeRouteStack as HttpRouter;
use Hotel\Model\HotelRestClient;
use Zend\Config\Config;
use Zend\Http\Response;
use PHPUnit_Framework_TestCase;

class HotelRestClientTest extends \PHPUnit_Framework_TestCase
{
    /** @var HotelRestClient $model */
    protected $model;

    /** @var  Config $config */
    protected $config;

    protected function setUp()
    {
        $this->config = new Config(include ROOT_PATH . '/module/Hotel/config/hotel.config.php');
        $restClient = new ZendRestMock(null);
        $this->model = new HotelRestClient($this->config, $restClient);
    }

    public function testFindAll()
    {
        $hotels = $this->model->findAll();
        $this->assertTrue(is_array($hotels));
        $this->assertTrue(count($hotels) == 10);
    }

    public function testFilterByPrice()
    {
        $hotels = $this->model->findBy(['min'=>140,'max'=> 150]);
        $this->assertTrue(is_array($hotels));
        $this->assertTrue(count($hotels) == 3);
    }

}