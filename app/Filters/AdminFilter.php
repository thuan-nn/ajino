<?php


namespace App\Filters;


class AdminFilter extends Filter {
    /**
     * @param $name
     */
    public function name($name) {
        return $this->query->whereLike('name', $name);
    }

    /**
     * @param $email
     * @return \App\Supports\Builder
     */
    public function email($email) {
        return $this->query->whereLike('email', $email);
    }

    /**
     * @param $name
     */
    public function role_name($name) {
        return $this->query->whereHas('roles', function ($q) use ($name) {
           return $q->whereLike('display_name', $name);
        });
    }
}
