<?php

namespace Hydrat\GroguCMS\Filament\Resources\MenuResource\Widgets;

use Filament\Forms;
use SolutionForest\FilamentTree\Widgets\Tree as BaseWidget;

class MenuItemTreeWidget extends BaseWidget
{
    protected static int $maxDepth = 2;

    protected ?string $treeTitle = 'MenuItemTreeWidget';

    protected bool $enableTreeTitle = true;

    public function getModel(): string
    {
        return config('grogu-cms.models.menu_item') ?? \Hydrat\GroguCMS\Models\MenuItem::class;
    }

    public function getTreeTitle(): ?string
    {
        return __('Hierarchical view');
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('title')
                ->required()
                ->maxLength(255),
        ];
    }

    public function getViewFormSchema(): array
    {
        return [
            //
        ];
    }

    public function getTreeRecordIcon(?\Illuminate\Database\Eloquent\Model $record = null): ?string
    {
        return null;
    }
}
