<?php

namespace Hotel\Exception;
/**
 * Created by PhpStorm.
 * User: Najam.Haque
 * Date: 11/8/2015
 * Time: 9:12 AM
 */
class ProxyException extends \Exception
{

    public function __construct($message, $code, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}