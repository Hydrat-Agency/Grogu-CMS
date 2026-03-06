<?php

use Filament\Tables\Actions\Action as TableAction;
use Filament\Tables\Columns\Column;

/**
 * These tests verify that the custom Filament macros registered by GroguCMS
 * are present and callable. They act as a safety net when upgrading Filament,
 * since v4 may change the macro API or the underlying action/column methods.
 */

describe('iconSoftButton macro', function () {
    it('is registered on TableAction', function () {
        expect(TableAction::hasMacro('iconSoftButton'))->toBeTrue();
    });

    it('returns a TableAction instance', function () {
        $action = TableAction::make('test')->iconSoftButton('heroicon-o-pencil');

        expect($action)->toBeInstanceOf(TableAction::class);
    });

    it('sets the icon on the action', function () {
        $action = TableAction::make('test')->iconSoftButton('heroicon-o-trash');

        expect($action->getIcon())->toBe('heroicon-o-trash');
    });

    it('makes the action an icon button', function () {
        $action = TableAction::make('test')->iconSoftButton('heroicon-o-pencil');

        expect($action->isIconButton())->toBeTrue();
    });
});

describe('translatable macro', function () {
    it('is registered on Column', function () {
        expect(Column::hasMacro('translatable'))->toBeTrue();
    });
});
