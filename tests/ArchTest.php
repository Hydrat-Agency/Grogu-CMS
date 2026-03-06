<?php

use Hydrat\GroguCMS\Actions\Form\GetFormValidationRules;
use Hydrat\GroguCMS\Actions\Form\SendNewEntryNotification;
use Hydrat\GroguCMS\Actions\Form\SubmitFormEntry;
use Hydrat\GroguCMS\Actions\GenerateUniqueSlug;
use Hydrat\GroguCMS\Actions\Seo\DeleteSeoScore;
use Hydrat\GroguCMS\Actions\Seo\GenerateSeoScore;
use Hydrat\GroguCMS\Actions\User\WelcomeUser;
use Hydrat\GroguCMS\Filament\Resources\CmsResource;
use Hydrat\GroguCMS\Filament\Resources\FormResource;
use Hydrat\GroguCMS\Filament\Resources\MenuResource;
use Hydrat\GroguCMS\Filament\Resources\PageResource;
use Hydrat\GroguCMS\Filament\Resources\SectionResource;
use Hydrat\GroguCMS\Filament\Resources\UserResource;
use Lorisleiva\Actions\Concerns\AsAction;

it('will not use debugging functions')
    ->expect(['dd', 'dump', 'ray'])
    ->each->not->toBeUsed();

it('actions use the AsAction concern', function () {
    $actions = [
        GetFormValidationRules::class,
        SendNewEntryNotification::class,
        SubmitFormEntry::class,
        GenerateUniqueSlug::class,
        DeleteSeoScore::class,
        GenerateSeoScore::class,
        WelcomeUser::class,
    ];

    foreach ($actions as $action) {
        expect(array_key_exists(AsAction::class, class_uses_recursive($action)))
            ->toBeTrue("Expected {$action} to use AsAction");
    }
});

it('filament resources extend the Filament Resource base class', function () {
    $resources = [
        PageResource::class,
        MenuResource::class,
        UserResource::class,
        FormResource::class,
        SectionResource::class,
    ];

    foreach ($resources as $resource) {
        expect(is_subclass_of($resource, \Filament\Resources\Resource::class))
            ->toBeTrue("{$resource} must extend Filament\\Resources\\Resource");
    }
});

it('cms resources extend CmsResource', function () {
    expect(is_subclass_of(PageResource::class, CmsResource::class))->toBeTrue();
});
