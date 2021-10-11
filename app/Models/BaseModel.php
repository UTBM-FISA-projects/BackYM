<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BaseModel extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Récupère la classe depuis son FQN et traduit en snake_case
        $class = Str::snake(class_basename(get_called_class()));

        $this->table = $class;
        $this->primaryKey = "id_$class";
    }
}
