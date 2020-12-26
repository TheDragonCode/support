<?php

namespace Helldar\Support\Helpers;

class Filesystem
{
    public function store(array $array, string $path, bool $is_json = false, bool $sort_keys = false): void
    {
        $is_json
            ? $this->storeArrayAsJson($array, $path, $sort_keys)
            : $this->storeArrayAsArray($array, $path, $sort_keys);
    }

    public function storeArrayAsJson(array $array, string $path, bool $sort_keys = false): void
    {
        if ($sort_keys) {
            ksort($array);
        }

        $replace = ['{{slot}}' => json_encode($array)];

        $content = Stub::replace(Stub::LANG_JSON, $replace);

        $this->put($path, $content);
    }

    public function storeArrayAsArray(array $array, string $path, bool $sort_keys = false): void
    {
        if ($sort_keys) {
            ksort($array);
        }

        $replace = ['{{slot}}' => var_export($array, true)];

        $content = Stub::replace(Stub::CONFIG_FILE, $replace);

        $this->put($path, $content);
    }

    public function put(string $path, string $content): void
    {

    }
}
