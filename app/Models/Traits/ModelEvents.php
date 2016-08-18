<?php
namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

trait ModelEvents
{

    /**
     * 判断文章是否审核通过
     *
     * @param Builder $query
     * @param $type
     * @return $this
     */
    public function scopeIsCheck(Builder $query, $type)
    {
        return $query->where('is_check', $type);
    }

    /**
     * 发表时间
     *
     * @param Builder $query
     */
    public function scopePublished(Builder $query)
    {
        $query->where('published_at', '<=', Carbon::now());
    }

    /**
     * 推荐分类
     *
     * @param Builder $query
     * @return $this
     */
    public function scopeRecommend(Builder $query)
    {
        return $query->where('slug', 'recommend');
    }

    /**
     * 其他分类
     *
     * @param Builder $query
     * @return $this
     */
    public function scopeDefault(Builder $query)
    {
        return $query->where('slug', 'default');
    }

    /**
     * 按期数降序排序
     *
     * @param Builder $query
     * @return $this
     */
    public function scopeLatestByIssue(Builder $query)
    {
        return $query->latest('issue');
    }
}