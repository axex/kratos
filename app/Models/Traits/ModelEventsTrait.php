<?php
namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

trait ModelEventsTrait
{
    /**
     * 判断文章是否审核通过
     *
     * @param $query
     * @param $type
     * @return mixed
     */
    public function scopeIsCheck(Builder $query, $type)
    {
        return $query->where('is_check', $type);
    }

    public function scopePublished(Builder $query)
    {
        $query->where('published_at', '<=', Carbon::now());
    }

    // 推荐分类
    public function scopeRecommend(Builder $query)
    {
        return $query->where('slug', 'recommend');
    }

    // 其他分类
    public function scopeOther(Builder $query)
    {
        return $query->where('slug', 'other');
    }
}