<?php


namespace App\Filters;


class RoleFilter extends Filter {
    /**
     * @param $name
     */
    public function name($name) {
        return $this->query->whereLike('name', $name);
    }

    /**
     * @param $guardName
     *
     * @return \App\Supports\Builder
     */
    public function guard_name($guardName) {
        return $this->query->whereLike('guard_name', $guardName);
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
