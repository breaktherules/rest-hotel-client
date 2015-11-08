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
    'router' => [
        'routes' => [
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Hotel\Controller\Hotel',
                        'action'     => 'index',
                    ),
                ),
            ),


            'hotel' => [
                'type'    => 'segment',
                'options' => [
                    'route'    => '/hotel[/:action][/]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ],
                    'defaults' => [
                        'controller' => 'Hotel\Controller\Hotel',
                        'action'     => 'index',
                    ],
                ],
            ],
            'task3'=>[
                'type'    => 'literal',
                'options' => [
                    'route'    => '/hotel/task3/',
                    'defaults' => [
                        'controller' => 'Hotel\Controller\Hotel',
                        'action'     => 'task3',
                    ],
                ],
            ],
            'ajax'=>[
                'type'    => 'literal',
                'options' => [
                    'route'    => '/hotel/ajax/',
                    'defaults' => [
                        'controller' => 'Hotel\Controller\Hotel',
                        'action'     => 'ajax',
                    ],
                ],
            ],
        ],
    ],
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