<?php

use Hydrat\GroguCMS\Models\Menu;

describe('Menu model', function () {
    it('can be created with title and location', function () {
        $menu = Menu::create([
            'title' => 'Main Navigation',
            'location' => 'main',
        ]);

        expect($menu->exists)->toBeTrue();
        expect($menu->title)->toBe('Main Navigation');
        expect($menu->location)->toBe('main');
    });

    it('has an items HasMany relationship', function () {
        expect((new Menu)->items())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class);
    });

    it('has an elements HasMany relationship', function () {
        expect((new Menu)->elements())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class);
    });

    it('fillable includes title and location', function () {
        $menu = new Menu;

        expect($menu->getFillable())->toContain('title');
        expect($menu->getFillable())->toContain('location');
    });
});
