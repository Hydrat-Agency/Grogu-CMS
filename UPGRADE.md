# Upgrade Guide

## Upgrading to v1.0.0

### Translatable resources split into dedicated classes

**Breaking change** — The `Translatable` concern has been removed from the base `PageResource`, `SectionResource`, and `FormResource` classes and their page classes. Translation support is now provided by dedicated `Translatable*` resource variants.

#### What changed

| Before | After |
|---|---|
| `PageResource` had `use Translatable` | `PageResource` is non-translatable; use `TranslatablePageResource` |
| `SectionResource` had `use Translatable` | `SectionResource` is non-translatable; use `TranslatableSectionResource` |
| `FormResource` had `use Translatable` | `FormResource` is non-translatable; use `TranslatableFormResource` |
| All page classes mixed translation directly | Base page classes are clean; translatable page classes extend them |

#### How to upgrade

If you were relying on translatable behaviour (locale switcher, translated fields), update your config to use the new `Translatable*` resource classes:

```php
// config/grogu-cms.php
'resources' => [
    'page_resource' => Hydrat\GroguCMS\Filament\Resources\TranslatablePageResource::class,
    'section_resource' => Hydrat\GroguCMS\Filament\Resources\TranslatableSectionResource::class,
    'form_resource' => Hydrat\GroguCMS\Filament\Resources\TranslatableFormResource::class,
],
```

You can mix and match — enable translation only for the resources that need it.

Make sure the `translatable` flag is also set to `true` in the config, as it now defaults to `false`:

```php
'translatable' => true,
```

If you were **not** using translatable features, no change is needed; the base resources remain the default.

#### If you extended a resource or page class

- If you extended `PageResource`, `SectionResource`, or `FormResource` directly, your class is unaffected — the base classes are unchanged except for the removal of `use Translatable`.
- If you extended a page class (e.g. `EditPage`, `CreateSection`) and relied on the `Translatable` trait being present in the parent, you must now either add `use Translatable` to your own class or extend the corresponding `Translatable*` page class instead.
- If you extended `ManageFormFields` and overrode `translatableTableHeaderActions()`, rename the method to `beforeTableHeaderActions()`.

---

### `LexiTranslatable` removed from base models

**Breaking change** — The `LexiTranslatable` trait has been removed from `CmsModel`, `Form`, and `FormField`. The base models no longer depend on `omaralalwi/lexi-translate` at runtime, making them usable in non-translatable setups without any translation infrastructure.

#### What changed

| Model | Before | After |
|---|---|---|
| `CmsModel` (and `Page`) | had `use LexiTranslatable` | trait removed; `$translatableFields` kept for reference |
| `Section` | no trait (already clean) | unchanged |
| `Form` | had `use LexiTranslatable` | trait removed; `$translatableFields` kept for reference |
| `FormField` | had `use LexiTranslatable` | trait removed; `$translatableFields` kept for reference |

#### How to upgrade

If you rely on translated fields (`.translate()`, locale scopes, etc.), you must now add `LexiTranslatable` to your **own** model that extends the Grogu CMS base. Use the new generator command:

```bash
php artisan grogu:make-translatable-model Page
php artisan grogu:make-translatable-model Section
php artisan grogu:make-translatable-model Form
php artisan grogu:make-translatable-model FormField
```

Then update `config/grogu-cms.php` to point to your new models:

```php
'models' => [
    'page' => App\Models\Page::class,
    'section' => App\Models\Section::class,
    'form' => App\Models\Form::class,
    'form_field' => App\Models\FormField::class,
],
```

The generated model extends the package base and inherits `$translatableFields`, so no further changes are needed unless you want to customise the set of translatable fields.

If you were **not** using translatable features, no change is needed.

#### If you extended a base model directly

If you already had your own `App\Models\Page` (or similar) extending `Hydrat\GroguCMS\Models\Page` and relying on `LexiTranslatable` being present in the parent, simply add the trait to your own class:

```php
use Omaralalwi\LexiTranslate\Traits\LexiTranslatable;

class Page extends \Hydrat\GroguCMS\Models\Page
{
    use LexiTranslatable;
}
```
