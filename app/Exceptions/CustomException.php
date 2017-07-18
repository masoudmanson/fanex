<?php
/**
 * Created by PhpStorm.
 * User: pooria
 * Date: 7/18/17
 * Time: 9:35 AM
 */

namespace App\Exceptions;


use Throwable;

class CustomException extends \Exception
{
    public function __construct($message = "", $code = 494, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}