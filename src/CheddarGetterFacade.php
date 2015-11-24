<?php

namespace CheddarGetter;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Collective\Html\FormBuilder
 */
class CheddarGetterFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'CG';
    }
}