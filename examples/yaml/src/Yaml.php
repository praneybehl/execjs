<?php

namespace Chenos\ExecJs\Yaml;

use Chenos\ExecJs\Engine;

class Yaml extends Engine
{
    protected $yaml;

    public function initialize()
    {
        $this->loader
            ->setEntryDirectory(__ROOT__)
            ->addVendorDirectory(__ROOT__.'/node_modules')
            ->addOverride('js-yaml', 'js-yaml/dist/js-yaml.js')
            ;

        $this->yaml = $this->executeString("var jsyaml = require('js-yaml'); jsyaml");
    }

    public function load($string)
    {
        return (array) $this->yaml->load($string);
    }

    public function loadFile($file)
    {
        if ($string = $this->loader->loadModule($file, false)) {
            return $this->load($string);
        }

        return false;
    }

    public function dump($array)
    {
        $str = sprintf('jsyaml.dump(%s)', json_encode($array));

        return $this->executeString($str);
    }
}
