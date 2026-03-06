<?php

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Hydrat\GroguCMS\Enums\FormFieldType;

/**
 * FormFieldType enum tests.
 *
 * Covers the type-specific methods that drive form builder behaviour,
 * validation generation, and UI rendering. Changes to these methods
 * directly affect the form submission and validation pipeline.
 */
describe('FormFieldType implements Filament contracts', function () {
    it('implements HasColor', function () {
        expect(FormFieldType::class)->toImplement(HasColor::class);
    });

    it('implements HasIcon', function () {
        expect(FormFieldType::class)->toImplement(HasIcon::class);
    });

    it('implements HasLabel', function () {
        expect(FormFieldType::class)->toImplement(HasLabel::class);
    });
});

describe('FormFieldType cases exist', function () {
    $expectedCases = [
        'Text', 'Textarea', 'Email', 'Telephone', 'Number',
        'Date', 'DateTime', 'Radio', 'Checkbox', 'Select',
        'Image', 'Attachment', 'Signature', 'Title', 'Placeholder', 'Confirm',
    ];

    foreach ($expectedCases as $case) {
        it("has the {$case} case", function () use ($case) {
            expect(FormFieldType::{$case})->toBeInstanceOf(FormFieldType::class);
        });
    }
});

describe('FormFieldType::getColor()', function () {
    it('returns a color for every case', function () {
        foreach (FormFieldType::cases() as $case) {
            expect($case->getColor())->not->toBeNull("FormFieldType::{$case->name} must have a color");
        }
    });
});

describe('FormFieldType::getLabel()', function () {
    it('returns a label string for every case', function () {
        foreach (FormFieldType::cases() as $case) {
            expect($case->getLabel())->toBeString()->not->toBeEmpty("FormFieldType::{$case->name} must have a label");
        }
    });
});

describe('FormFieldType::getIcon()', function () {
    it('returns an icon string for every case', function () {
        foreach (FormFieldType::cases() as $case) {
            expect($case->getIcon())->toBeString()->not->toBeEmpty("FormFieldType::{$case->name} must have an icon");
        }
    });
});

describe('FormFieldType::getValidationRules()', function () {
    it('returns an array for every case', function () {
        foreach (FormFieldType::cases() as $case) {
            expect($case->getValidationRules())->toBeArray();
        }
    });

    it('returns email rule for Email type', function () {
        expect(FormFieldType::Email->getValidationRules())->toContain('email');
    });

    it('returns numeric rule for Number type', function () {
        expect(FormFieldType::Number->getValidationRules())->toContain('numeric');
    });

    it('returns date rule for Date type', function () {
        expect(FormFieldType::Date->getValidationRules())->toContain('date');
    });

    it('returns date rule for DateTime type', function () {
        expect(FormFieldType::DateTime->getValidationRules())->toContain('date');
    });

    it('returns string rule for Text type', function () {
        expect(FormFieldType::Text->getValidationRules())->toContain('string');
    });

    it('returns boolean rule for Confirm type', function () {
        expect(FormFieldType::Confirm->getValidationRules())->toContain('boolean');
    });
});

describe('FormFieldType::canBeMultiple()', function () {
    it('allows multiple for Select', function () {
        expect(FormFieldType::Select->canBeMultiple())->toBeTrue();
    });

    it('allows multiple for Checkbox', function () {
        expect(FormFieldType::Checkbox->canBeMultiple())->toBeTrue();
    });

    it('allows multiple for Image', function () {
        expect(FormFieldType::Image->canBeMultiple())->toBeTrue();
    });

    it('allows multiple for Attachment', function () {
        expect(FormFieldType::Attachment->canBeMultiple())->toBeTrue();
    });

    it('does not allow multiple for Text', function () {
        expect(FormFieldType::Text->canBeMultiple())->toBeFalse();
    });

    it('does not allow multiple for Email', function () {
        expect(FormFieldType::Email->canBeMultiple())->toBeFalse();
    });
});

describe('FormFieldType::alwaysMultiple()', function () {
    it('is always multiple for Checkbox', function () {
        expect(FormFieldType::Checkbox->alwaysMultiple())->toBeTrue();
    });

    it('is not always multiple for Select', function () {
        expect(FormFieldType::Select->alwaysMultiple())->toBeFalse();
    });
});

describe('FormFieldType::hasOptions()', function () {
    it('has options for Radio', function () {
        expect(FormFieldType::Radio->hasOptions())->toBeTrue();
    });

    it('has options for Checkbox', function () {
        expect(FormFieldType::Checkbox->hasOptions())->toBeTrue();
    });

    it('has options for Select', function () {
        expect(FormFieldType::Select->hasOptions())->toBeTrue();
    });

    it('does not have options for Text', function () {
        expect(FormFieldType::Text->hasOptions())->toBeFalse();
    });

    it('does not have options for Email', function () {
        expect(FormFieldType::Email->hasOptions())->toBeFalse();
    });
});

describe('FormFieldType::hasMinMax()', function () {
    it('supports min/max for Text', function () {
        expect(FormFieldType::Text->hasMinMax())->toBeTrue();
    });

    it('supports min/max for Number', function () {
        expect(FormFieldType::Number->hasMinMax())->toBeTrue();
    });

    it('does not support min/max for Date', function () {
        expect(FormFieldType::Date->hasMinMax())->toBeFalse();
    });

    it('does not support min/max for Select', function () {
        expect(FormFieldType::Select->hasMinMax())->toBeFalse();
    });
});

describe('FormFieldType::hasDateMinMax()', function () {
    it('supports date min/max for Date', function () {
        expect(FormFieldType::Date->hasDateMinMax())->toBeTrue();
    });

    it('supports date min/max for DateTime', function () {
        expect(FormFieldType::DateTime->hasDateMinMax())->toBeTrue();
    });

    it('does not support date min/max for Text', function () {
        expect(FormFieldType::Text->hasDateMinMax())->toBeFalse();
    });
});

describe('FormFieldType::canBeRequired()', function () {
    it('can be required for Text', function () {
        expect(FormFieldType::Text->canBeRequired())->toBeTrue();
    });

    it('cannot be required for Title', function () {
        expect(FormFieldType::Title->canBeRequired())->toBeFalse();
    });

    it('cannot be required for Placeholder', function () {
        expect(FormFieldType::Placeholder->canBeRequired())->toBeFalse();
    });
});

describe('FormFieldType::hasContent()', function () {
    it('has content for Title', function () {
        expect(FormFieldType::Title->hasContent())->toBeTrue();
    });

    it('has content for Placeholder', function () {
        expect(FormFieldType::Placeholder->hasContent())->toBeTrue();
    });

    it('has content for Confirm', function () {
        expect(FormFieldType::Confirm->hasContent())->toBeTrue();
    });

    it('does not have content for Text', function () {
        expect(FormFieldType::Text->hasContent())->toBeFalse();
    });
});
