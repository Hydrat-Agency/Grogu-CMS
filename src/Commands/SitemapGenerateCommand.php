<?php

namespace Hydrat\GroguCMS\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapGenerator;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'grogu:sitemap-generate')]
class SitemapGenerateCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'grogu:sitemap-generate';

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
        $crawl = config('grogu-cms.seo.sitemap.crawl', false);
        $models = config('grogu-cms.seo.sitemap.models', []);

        $this->info('Outputting sitemap to '.$path.'...');

        if ($crawl) {
            SitemapGenerator::create(url('/'))->writeToFile($path);
        } else {
            $sitemap = Sitemap::create();

            foreach ($models as $model) {
                $model::chunk(150, function ($records) use ($sitemap) {
                    $sitemap->add($records);
                });
            }

            $sitemap->writeToFile($path);
        }

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
