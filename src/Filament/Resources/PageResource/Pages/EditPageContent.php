<?php

namespace Hydrat\GroguCMS\Filament\Resources\PageResource\Pages;

use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Component;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Hydrat\GroguCMS\Collections\BlockCollection;
use Hydrat\GroguCMS\Facades\GroguCMS;
use Hydrat\GroguCMS\Filament\Resources\CmsResource\Pages\EditPage as EditRecord;
use Hydrat\GroguCMS\Filament\Resources\PageResource;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Auth;
use Pboivin\FilamentPeek\Forms\Actions\InlinePreviewAction;
use Pboivin\FilamentPeek\Pages\Concerns\HasBuilderPreview;
use Pboivin\FilamentPeek\Pages\Concerns\HasPreviewModal;
use Pboivin\FilamentPeek\Support;

class EditPageContent extends EditRecord
{
    use HasBuilderPreview;
    use HasPreviewModal;

    protected static ?string $navigationIcon = 'phosphor-selection-all';

    /**
     * @return class-string
     */
    public static function getResource(): string
    {
        return config('grogu-cms.resources.page_resource') ?: PageResource::class;
    }

    public static function getNavigationLabel(): string
    {
        return __('Content');
    }

    public function getTitle(): string|Htmlable
    {
        return __('Edit page content');
    }

    public function form(Form $form): Form
    {
        $avaibleTemplates = static::getBlueprint()->templates();
        $selectedTemplate = fn (Get $get) => GroguCMS::getTemplate($get('template'));

        return $form
            ->columns(1)
            ->schema([
                Forms\Components\RichEditor::make('content')
                    ->required()
                    ->maxLength(65535)
                    ->columnSpanFull()
                    ->visible(
                        fn (Get $get) => optional($selectedTemplate($get))->hasContent() || (blank($avaibleTemplates) && blank(static::getBlueprint()->blocks()))
                    ),

                // Actions::make([
                //     InlinePreviewAction::make()
                //         ->label('Preview Content Blocks')
                //         ->builderName('content_blocks'),
                // ]),

                static::getBuilderField(),
            ]);
    }

    public static function getBuilderField(): Forms\Components\Builder
    {
        $avaibleTemplates = static::getResource()::getBlueprint()->templates();
        $selectedTemplate = fn (Get $get) => GroguCMS::getTemplate($get('template'));

        return Forms\Components\Builder::make('blocks')
            ->addActionLabel(__('Add layout'))
            ->collapsible()
            ->persistCollapsed()
            ->cloneable()
            ->blockPickerColumns(2)
            ->blocks(
                fn (Get $get) => (array) (optional($selectedTemplate($get))->hasBlocks() ? $selectedTemplate($get)->blocks() : static::getResource()::getBlueprint()->blocks())
            )
            ->visible(
                fn (Get $get) => optional($selectedTemplate($get))->hasBlocks() || (blank($avaibleTemplates) && filled(static::getResource()::getBlueprint()->blocks()))
            );
    }

    protected function getPreviewModalUrl(): ?string
    {
        $page = $this->previewModalData['page'] ?? null;
        $postId = $page?->id ?: uniqid();
        $userId = Auth::user()->id;
        $token = md5("post-{$postId}-{$userId}");

        cache()->put("preview-{$token}", $this->previewModalData, 5 * 60); // 5 minutes

        return route('pages.preview', ['token' => $token]);
    }

    protected function getBuilderPreviewUrl(): ?string
    {
        $record = $this->record;

        $record->setBlocks(
            BlockCollection::fromArray($record->blocks?->toArray() ?: [])
        );

        $this->previewModalData['page'] = $record;

        return $this->getPreviewModalUrl();
    }

    protected function getPreviewModalDataRecordKey(): string
    {
        return 'page';
    }

    public static function getBuilderEditorSchema(string $builderName): Component|array
    {
        return \Filament\Forms\Components\Builder::make('blocks')
            ->addActionLabel(__('Add layout'))
            ->collapsible()
            ->cloneable()
            ->blocks(function (Get $get, $record): array {
                if (filled($selectedTemplate = GroguCMS::getTemplate($get('template'))) && $selectedTemplate->hasBlocks()) {
                    return $selectedTemplate->blocks();
                }

                return static::getResource()::getBlueprint()->blocks();
            });
        // ->visible(function (Get $get, $record): bool {
        //     if (filled($selectedTemplate = GroguCMS::getTemplate($get('template'))) && $selectedTemplate->hasBlocks()) {
        //         return true;
        //     }

        //     return filled(static::getResource()::getBlueprint()->blocks());
        // });
    }

    protected function getHeaderActions(): array
    {
        return [
            // Action::make('openBuilder')
            //     ->label('Builder')
            //     ->action(function ($livewire, $record) {
            //         Support\Panel::ensurePluginIsLoaded();

            //         Support\Page::ensurePreviewModalSupport($livewire);

            //         Support\Page::ensureBuilderPreviewSupport($livewire);

            //         $livewire->openPreviewModalForBuidler('blocks');
            //     }),
        ];
    }
}
