<?php

namespace Hydrat\GroguCMS\Content;

use Hydrat\GroguCMS\Concerns\Extractable;
use Hydrat\GroguCMS\Datas\Block;
use Illuminate\Support\Str;

/**
 * @copyright Roots.io
 *
 * @link https://github.com/roots/acorn/blob/main/src/Roots/Acorn/block/Composer.php#L10
 */
abstract class BlockComposer
{
    use Extractable;

    /**
     * The list of blocks served by this composer.
     *
     * @var string[]
     */
    protected static $blocks;

    /**
     * The current block.
     *
     * @var \App\Cms\Block
     */
    protected $block;

    /**
     * The current block data.
     *
     * @var \Illuminate\Support\Fluent
     */
    protected $data;

    /**
     * The properties / methods that should not be exposed.
     *
     * @var array
     */
    protected $except = [];

    /**
     * The default properties / methods that should not be exposed.
     *
     * @var array
     */
    protected $defaultExcept = [
        'cache',
        'compose',
        'override',
        'toArray',
        'blocks',
        'with',
    ];

    /**
     * The list of blocks served by this composer.
     *
     * @return string|string[]
     */
    public static function blocks()
    {
        if (isset(static::$blocks)) {
            return static::$blocks;
        }

        $block = array_slice(explode('\\', static::class), 3);
        $block = array_map([Str::class, 'snake'], $block, array_fill(0, count($block), '-'));

        return implode('_', $block);
    }

    /**
     * Compose the block before rendering.
     *
     * @return void
     */
    public function compose(Block $block)
    {
        $this->block = $block;
        $this->data = $block->getData();

        $block->with($this->merge());
    }

    /**
     * The data passed to the block before rendering.
     *
     * @return array
     */
    protected function with()
    {
        return [];
    }

    /**
     * The override data passed to the block before rendering.
     *
     * @return array
     */
    protected function override()
    {
        return [];
    }

    /**
     * The merged data to be passed to block before rendering.
     *
     * @return array
     */
    protected function merge()
    {
        [$with, $override] = [$this->with(), $this->override()];

        return array_merge(
            $with,
            $this->data->toArray(),
            $override
        );
    }

    /**
     * Determine if the given property / method should be ignored.
     *
     * @param  string  $name
     * @return bool
     */
    protected function shouldIgnore($name)
    {
        return str_starts_with($name, '__') ||
            in_array($name, $this->ignoredMethods());
    }

    /**
     * Get the methods that should be ignored.
     *
     * @return array
     */
    protected function ignoredMethods()
    {
        return array_merge($this->defaultExcept, $this->except);
    }
}
