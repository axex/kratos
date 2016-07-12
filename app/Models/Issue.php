<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Issue
 *
 * @property integer $id
 * @property integer $issue
 * @property \Carbon\Carbon $published_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|Article[] $articles
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Issue whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Issue whereIssue($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Issue wherePublishedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Issue whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Issue whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Issue published()
 */
class Issue extends Model
{
    protected $table = 'issues';

    protected $guarded = [];

    // 把 published_at 当作 Carbon 类型，这样后面对时间处理方便很多
    protected $dates = ['published_at'];

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function scopePublished($query)
    {
        $query->where('published_at', '<=', Carbon::now());
    }
}
