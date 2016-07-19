<?php

namespace App\Models;

use App\Models\Traits\ModelEventsTrait;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    use ModelEventsTrait;
}
