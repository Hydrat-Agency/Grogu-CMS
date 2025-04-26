<?php

namespace Hydrat\GroguCMS\Filament\Resources\CmsResource\Pages;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\HtmlString;
use Pboivin\FilamentPeek\Pages\Concerns\HasBuilderPreview;
use Pboivin\FilamentPeek\Pages\Concerns\HasPreviewModal;
use RalphJSmit\Filament\MediaLibrary\Forms\Components\MediaPicker;
use Schmeits\FilamentCharacterCounter\Forms\Components\Textarea;
use Schmeits\FilamentCharacterCounter\Forms\Components\TextInput;
use Throwable;

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

        return $form
            ->columns(1)
            ->schema([
                Forms\Components\Section::make(__('SEO Details'))
                    ->columns(2)
                    ->schema([
                        TextInput::make('seo.title')
                            ->placeholder(fn () => $seoDefault?->title)
                            ->suffix(config('seo.title.suffix'))
                            ->columnSpanFull()
                            ->live(debounce: 250)
                            ->characterLimit(60),

                        Textarea::make('seo.description')
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

                        MediaPicker::make('seo.image')
                            ->acceptedFileTypes(['image/*']),

                        Forms\Components\Select::make('seo.robots')
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
                    ->content(function (Model $record, Get $get) {
                        if (method_exists($record, 'getDynamicSEOData')) {
                            $seo = $record->getDynamicSEOData();
                        } else {
                            $seo = $record->seo;
                        }

                        $title = $get('seo.title') ?: $seo->title;
                        $description = $get('seo.description') ?: $seo->description;
                        $suffix = config('seo.title.suffix');

                        return new HtmlString(<<<HTML
                                <div class="grogu-google-preview">
                                    <div class="grogu-google-preview-title">$title$suffix</div>
                                    <div class="grogu-google-preview-description">$description</div>
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

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeFill(array $data): array
    {
        data_set($data, 'seo', $this->record->seo?->toArray() ?: []);

        return $data;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $seo = Arr::pull($data, 'seo', []);

        $this->record->seo?->fill($seo)->save();

        return $data;
    }
}
