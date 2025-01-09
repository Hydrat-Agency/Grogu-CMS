<?php

namespace Hydrat\GroguCMS\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Spatie\Sitemap\SitemapGenerator;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'sitemap:generate')]
class SitemapGenerateCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the sitemap.xml file for search engines.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $path = base_path(config('grogu-cms.seo.sitemap.path', ''));

        $this->info('Outputting sitemap to '. $path .'...');

        SitemapGenerator::create(app_url())
            ->writeToFile($path);

        $this->info('Sitemap generated successfully.');

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
