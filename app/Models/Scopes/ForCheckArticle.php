<?php
namespace App\Models\Scopes;

trait ForCheckArticle
{
    /**
     * 判断文章是否审核通过
     *
     * @param $query
     * @param $type
     * @return mixed
     */
    public function scopeIsCheck($query, $type)
    {
        return $query->where('is_check', $type);
    }
}