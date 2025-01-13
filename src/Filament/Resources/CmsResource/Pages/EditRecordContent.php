<?php

namespace Hydrat\GroguCMS\Filament\Resources\CmsResource\Pages;

use Filament\Forms;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Actions\Action;
use Pboivin\FilamentPeek\Support;
use Illuminate\Support\Facades\Auth;
use Hydrat\GroguCMS\Facades\GroguCMS;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Component;
use Illuminate\Contracts\Support\Htmlable;
use Hydrat\GroguCMS\Collections\BlockCollection;
use Pboivin\FilamentPeek\Pages\Actions\PreviewAction;
use Pboivin\FilamentPeek\Pages\Concerns\HasPreviewModal;
use Pboivin\FilamentPeek\Pages\Concerns\HasBuilderPreview;
use Pboivin\FilamentPeek\Forms\Actions\InlinePreviewAction;

abstract class EditRecordContent extends EditRecord
{
    use HasBuilderPreview;
    use HasPreviewModal;

    protected static ?string $navigationIcon = 'phosphor-selection-all';

    public static function getNavigationLabel(): string
    {
        return __('Content');
    }

    public function getTitle(): string|Htmlable
    {
        return __('Edit record content');
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

    protected function mutateInitialBuilderEditorData(string $builderName, array $editorData): array
    {
        return [
            ...$editorData,
            'template' => $this->data['template'],
        ];
    }

    public static function getBuilderEditorSchema(string $builderName): Component|array
    {
        return \Filament\Forms\Components\Builder::make('blocks')
            ->addActionLabel(__('Add layout'))
            ->collapsible()
            ->cloneable()
            ->blocks(function ($livewire): array {
                if (filled($selectedTemplate = GroguCMS::getTemplate($livewire->editorData['template'])) && $selectedTemplate->hasBlocks()) {
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
            PreviewAction::make(),

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
