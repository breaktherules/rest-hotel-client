<?php
/**
 * Created by PhpStorm.
 * User: Najam.Haque
 * Date: 11/8/2015
 * Time: 11:04 AM
 */
include ROOT_PATH . '/test/HotelTest/Mock/ZendRestMock.php';

return array(
    'services' => [
        'ZendRestClient' => new HotelTest\Mock\ZendRestMock(null),
    ],
    'modules' => array(
        'Hotel',
    ),
    'module_listener_options' => array(
        'config_glob_paths' => array(
            '../../../config/autoload/{,*.}{global,local}.php',
        ),
        'module_paths' => array(
            'module',
            'vendor',
        ),
    ),
);