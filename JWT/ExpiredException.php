<?php
namespace Firebase\JWT;

class ExpiredException extends \UnexpectedValueException
{
    public $payload;
}
