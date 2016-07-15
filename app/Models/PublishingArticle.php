<?php

namespace App\Models;

use App\Models\Scopes\ForCheckArticle;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Article
 *
 * @property integer $id
 * @property integer $issue_id 期数
 * @property integer $category_id 栏目id
 * @property string $title
 * @property string $desc
 * @property string $url 原文链接
 * @property string $presenter 推荐者
 * @property boolean $sort
 * @property boolean $is_recomm 是否推荐
 * @property boolean $is_check 是否审核
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read Category $category
 * @property-read Issue $issue
 * @property-read \Illuminate\Database\Eloquent\Collection|Tag[] $tags
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Article whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Article whereIssueId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Article whereCategoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Article whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Article whereDesc($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Article whereUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Article wherePresenter($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Article whereSort($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Article whereIsRecomm($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Article whereIsCheck($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Article whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Article whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Article isCheck($type)
 */
class PublishingArticle extends Model
{
    use ForCheckArticle;

    protected $table = 'publishing_articles';
    protected $guarded = [];

    public function category()
    {
        // $article->category 拿到文章所属的栏目
        return $this->belongsTo(Category::class);
    }

    public function issue()
    {
        return $this->belongsTo(Issue::class);
    }
    
    public function tags()
    {
        // withTimestamps() 用来同步时间, 不然在 article_tag 表里面时间的空的
        return $this->belongsToMany(PublishingTag::class)->withTimestamps();
    }

}
