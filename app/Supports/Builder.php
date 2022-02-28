<?php

namespace App\Supports;

use App\Filters\EloquentFilter;
use App\Filters\Filter;
use App\Sorts\Sort;
use Closure;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Builder as BaseBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Arr;

class Builder extends BaseBuilder implements EloquentFilter
{
    /**
     * @param Filter $filter
     *
     * @return Builder
     */
    public function filter(Filter $filter)
    {
        return $filter->apply($this);
    }

    /**
     * @param Sort $sort
     *
     * @return Builder
     */
    public function sortBy(Sort $sort)
    {
        return $sort->apply($this);
    }

    /**
     * @param Closure|string|array $column
     * @param string|null $value
     *
     * @return $this
     */
    public function whereStartsWith($column, $value = null)
    {
        return $this->where($column, 'like', $value.'%');
    }

    /**
     * @param Closure|string|array $column
     * @param string|null $value
     *
     * @return $this
     */
    public function whereEndsWith($column, $value = null)
    {
        return $this->where($column, 'like', '%'.$value);
    }

    /**
     * @param Closure|string|array $column
     * @param string|null $value
     *
     * @return $this
     */
    public function whereLike($column, $value = null)
    {
        return $this->where($column, 'like', '%'.$value.'%');
    }

    /**
     * @param Closure|string|array $column
     * @param string|null $value
     *
     * @return $this
     */
    public function whereEqual($column, $value = null)
    {
        return $this->where($column, '=', $value);
    }

    /**
     * @param Closure|string|array $column
     * @param string|null $value
     *
     * @return $this
     */
    public function whereNotEqual($column, $value = null)
    {
        return $this->where($column, '<>', $value);
    }

    /**
     * @param string $column
     * @param array $value
     *
     * @return QueryBuilder
     */
    public function whereDateRange($column, array $value = [])
    {
        $from = Arr::get($value, 'from', '');
        $to = Arr::get($value, 'to', '');

        return $this->query->where(function (QueryBuilder $query) use ($column, $from, $to) {
            return $query
                ->when($from, function (QueryBuilder $query) use ($column, $from) {
                    return $query->where($column, '>=', $from);
                })
                ->when($to, function (QueryBuilder $query) use ($column, $to) {
                    return $query->where($column, '<=', $to);
                });
        });
    }

    public function whereDateTime($column, $operator = null, $value = null)
    {
        if ($value instanceof DateTimeInterface) {
            $value = $value->format('H:i:s');
        }

        return $this->where($column, $operator, $value);
    }

    /**
     * Paginate the given query.
     *
     * @param  int|null  $perPage
     * @param  array  $columns
     * @param  string  $pageName
     * @param  int|null  $page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     *
     * @throws \InvalidArgumentException
     */
    public function paginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null)
    {
        $page = $page ?: Paginator::resolveCurrentPage($pageName);

        $total = $this->toBase()->getCountForPagination();

        $perPage = $perPage ?: ($total!=0 ? $total : 1);

        $results = $total
            ? $this->forPage($page, $perPage)->get($columns)
            : $this->model->newCollection();

        return $this->paginator($results, $total, $perPage, $page, [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => $pageName,
        ]);
    }

    public function whereUnicode($keySearch, $column)
    {
        $checkKey = preg_match('[d|D]', $keySearch);

        if ((boolean) $checkKey) {
            $keySearchRegex = preg_replace('[d|D]', 'đ', $keySearch);

            return $this->whereHas('translations', function ($query) use ($column, $keySearchRegex, $keySearch) {
                $query->where($column, 'like', '%'.$keySearchRegex.'%')->orWhere($column, 'like', '%'.$keySearch.'%');
            });
        }

        return $this->whereTranslationLike($column, '%'.$keySearch.'%');
    }
}
