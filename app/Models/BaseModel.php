<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class BaseModel extends \Illuminate\Database\Eloquent\Model
{
    use HasFactory;

    public $timestamps = false;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Récupère le dernier élément du FQN en minuscule, soit la classe en minuscule
        $class = strtolower(last(explode('\\', get_called_class())));

        $this->table = $class;
        $this->primaryKey = "id_$class";
    }
}
