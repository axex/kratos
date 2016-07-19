<?php

namespace App\Models;

class ContributeTag extends BaseModel
{
    protected $table = 'contribute_tags';

    protected $fillable = ['name'];

    public function articles()
    {
        return $this->belongsToMany(PublishingArticle::class)->withTimestamps();
    }

}
