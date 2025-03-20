<?php

namespace Hydrat\GroguCMS\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'grogu:search-replace')]
class GroguSearchReplaceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'grogu:search-replace {search?} {replace?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Search and replace a token in the database. Looks for defined CMS models only.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $search = $this->argument('search') ?? $this->ask('What token would you like to search for?');
        $replace = $this->argument('replace') ?? $this->ask('What token would you like to replace it with?');

        $replacements = 0;

        $tables = $this->getCmsTables();

        foreach ($tables as $table) {
            $replacements += DB::update("update $table set blocks = replace(blocks, ?, ?)", [$search, $replace]);
        }

        $this->info("Replaced $replacements tokens.");

        return Command::SUCCESS;
    }

    /**
     * Get the CMS tables to search and replace in.
     *
     * @return array
     */
    public function getCmsTables(): array
    {
        return [
            'pages',
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            // ['force', 'f', InputOption::VALUE_OPTIONAL, 'Create the class even if the model already exists'],
        ];
    }
}
