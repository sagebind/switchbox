<?php
namespace Switchbox\Providers;

use VARIANT;
use COM;
use Switchbox\ConfigurationProperty;
use Switchbox\ConfigurationValue;

class WindowsRegistryProvider implements ProviderInterface
{
    const HKEY_CLASSES_ROOT = 0x80000000;
    const HKEY_CURRENT_USER = 0x80000001;
    const HKEY_LOCAL_MACHINE = 0x80000002;
    const HKEY_USERS = 0x80000003;
    const HKEY_CURRENT_CONFIG = 0x80000005;

    const REG_SZ = 1;
    const REG_EXPAND_SZ = 2;
    const REG_BINARY = 3;
    const REG_DWORD = 4;
    const REG_MULTI_SZ = 7;

    protected $defKey;
    protected $keyPath;

    public function __construct($defKey, $keyPath)
    {
        $this->defKey = $defKey;
        $this->keyPath = $keyPath;
    }

    public function load()
    {
        $stdRegProv = new COM('winmgmts://./root/default:StdRegProv');

        $config = $this->getNodeFromKey($this->keyPath, $stdRegProv);

        $stdRegProv = null;

        return $config;
    }

    public function save(ConfigurationProperty $config)
    {
    }

    private function getNodeFromKey($keyPath, $stdRegProv)
    {
        $keyNode = new ConfigurationProperty(basename($keyPath));

        // get values in the key
        $valueNamesEnum = new VARIANT();
        $valueTypesEnum = new VARIANT();
        if ($stdRegProv->EnumValues($this->defKey, $keyPath, $valueNamesEnum, $valueTypesEnum) === 0)
        {
            // make sure the enums aren't empty
            if ((variant_get_type($valueNamesEnum) & VT_ARRAY) === VT_ARRAY && (variant_get_type($valueTypesEnum) & VT_ARRAY) === VT_ARRAY)
            {
                $valueTypes = array();

                // enumerate over each key value type
                foreach ($valueTypesEnum as $valueType)
                {
                    $valueTypes[] = $valueType;
                }

                // enumerate over each key value name
                $i = 0;
                foreach ($valueNamesEnum as $valueName)
                {
                    // get a property for the key value
                    $valueNode = $this->getNodeFromValue($keyPath, $valueName, $valueTypes[$i], $stdRegProv);

                    // null means type was unreadable
                    if ($valueNode !== null)
                    {
                        // create a property value for the key value data
                        $keyNode->appendChild($valueNode);
                    }

                    $i++;
                }
            }
        }

        // get all subkeys
        $subKeysEnum = new VARIANT();
        if ($stdRegProv->EnumKey($this->defKey, $keyPath, $subKeysEnum) === 0)
        {
            // make sure the enum isn't empty
            if ((variant_get_type($subKeysEnum) & VT_ARRAY) === VT_ARRAY)
            {
                // enumerate over each subkey
                foreach ($subKeysEnum as $subKey)
                {
                    // recursively append a child property for the subkey
                    $keyNode->appendChild($this->getNodeFromKey($keyPath . '\\' . $subKey, $stdRegProv));
                }
            }
        }

        return $keyNode;
    }

    private function getNodeFromValue($keyPath, $valueName, $valueType, $stdRegProv)
    {
        // create a property for the key value name
        $valueNode = new ConfigurationProperty((string)$valueName);
        $valueNode->setUniparousity(true);

        // create a variant to store the key value data
        $valueData = new VARIANT();

        // get the value data type
        switch ($valueType)
        {
            // string type
            case self::REG_SZ:
                // get the data of the value
                $stdRegProv->GetStringValue($this->defKey, $keyPath, $valueName, $valueData);
                $valueNode->appendChild(new ConfigurationValue((string)$valueData));
                break;

            // expanded string type
            case self::REG_EXPAND_SZ:
                // get the data of the value
                $stdRegProv->GetExpandedStringValue($this->defKey, $keyPath, $valueName, $valueData);
                $valueNode->appendChild(new ConfigurationValue((string)$valueData));
                break;

            // binary type
            case self::REG_BINARY:
                // get the data of the value
                $stdRegProv->GetBinaryValue($this->defKey, $keyPath, $valueName, $valueData);
                $binaryString = '';

                // enumerate over each byte
                if ((variant_get_type($valueData) & VT_ARRAY) === VT_ARRAY)
                {
                    foreach ($valueData as $byte)
                    {
                        // add the byte code to the byte string
                        $binaryString .= chr((int)$byte);
                    }
                }

                // add the binary string as a value
                $valueNode->appendChild(new ConfigurationValue($binaryString));
                break;

            // int type
            case self::REG_DWORD:
                // get the data of the value
                $stdRegProv->GetDWORDValue($this->defKey, $keyPath, $valueName, $valueData);
                $valueNode->appendChild(new ConfigurationValue((int)$valueData));
                break;

            // string array type
            case self::REG_MULTI_SZ:
                // get the data of the value
                $stdRegProv->GetMultiStringValue($this->defKey, $keyPath, $valueName, $valueData);
                $valueNode->setUniparousity(false);

                // enumerate over each sub string
                if ((variant_get_type($valueData) & VT_ARRAY) === VT_ARRAY)
                {
                    foreach ($valueData as $subValueData)
                    {
                        $valueNode->appendChild(new ConfigurationValue((string)$subValueData));
                    }
                }
                break;
        }

        return $valueNode;
    }
}
