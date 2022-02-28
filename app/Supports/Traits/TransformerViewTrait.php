<?php

namespace App\Supports\Traits;

use Illuminate\Database\Eloquent\Builder;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;

trait TransformerViewTrait
{
    /**
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param $transformerClass
     * @param int $perPage
     * @return array
     */
    public function transformPagination(Builder $builder, $transformerClass, $perPage = 12)
    {
        $paginatorBuilder = $builder->paginate($perPage);
        $posts = $paginatorBuilder->getCollection();

        $resource = new Collection($posts, $transformerClass);
        $resource->setPaginator(new IlluminatePaginatorAdapter($paginatorBuilder));

        $paginatorInstance = $resource->getPaginator();

        return [
            'data'       => $resource->getData(),
            'pagination' => $paginatorBuilder,
            'total'      => $paginatorInstance->getTotal(),
        ];
    }
}
