<?php

use Illuminate\Database\Eloquent\Model;

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

if (! function_exists('grogu_translate')) {

    /**
     * Update existing permissions.
     */
    function grogu_translate(Model $model, string $attribute, ?string $locale = null, bool $useFallbackLocale = true): mixed
    {
        return method_exists($model, 'translate') && $model->isTranslatableAttribute($attribute)
            ? $model->translate($attribute, locale: $locale, useFallbackLocale: $useFallbackLocale)
            : $model->{$attribute};
    }

}
