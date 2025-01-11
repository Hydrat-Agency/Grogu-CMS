<?php

if (! function_exists('update_permissions')) {

    /**
     * Update existing permissions.
     */
    function update_permissions(): void
    {
        $registrar = config('grogu-cms.users.permissions_registrar', \Hydrat\GroguCMS\PermissionRegistrar::class);

        (new $registrar)->run();
    }

}
