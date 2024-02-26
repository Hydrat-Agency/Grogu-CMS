<?php

namespace Hydrat\GroguCMS\Layouts;

use Filament\Forms;
use App\Models\Project;

class ProjectMesh extends Layout
{
    public function configureLayout(Layout $layout): Layout
    {
        return $layout
            ->columns(1)
            ->schema([
                Forms\Components\Select::make('projects')
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
