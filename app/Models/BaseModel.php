<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseModel
 */
class BaseModel extends Model
{
    
    // Allow for camelCased attribute access
    public function getAttribute($key)
    {
        if (array_key_exists($key, $this->relations)) {
            return parent::getAttribute($key);
        } else {
            return parent::getAttribute(snake_case($key));
        }
    }
    
    public function setAttribute($key, $value)
    {
        return parent::setAttribute(snake_case($key), $value);
    }
    
    public function __isset($key)
    {
        return parent::__isset(snake_case($key));
    }
    
    public function __unset($key)
    {
        parent::__unset(snake_case($key));
    }
}
