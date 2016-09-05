<?php

namespace App\Models;

use App\Models\Traits\ModelEvents;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    use ModelEvents;
}
