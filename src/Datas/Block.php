<?php

namespace Hydrat\GroguCMS\Datas;

use Illuminate\Support\Fluent;
use ArrayAccess;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use JsonSerializable;

class Block implements Jsonable, JsonSerializable
{
    public function __construct(
        public string $type,
        public Fluent $data,
    ) {
        //
    }

    public function toArray()
    {
        return [
            'type' => $this->type,
            'data' => $this->data->toArray(),
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['type'],
            new Fluent($data['data']),
        );
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getData(): Fluent
    {
        return $this->data;
    }

    public function with(array $data = []): self
    {
        $this->data = new Fluent(array_merge($this->data->toArray(), $data));

        return $this;
    }

    /**
     * Convert the object into something JSON serializable.
     *
     * @return array<TKey, TValue>
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    /**
     * Convert the fluent instance to JSON.
     *
     * @param  int  $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->jsonSerialize(), $options);
    }
}
