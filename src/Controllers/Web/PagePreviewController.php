<?php

namespace Hydrat\GroguCMS\Controllers\Web;

use Hydrat\GroguCMS\Facades\GroguCMS;
use Hydrat\GroguCMS\Models\Contracts\Resourceable;
use Illuminate\Routing\Controller;
use Inertia\Response;

class PagePreviewController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(string $token): Response
    {
        $previewData = cache("preview-{$token}");

        abort_unless($previewData, 404);

        $page = $previewData['page'];

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
