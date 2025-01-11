<?php

namespace Hydrat\GroguCMS\Contracts;

interface GuardedResource
{
    public static function getPermissions(): array;
}
