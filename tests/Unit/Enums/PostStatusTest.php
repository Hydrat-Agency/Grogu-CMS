<?php

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Hydrat\GroguCMS\Enums\PostStatus;

/**
 * PostStatus enum tests.
 *
 * These tests are important for Filament v4 compatibility: the HasColor, HasIcon,
 * and HasLabel contracts are Filament-provided and their method signatures
 * could change between major versions.
 */
describe('PostStatus enum cases', function () {
    it('has a Draft case', function () {
        expect(PostStatus::Draft->value)->toBe('draft');
    });

    it('has a Published case', function () {
        expect(PostStatus::Published->value)->toBe('published');
    });

    it('has a Scheduled case', function () {
        expect(PostStatus::Scheduled->value)->toBe('scheduled');
    });

    it('has a Private case', function () {
        expect(PostStatus::Private->value)->toBe('private');
    });
});

describe('PostStatus implements Filament contracts', function () {
    it('implements HasColor', function () {
        expect(PostStatus::class)->toImplement(HasColor::class);
    });

    it('implements HasIcon', function () {
        expect(PostStatus::class)->toImplement(HasIcon::class);
    });

    it('implements HasLabel', function () {
        expect(PostStatus::class)->toImplement(HasLabel::class);
    });
});

describe('PostStatus default', function () {
    it('returns Draft as the default status', function () {
        expect(PostStatus::default())->toBe(PostStatus::Draft);
    });
});

describe('PostStatus::getColor()', function () {
    it('returns a color for each case', function () {
        foreach (PostStatus::cases() as $case) {
            expect($case->getColor())->not->toBeNull("PostStatus::{$case->name} must have a color");
        }
    });

    it('returns gray for Draft', function () {
        expect(PostStatus::Draft->getColor())->toBe('gray');
    });

    it('returns success for Published', function () {
        expect(PostStatus::Published->getColor())->toBe('success');
    });

    it('returns warning for Scheduled', function () {
        expect(PostStatus::Scheduled->getColor())->toBe('warning');
    });
});

describe('PostStatus::getLabel()', function () {
    it('returns a label for each case', function () {
        foreach (PostStatus::cases() as $case) {
            expect($case->getLabel())->toBeString()->not->toBeEmpty("PostStatus::{$case->name} must have a label");
        }
    });
});

describe('PostStatus::getIcon()', function () {
    it('returns an icon for each case', function () {
        foreach (PostStatus::cases() as $case) {
            expect($case->getIcon())->toBeString()->not->toBeEmpty("PostStatus::{$case->name} must have an icon");
        }
    });
});

describe('PostStatus from value', function () {
    it('can be created from a string value', function () {
        expect(PostStatus::from('draft'))->toBe(PostStatus::Draft);
        expect(PostStatus::from('published'))->toBe(PostStatus::Published);
    });

    it('returns null for invalid value with tryFrom', function () {
        expect(PostStatus::tryFrom('invalid'))->toBeNull();
    });
});
