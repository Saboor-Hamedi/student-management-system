<?php
namespace Thesis\functions;

class ServiceLocator
{
    private static $instance;
    private $resources = [];

    private function __construct() {}

    public function get($key)
    {
        if (isset($this->resources[$key])) {
            return $this->resources[$key];
        } else {
            // Handle resource not found error
            return null;
        }
    }

    public function set($key, $value)
    {
        $this->resources[$key] = $value;
    }
}
