<?php

namespace App\Models;
use Backpack\CRUD\app\Models\Traits\CrudTrait;


use Illuminate\Database\Eloquent\Model;

class Unmapped extends Model{
    use CrudTrait;
    protected $table = 'unmapped_views';

}