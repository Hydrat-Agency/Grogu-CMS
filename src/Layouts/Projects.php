<?php

namespace Hydrat\GroguCMS\Layouts;

use Filament\Forms;
use App\Models\Project;

class Projects extends Layout
{
    public function configureLayout(Layout $layout): Layout
    {
        return $layout
            ->columns(1)
            ->maxItems(1)
            ->schema([
                Forms\Components\Select::make('project_id')
                    ->label('Projects')
                    ->required()
                    ->multiple()
                    ->searchable()
                    ->options(
                        Project::query()
                            ->orderBy('title')
                            ->pluck('title', 'id')
                            ->toArray()
                    ),
            ]);
    }
}
