<?php

namespace Hydrat\GroguCMS\Controllers\Web\Inertia;

use App\Models\Page;
use Inertia\Response;
use Illuminate\Routing\Controller;
use Hydrat\GroguCMS\Facades\GroguCMS;
use Hydrat\GroguCMS\Settings\GeneralSettings;
use Hydrat\GroguCMS\Models\Contracts\Resourceable;

class FrontPageShowController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(GeneralSettings $settings): Response
    {
        $page = Page::find($settings->front_page);

        if (!$page || (!$page->published_at && auth()->guest())) {
            abort(404);
        }

        $template = GroguCMS::getTemplate($page->template);
        $view = $template?->view() ?: 'pages/Default/Default';

        return inertia($view, [
            'page' => $page instanceof Resourceable
                ? $page->toResource()
                : $page,
        ]);
    }
}
