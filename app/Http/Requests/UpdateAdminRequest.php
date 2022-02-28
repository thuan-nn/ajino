<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        $admin = null;

        if ($this->admin) {
            $admin = $this->admin->id;
        } else {
            $admin = request()->id;
        }
        return [
            'name'     => 'filled|string',
            'email'    => 'filled|string|email|unique:admins,email,'.$admin,
            'password' => 'nullable|string|confirmed|min:8',
            'role_id'  => 'nullable|array|exists:roles,id'
        ];
    }
}
