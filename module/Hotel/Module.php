<?php
/**
 * Created by PhpStorm.
 * User: Najam.Haque
 * Date: 11/7/2015
 * Time: 8:54 AM
 */
namespace Hotel;
use ZendRest\Client\RestClient;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

class Module implements AutoloaderProviderInterface, ConfigProviderInterface
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/' ,
                ),
            ),
        );
    }
    public function getServiceConfig()
    {
        return array(
            'abstract_factories' => [],
            'aliases' => [],
            'factories' => [],
            'invokables' => [],
            'services' => [
                'ZendRestClient' => new RestClient(null),
            ],
            'shared' => [],
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
}