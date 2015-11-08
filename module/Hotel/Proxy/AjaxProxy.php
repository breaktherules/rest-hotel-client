<?php
/**
 * Created by PhpStorm.
 * User: Najam.Haque
 * Date: 11/8/2015
 * Time: 8:38 AM
 */

namespace Hotel\Proxy;

use Hotel\Exception\ProxyException;

use Zend\Config\Config;
use ZendRest\Client\RestClient;
/**
 * A class that provides proxy services.
 * Note that Hotel\Model\RestClient could just be added teh ajaxCall method.
 * but that in my opinion violates Single Responsibility Principle .
 * Class AjaxProxy
 * @package Hotel\Model
 */
class AjaxProxy
{
    const CONNECTION_ERROR = "Error Communicating to Server.";
    protected $_proxy;

    /** @var Config $_config */
    protected $_config;

    public function __construct(Config $config)
    {
        $this->_config = $config;
        /**
         * Lets use the rest client as our proxy dealer
         */
        $this->_proxy = new RestClient($config->apiConnectionPoint);
    }

    /**
     * Make that proxy ajax call to server
     * @return string
     * @return string
     * @throws ProxyException
     */
    public function ajaxCall()
    {
        /** @var \Zend\Http\Response $response */
        $response = $this->_proxy->restGet($this->_config->ajaxCallPoint);

        if ($response->getStatusCode() != \Zend\Http\Response::STATUS_CODE_200) {
            /** @todo .. if I have enough time .. we need to use monolog */
            $message = self::CONNECTION_ERROR;
            error_log($message);
            throw new ProxyException($message, $response->getStatusCode());
        }

        return $response->getBody();
    }


}