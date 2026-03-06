<?php

use Hydrat\GroguCMS\Enums\PostStatus;
use Hydrat\GroguCMS\Models\Page;

/**
 * CmsModel base class behaviour tested through Page (a concrete CmsModel subclass).
 *
 * This covers the common fillable fields, casts, scopes, and relationships
 * that all CMS content models share.
 */
describe('CmsModel fillable fields', function () {
    it('has user_id in fillable', function () {
        expect((new Page)->getFillable())->toContain('user_id');
    });

    it('has title in fillable', function () {
        expect((new Page)->getFillable())->toContain('title');
    });

    it('has slug in fillable', function () {
        expect((new Page)->getFillable())->toContain('slug');
    });

    it('has status in fillable', function () {
        expect((new Page)->getFillable())->toContain('status');
    });

    it('has content in fillable', function () {
        expect((new Page)->getFillable())->toContain('content');
    });

    it('has blocks in fillable', function () {
        expect((new Page)->getFillable())->toContain('blocks');
    });
});

describe('CmsModel casts', function () {
    it('casts status to PostStatus enum', function () {
        $page = Page::create([
            'title' => 'Test Page',
            'slug' => 'test-page',
            'status' => 'published',
        ]);

        expect($page->status)->toBeInstanceOf(PostStatus::class);
        expect($page->status)->toBe(PostStatus::Published);
    });

    it('casts blocks to array', function () {
        $page = Page::create([
            'title' => 'Blocks Page',
            'slug' => 'blocks-page',
            'status' => PostStatus::Draft,
            'blocks' => [['type' => 'hero', 'data' => []]],
        ]);

        expect($page->blocks)->toBeArray();
    });
});

describe('CmsModel relationships', function () {
    it('has a parent BelongsTo relationship', function () {
        expect((new Page)->parent())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class);
    });

    it('has a children HasMany relationship', function () {
        expect((new Page)->children())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class);
    });
});

describe('CmsModel scopes', function () {
    it('scopePublished filters only published records', function () {
        Page::create(['title' => 'Draft', 'slug' => 'draft', 'status' => PostStatus::Draft]);
        Page::create(['title' => 'Live', 'slug' => 'live', 'status' => PostStatus::Published]);

        $results = Page::published()->get();

        expect($results)->toHaveCount(1);
        expect($results->first()->status)->toBe(PostStatus::Published);
    });

    it('scopeDraft filters only draft records', function () {
        Page::create(['title' => 'Draft', 'slug' => 'draft', 'status' => PostStatus::Draft]);
        Page::create(['title' => 'Live', 'slug' => 'live', 'status' => PostStatus::Published]);

        $results = Page::draft()->get();

        expect($results)->toHaveCount(1);
        expect($results->first()->status)->toBe(PostStatus::Draft);
    });
});

describe('CmsModel soft deletes', function () {
    it('soft deletes a page', function () {
        $page = Page::create([
            'title' => 'To Delete',
            'slug' => 'to-delete',
            'status' => PostStatus::Draft,
        ]);

        $page->delete();

        expect(Page::count())->toBe(0);
        expect(Page::withTrashed()->count())->toBe(1);
    });

    it('can restore a soft-deleted page', function () {
        $page = Page::create([
            'title' => 'Deleted',
            'slug' => 'deleted',
            'status' => PostStatus::Draft,
        ]);
        $page->delete();

        $page->restore();

        expect(Page::count())->toBe(1);
    });
});

describe('CmsModel events', function () {
    it('dispatches CmsModelSaved event on save', function () {
        \Illuminate\Support\Facades\Event::fake([\Hydrat\GroguCMS\Events\CmsModelSaved::class]);

        Page::create([
            'title' => 'Event Test',
            'slug' => 'event-test',
            'status' => PostStatus::Draft,
        ]);

        \Illuminate\Support\Facades\Event::assertDispatched(\Hydrat\GroguCMS\Events\CmsModelSaved::class);
    });

    it('dispatches CmsModelDeleted event on delete', function () {
        \Illuminate\Support\Facades\Event::fake([\Hydrat\GroguCMS\Events\CmsModelDeleted::class]);

        $page = Page::create([
            'title' => 'Delete Event',
            'slug' => 'delete-event',
            'status' => PostStatus::Draft,
        ]);

        $page->delete();

        \Illuminate\Support\Facades\Event::assertDispatched(\Hydrat\GroguCMS\Events\CmsModelDeleted::class);
    });
});
