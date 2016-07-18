<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContributeTag extends Model
{
    protected $table = 'contribute_tags';

    protected $fillable = ['name'];

    public function articles()
    {
        return $this->belongsToMany(PublishingArticle::class)->withTimestamps();
    }

}
