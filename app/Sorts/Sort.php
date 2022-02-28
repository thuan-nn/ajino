<?php

namespace App\Sorts;

use App\Supports\Builder;
use App\Supports\Traits\DefaultSort;
use Illuminate\Http\Request;

abstract class Sort
{
    use DefaultSort;

    /**
     * The request instance.
     *
     * @var Request
     */
    private $request;

    /**
     * The builder instance.
     *
     * @var Builder
     */
    protected $query;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    protected function setupDefaultSort()
    {
        $defaultSort = 'defaultSort';
        if (method_exists($this, $defaultSort)) {
            $this->{$defaultSort}();
        }
    }

    /**
     * Apply the filters to the builder.
     *
     * @param Builder $query
     * @return Builder
     */
    public function apply(Builder $query)
    {
        $this->query = $query;

        if (! $this->sortBys()) {
            $this->setupDefaultSort();

            return $this->query;
        }

        foreach ($this->sortBys() as $method => $value) {
            if (! method_exists($this, $method)) {
                continue;
            }
            if ((is_string($value) && strlen($value)) || (is_array($value) && ! empty($value))) {
                $this->{$method}($value);
            }
        }

        return $this->query;
    }

    /**
     * Get request filters data.
     *
     * @return array
     */
    public function sortBys()
    {
        return $this->request->get('sortBy', []);
    }
}
