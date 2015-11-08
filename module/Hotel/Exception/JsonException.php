<?php
/**
 * Created by PhpStorm.
 * User: Najam.Haque
 * Date: 11/8/2015
 * Time: 9:20 AM
 */

namespace Hotel\Exception;


class JsonException extends \Exception
{

    public function __construct($message, $code, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}