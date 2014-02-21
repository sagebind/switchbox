<?php
namespace Seffig\Providers;

class IniProvider implements ProviderInterface
{
    protected $fileName;
    protected $processSections = true;

    public function __construct($fileName, $processSections = true)
    {
        $this->fileName = $fileName;
        $this->processSections = $processSections;
    }

    public function load()
    {
        if (!file_exists($this->fileName))
        {
            throw new ProviderException("Cannot load from file '{$this->fileName}': The file does not exist.");
        }

        // load the ini keys into an array
        $array = parse_ini_file($this->fileName, $this->processSections, INI_SCANNER_RAW);

        // check for parse errors
        if ($array === false)
        {
            throw new ProviderException("Syntax error in file '{$this->fileName}'.");
        }

        // return the array as a property collection
        return PropertyCollection::fromArray($array);
    }

    public function save(PropertyCollection $properties)
    {
        if (!$stream = fopen($this->fileName, 'w'))
        {
            throw new ProviderException("Could not open file '{$this->fileName}'.");
        }

        if ($this->processSections)
        {
            $sections = array();
            
            foreach ($properties as $name => $value)
            {
                if ($properties->isCollection($name))
                {
                    $sections[$name] = $value;
                }
                else
                {
                    // write out property
                }
            }

            foreach ($sections as $section => $value)
            {
                fwrite($stream, "[$name]" . PHP_EOL);
                $this->writeProperties($value, $stream);
                fwrite($stream, PHP_EOL);
            }
        } 
        
        else
        {
            $this->writeProperties($properties, $stream);
        }

        fclose($stream);
    }

    private function writeProperties($stream, PropertyCollection $properties)
    {
        foreach ($assoc_arr as $key=>$elem) { 
            if(is_array($elem)) 
            { 
                for($i=0;$i<count($elem);$i++) 
                { 
                    $content .= $key2."[] = \"".$elem[$i]."\"\n"; 
                } 
            } 
            else if($elem=="") $content .= $key2." = \n"; 
            else $content .= $key2." = \"".$elem."\"\n"; 
        }
    }
}
