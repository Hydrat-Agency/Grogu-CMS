<?php

namespace Hydrat\GroguCMS\Controllers\Web\Inertia;

use App\Models\Page;
use Hydrat\GroguCMS\Facades\GroguCMS;
use Hydrat\GroguCMS\Models\Contracts\Resourceable;
use Illuminate\Routing\Controller;
use Inertia\Response;

class PageShowController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(string $slug): Response
    {
        $page = Page::findBySlug($slug);

        if (! $page || ($page->status !== PostStatus::Published && Auth::guest())) {
            abort(404);
        }

        $template = GroguCMS::getTemplate($page->template);
        $blueprint = $page->blueprint();
        $view = $template?->view() ?: $blueprint->view();

        return inertia($view, [
            'page' => $page instanceof Resourceable
                ? $page->toResource()
                : $page,
        ]);
    }
}
