<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Category
 *
 * @property integer $id
 * @property string $name
 * @property string $slug 缩略名
 * @property string $desc
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|Article[] $articles
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category whereDesc($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category recommend()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category other()
 */
class Category extends Model
{
    protected $table = 'categories';

    protected $guarded = [];


    public function articles()
    {
        // $category->articles 即可拿到该栏目下的所有文章
        return $this->hasMany(Article::class);
    }

    // 推荐分类
    public function scopeRecommend($query)
    {
        return $query->where('slug', 'recommend');
    }

    // 其他分类
    public function scopeOther($query)
    {
        return $query->where('slug', 'other');
    }
}
