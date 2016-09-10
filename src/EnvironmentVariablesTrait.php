<?php

namespace Bluora\SharedApiTraits;

trait EnvironmentVariablesTrait
{
    /**
     * Set an environment variable.
     *
     * @param string $env_name
     *
     * @return IsbnPlus
     */
    public function setEnv($env_name, $config)
    {
        $method = 'setClient'.ucfirst(strtolower($env_name));
        $property = 'client_'.strtolower($env_name);
        $set_value = (getenv($this->env_name.strtoupper($env_name))) ? getenv($this->env_name.strtoupper($env_name)) : '';
        if (isset($config[$env_name])) {
            $set_value = $config[$env_name];
        }
        if (!empty($set_value)) {
            if (method_exists($this, $method)) {
                return $this->$method($set_value);
            } elseif (property_exists($this, $property)) {
                $this->$property = $set_value;
            }
        }
        return $this;
    }

    /**
     * Check if this client has been provided a property value.
     *
     * @param $name
     *
     * @return bool
     */
    public function hasConfig($name)
    {
        if (property_exists($this, 'client_'.$name)) {
            $name = 'client_'.$name;
            return !empty($this->$name);
        }
        return false;
    }

    /**
     * Set a config variable.
     *
     * @param string $name
     * @param string $value
     *
     * @return IsbnPlus
     */
    public function setConfig($name, $value)
    {
        if (property_exists($this, 'client_'.$name) && !empty($value)) {
            $name = 'client_'.$name;
            $this->$name = $value;
        }

        return $this;
    }
}
