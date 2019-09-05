<?php


namespace App\Exceptions;


class SystemException extends BaseException
{
    protected function exceptions()
    {
        return [
            1001 => 'Param Error.',
            1002 => 'Sign Error.',
        ];
    }
}
