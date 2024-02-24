<?php

namespace Hydrat\GroguCMS\Commands;

use Illuminate\Console\Command;

class GroguCMSCommand extends Command
{
    public $signature = 'grogu-cms';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
