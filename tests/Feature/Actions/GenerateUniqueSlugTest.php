<?php

use Hydrat\GroguCMS\Actions\GenerateUniqueSlug;
use Hydrat\GroguCMS\Enums\PostStatus;
use Hydrat\GroguCMS\Models\Page;

describe('GenerateUniqueSlug', function () {
    it('generates a slug from a title', function () {
        $slug = GenerateUniqueSlug::run('Hello World', Page::class);

        expect($slug)->toBe('hello-world');
    });

    it('returns an empty string when title is null', function () {
        $slug = GenerateUniqueSlug::run(null, Page::class);

        expect($slug)->toBe('');
    });

    it('returns an empty string when title is empty string', function () {
        $slug = GenerateUniqueSlug::run('', Page::class);

        expect($slug)->toBe('');
    });

    it('generates a unique slug when the base slug already exists', function () {
        Page::create([
            'title' => 'My Page',
            'slug' => 'my-page',
            'status' => PostStatus::Draft,
        ]);

        $slug = GenerateUniqueSlug::run('My Page', Page::class);

        expect($slug)->toBe('my-page-1');
    });

    it('increments the suffix for each duplicate', function () {
        Page::create(['title' => 'Blog', 'slug' => 'blog', 'status' => PostStatus::Draft]);
        Page::create(['title' => 'Blog', 'slug' => 'blog-1', 'status' => PostStatus::Draft]);

        $slug = GenerateUniqueSlug::run('Blog', Page::class);

        expect($slug)->toBe('blog-2');
    });

    it('uses the existing model slug when model is provided', function () {
        $page = Page::create([
            'title' => 'Existing',
            'slug' => 'custom-slug',
            'status' => PostStatus::Draft,
        ]);

        // When model has a slug, it uses that slug (avoids slugifying the title again)
        $slug = GenerateUniqueSlug::run('Existing', Page::class, $page);

        expect($slug)->toBe('custom-slug');
    });

    it('excludes the given model from the uniqueness check', function () {
        $page = Page::create([
            'title' => 'My Article',
            'slug' => 'my-article',
            'status' => PostStatus::Draft,
        ]);

        // Updating the same page shouldn't count as a conflict
        $slug = GenerateUniqueSlug::run('My Article', Page::class, $page);

        expect($slug)->toBe('my-article');
    });

    it('handles special characters in titles', function () {
        $slug = GenerateUniqueSlug::run("L'été est là!", Page::class);

        expect($slug)->toBeString()->not->toBeEmpty()->not->toContain("'");
    });
});
