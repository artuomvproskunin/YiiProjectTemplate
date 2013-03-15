<?php

class ConfigTemplater {

    /**
     * Template body
     * @var string
     */
    protected $body = '';

    /**
     * Constructor
     * @param string $body template body
     */
    public function __construct($body) {
        $this->body = $body;
    }

    /**
     * Renders the template using provided vars
     * @param array $vars key-value pairs of variables and their values
     * @return mixed
     */
    public function render($vars = array()) {
        $delimiter = uniqid();

        $result = $this->body;

        $keys = array_keys($vars);

        foreach ($keys as $key) {
            $result = str_replace("%%{$key}%%", "{$delimiter}.{$key}.{$delimiter}", $result);
        }

        $search  = array_map(function ($name) use ($delimiter) { return "{$delimiter}.{$name}.{$delimiter}"; }, $keys);
        $replace = array_values($vars);

        return str_replace($search, $replace, $result);
    }
}
