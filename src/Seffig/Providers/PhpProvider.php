<?php
namespace Seffig\Providers;

class PhpProvider implements ProviderInterface
{
    protected $fileName;

    public function __construct($fileName)
    {
        $this->fileName = $fileName;
    }

    public function load()
    {
        $returnValue = include($this->fileName);
    }
}
