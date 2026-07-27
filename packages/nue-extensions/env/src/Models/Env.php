<?php

namespace Nue\Env\Models;

use Illuminate\Database\Eloquent\Model;

class Env extends Model
{
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    private $env;

    public function __construct(array $attributes = [])
    {
        $this->env = base_path() . '/.env';

        parent::__construct($attributes);
    }

    /**
     * Get .env variable.
     * 
     * @param null $id
     * @return array|mixed
     */
    public function getEnv($id = null)
    {
        $string = file_get_contents($this->env);
        $string = preg_split('/\n+/', $string);
        $array = [];
        
        foreach ($string as $k => $one) 
        {
            if (preg_match('/^(#\s)/', $one) === 1 || preg_match('/^([\\n\\r]+)/', $one)) {
                continue;
            }
            
            $entry = explode("=", $one, 2);
            if (!empty($entry[0])) {
                $array[] = ['id' => $k + 1, 'key' => $entry[0], 'value' => isset($entry[1]) ? $entry[1] : null];
            }
        }

        if (empty($id)) {
            return $array;
        }
        
        $index = array_search($id, array_column($array, 'id'));

        return $array[$index];
    }

    public static function with($relations)
    {
        return new static;
    }

    public function findOrFail($id)
    {
        $item = $this->getEnv($id);

        return static::newFromBuilder($item);
    }


    public function save(array $options = [])
    {
        $data = $this->getAttributes();

        return $this->setEnv($data['key'], $data['value']);
    }

    /**
     * @param $id
     * @return bool|null|void
     */
    public function deleteEnv($id)
    {
        $ids = explode(',', $id);
        $data = $this->getEnv();
        
        foreach ($ids as $val) {
            $index = array_search($val, array_column($data, 'id'));
            unset($data[$index]);
        }
        
        return $this->saveEnv($data);
    }

    /**
     * Update or create .env variable.
     * 
     * @param $key
     * @param $value
     * @return bool
     */
    private function setEnv($key, $value)
    {
        $array = $this->getEnv();
        $index = array_search($key, array_column($array, 'key'));

        if ($index !== false) {
            $array[$index]['value'] = $value;
        } else {
            array_push($array, ['key' => $key, 'value' => $value]);
        }
        return $this->saveEnv($array);
    }

    /**
     * Save .env variable.
     * 
     * @param $array
     * @return bool
     */
    private function saveEnv($array)
    {
        if (is_array($array)) {
            $newArray = [];
            $i = 0;
            foreach ($array as $env) {
                if (preg_match('/\s/', $env['value']) > 0 && (strpos($env['value'], '"') > 0 && strpos($env['value'], '"', -0) > 0)) {
                    $env['value'] = '"'.$env['value'].'"';
                }
                $newArray[$i] = $env['key']."=".$env['value'];
                $i++;
            }
            $newArray = implode("\n", $newArray);
            file_put_contents($this->env, $newArray);
            return true;
        }
        return false;
    }

}