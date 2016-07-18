<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ArticleTag
 *
 * @property integer $article_id
 * @property integer $tag_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ArticleTag whereArticleId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ArticleTag whereTagId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ArticleTag whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ArticleTag whereUpdatedAt($value)
 */
class PublishingArticleTag extends Model
{
    /*
     * 本类只是在生成测试数据时才有用
     *
     *
     */
    protected $table = 'publishing_article_tag';

    protected $guarded = [];
}
