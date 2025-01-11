<?php

namespace Hydrat\GroguCMS;

use Spatie\Permission\PermissionRegistrar as SpatiePermissionRegistrar;

class PermissionRegistrar
{
    /**
     * Run the permission migrator.
     *
     * @return void
     */
    public function run()
    {
        $guard = config('grogu-cms.users.guard');
        $permissions = app()[SpatiePermissionRegistrar::class];

        # Ensure to be on global context.
        setPermissionsTeamId(null);

        # Reset cached roles and permissions.
        $permissions->forgetCachedPermissions();

        # Register permissions.
        foreach ($this->permissions() as $permission) {
            $permissions->getPermissionClass()::findOrCreate($permission, $guard);
        }

        # Register roles and assign created permissions.
        if ($permissions->getRoleClass()::where('guard_name', $guard)->count() === 0) {
            foreach ($this->roles() as $name => $permissions) {
                $role = Role::findOrCreate($name, $guard);

                $role->syncPermissions($permissions);
            }
        }
    }

    /**
     * Define application permissions.
     *
     * @return array
     * @see https://spatie.be/docs/laravel-permission/v6/basic-usage/wildcard-permissions
     */
    public function permissions(): array
    {
        return [
            'users.*',
            'users.view',
            'users.create',
            'users.edit',
            'users.delete',

            'roles.*',
            'roles.view',
            'roles.create',
            'roles.edit',
            'roles.delete',

            'menus.*',
            'menus.view',
            'menus.create',
            'menus.edit',
            'menus.delete',

            'pages.*',
            'pages.view',
            'pages.create',
            'pages.edit',
            'pages.delete',

            'sections.*',
            'sections.view',
            'sections.create',
            'sections.edit',
            'sections.delete',

            'forms.*',
            'forms.view',
            'forms.create',
            'forms.edit',
            'forms.delete',

            'form-entries.*',
            'form-entries.view',
            'form-entries.create',
            'form-entries.edit',
            'form-entries.delete',

            'settings.*',
            'settings.edit',
        ];
    }

    /**
     * Define roles & related permissions.
     *
     * @return array
     * @see https://spatie.be/docs/laravel-permission/v5/basic-usage/role-permissions
     */
    public function roles(): array
    {
        return [
            'Super Admin' => [
                // Gate::before() gives all permission to superadmin role.
            ],

            'Admin' => [
                'users.*',
                'roles.*',
                'menus.*',
                'pages.*',
                'sections.*',
                'forms.*',
                'form-entries.*',
                'settings.*',
            ],
        ];
    }
}
