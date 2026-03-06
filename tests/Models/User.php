<?php

namespace Hydrat\GroguCMS\Tests\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    use HasRoles;

    protected $guarded = [];

    public $timestamps = true;

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    public function getDefaultAvatarUrl(): ?string
    {
        return null;
    }
}
