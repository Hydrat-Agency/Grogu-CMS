<?php

namespace Hydrat\GroguCMS\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'grogu:update-permissions')]
class UpdatePermissionsCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'grogu:update-permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update user permissions.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        update_permissions();

        $this->info('Updated permissions.');

        return Command::SUCCESS;
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            //
        ];
    }
}
