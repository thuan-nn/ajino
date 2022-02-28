<?php


namespace App\Filters;


class PermissionFilter extends Filter {
    /**
     * Filter user by name
     *
     * @param string $name
     *
     * @return \App\Supports\Builder
     */
    public function name($name) {
        return $this->query->whereLike('name', $name);
    }

    /**
     * @param $displayName
     *
     * @return \App\Supports\Builder
     */
    public function display_name($displayName) {
        return $this->query->whereLike('display_name', $displayName);
    }
}
