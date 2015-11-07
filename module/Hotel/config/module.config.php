<?php
/**
 * Created by PhpStorm.
 * User: Najam.Haque
 * Date: 11/7/2015
 * Time: 9:01 AM
 */
return array(
    'controllers' => array(
        'invokables' => array(
            'Hotel\Controller\Hotel' => 'Hotel\Controller\HotelController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'hotel' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/hotel[/:action][/:min]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'min'     => '[0-9]+',
                        //'max'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Hotel\Controller\Hotel',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'doctype'                  => 'HTML5',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
        ],
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);