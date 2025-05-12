<?php

namespace Hydrat\GroguCMS\Filament\Resources\PageResource\Pages;

use Filament\Actions;
use Hydrat\FilamentLexiTranslate\Actions\LocaleSwitcher;
use Hydrat\FilamentLexiTranslate\Resources\Pages\EditRecord\Concerns\Translatable;
use Hydrat\GroguCMS\Collections\BlockCollection;
use Hydrat\GroguCMS\Facades\GroguCMS;
use Hydrat\GroguCMS\Filament\Resources\CmsResource\Pages\EditRecord;
use Hydrat\GroguCMS\Filament\Resources\PageResource;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Auth;
use Pboivin\FilamentPeek\Pages\Actions\PreviewAction;
use Pboivin\FilamentPeek\Pages\Concerns\HasPreviewModal;

class EditPage extends EditRecord
{
    use HasPreviewModal;
    use Translatable;

    protected static ?string $navigationIcon = 'phosphor-pencil';

    /**
     * @return class-string
     */
    public static function getResource(): string
    {
        return config('grogu-cms.resources.page_resource') ?: PageResource::class;
    }

    public static function getNavigationLabel(): string
    {
        return __('Attributes');
    }

    public function getTitle(): string|Htmlable
    {
        return __('Edit page attributes');
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

    protected function getHeaderActions(): array
    {
        return [
            ...(GroguCMS::isTranslatableEnabled() ? [LocaleSwitcher::make()] : []),
            PreviewAction::make(),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
