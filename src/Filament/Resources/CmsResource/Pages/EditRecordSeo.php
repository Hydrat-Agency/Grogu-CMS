<?php

namespace Hydrat\GroguCMS\Filament\Resources\CmsResource\Pages;

use Filament\Forms;
use Filament\Forms\Form;
use Hydrat\GroguCMS\Filament\Resources\CmsResource\Pages\EditRecord;
use Hydrat\GroguCMS\Filament\Resources\PageResource;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Arr;
use Pboivin\FilamentPeek\Pages\Concerns\HasBuilderPreview;
use Pboivin\FilamentPeek\Pages\Concerns\HasPreviewModal;

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
        return $form
            ->columns(1)
            ->schema([
                Forms\Components\Section::make(__('SEO Details'))
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('seo.title')
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('seo.description')
                            ->maxLength(65535)
                            ->rows(5)
                            ->helperText(__('A short description used on social previews and Google vignette.'))
                            ->columnSpanFull(),

                        Forms\Components\FileUpload::make('seo.image')
                            ->image()
                            ->columnSpanFull(),

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
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $seo = Arr::pull($data, 'seo', []);

        $this->record->seo->fill($seo)->save();

        return $data;
    }
}
