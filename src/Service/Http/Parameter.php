<?php

declare(strict_types=1);

namespace App\Service\Http;

class Parameter
{
    private $parameter;

    public function __construct(array $parameter)
    {
        $this->parameter = $parameter;
    }

    public function get(string $name)
    {
        if (isset($this->parameter[$name])) {
            $res = addslashes(htmlspecialchars($this->parameter[$name]));
            return $res;
        }
    }

    public function getWithoutHtml(string $name)
    {
        if (isset($this->parameter[$name])) {
            $res = $this->parameter[$name];
            return $res;
        }
    }
    
    public function set(string $name, string $value): void
    {
        $name = addslashes(htmlspecialchars($this->parameter[$name]));
        $value = addslashes(htmlspecialchars($value));
        $name = $value;
    }
}
