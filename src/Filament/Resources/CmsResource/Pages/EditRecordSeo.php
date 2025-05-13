<?php

namespace Hydrat\GroguCMS\Filament\Resources\CmsResource\Pages;

use Throwable;
use Filament\Forms;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Illuminate\Support\Arr;
use Illuminate\Support\HtmlString;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Support\Htmlable;
use Pboivin\FilamentPeek\Pages\Concerns\HasPreviewModal;
use Pboivin\FilamentPeek\Pages\Concerns\HasBuilderPreview;
use Schmeits\FilamentCharacterCounter\Forms\Components\Textarea;
use Schmeits\FilamentCharacterCounter\Forms\Components\TextInput;
use RalphJSmit\Filament\MediaLibrary\Forms\Components\MediaPicker;

abstract class EditRecordSeo extends EditRecord
{
    use HasBuilderPreview;
    use HasPreviewModal;

    protected static ?string $navigationIcon = 'phosphor-robot';

    public static function getNavigationLabel(): string
    {
        return __('SEO');
    }

    public function getTitle(): string|Htmlable
    {
        return __('Edit record SEO');
    }

    public function form(Form $form): Form
    {
        try {
            $seoDefault = $this->getRecord()?->getDynamicSEOData();
        } catch (Throwable $e) {
            $seoDefault = null;
        }

        $titleSuffixEnabled = match (true) {
            $this->getRecord() && method_exists($this->getRecord(), 'enableTitleSuffix') => $this->getRecord()->enableTitleSuffix(),
            $this->getRecord() && property_exists($this->getRecord(), 'enableTitleSuffix') => $this->getRecord()->enableTitleSuffix,
            default => true,
        };

        return $form
            ->columns(1)
            ->schema([
                Forms\Components\Section::make(__('SEO Details'))
                    ->columns(2)
                    ->relationship('seo')
                    ->schema([
                        TextInput::make('title')
                            ->placeholder(fn () => $seoDefault?->title)
                            ->suffix($titleSuffixEnabled ? config('seo.title.suffix') : '')
                            ->columnSpanFull()
                            ->live(debounce: 250)
                            ->characterLimit(60),

                        Textarea::make('description')
                            ->maxLength(65535)
                            ->rows(5)
                            ->helperText(__('A short description used on social previews and Google vignette.'))
                            ->placeholder(fn () => $seoDefault?->description)
                            ->columnSpanFull()
                            ->live(debounce: 250)
                            ->characterLimit(160),

                        // Forms\Components\FileUpload::make('seo.image')
                        //     ->image()
                        //     ->columnSpanFull(),

                        MediaPicker::make('image')
                            ->acceptedFileTypes(['image/*']),

                        Forms\Components\Select::make('robots')
                            ->native(true)
                            ->options([
                                'index, follow' => __('Index, Follow'),
                                'noindex, follow' => __('No Index, Follow'),
                                'index, nofollow' => __('Index, No Follow'),
                                'noindex, nofollow' => __('No Index, No Follow'),
                            ])
                            ->default('index, follow')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Placeholder::make('preview')
                    ->label(__('Preview'))
                    ->content(function (Model $record, Get $get) use ($titleSuffixEnabled) {
                        if (method_exists($record, 'getDynamicSEOData')) {
                            $seo = $record->getDynamicSEOData();
                        } else {
                            $seo = $record->seo;
                        }

                        $title = $get('seo.title') ?: $seo->title;
                        $description = $get('seo.description') ?: $seo->description;
                        $suffix = $titleSuffixEnabled ? config('seo.title.suffix') : '';

                        return new HtmlString(<<<HTML
                            <div class="grogu-google-preview">
                                <div class="grogu-google-preview-title">{$title}{$suffix}</div>
                                <div class="grogu-google-preview-description">{$description}</div>
                            </div>
                        HTML);
                    }),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }

    protected function mutateLocaleDataBeforeFill(array $data, string $locale): array
    {
        $record = $this->getRecord();

        $seoData = Arr::get($data, 'seo', []);
        $translatableAttributes = $record->seo->getTranslatableFields();
        $translatedData = [...$seoData];
        // $translatedData = [...$seoData, ...Arr::except($record->seo->toArray(), $translatableAttributes)];

        foreach ($translatableAttributes as $attribute) {
            $translatedData[$attribute] = $record->seo->transAttr($attribute, $locale);
        }

        return [...$data, 'seo' => $translatedData];
    }

    protected function preserveLocaleDataKeys(array $keys): array
    {
        return [...$keys, 'seo'];
    }

    protected function handleRecordLocaleUpdate(Model $record, array $data, string $locale, bool $isDefaultLocale): void
    {
        $seoData = Arr::get($data, 'seo', []);
        $seoRecord = $record->seo ?? $record->seo()->make();

        $translatableAttributes = $seoRecord->getTranslatableFields();

        if ($isDefaultLocale) {
            $seoRecord->fill($seoData);
        } else {
            $seoRecord->fill(Arr::except($seoData, $translatableAttributes));
        }

        foreach (Arr::only($seoData, $translatableAttributes) as $key => $value) {
            if (filled($value)) {
                $seoRecord->setTranslation($key, $locale, $value);
            }
        }

        $seoRecord->save();
    }
}
