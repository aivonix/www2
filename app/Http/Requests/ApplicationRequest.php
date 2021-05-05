<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ApplicationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth::user();
        $roles = array_column($user->roles->toArray(), 'role');
        if(count(array_intersect([env('ROLE_ADMIN_APPS', '')], $roles)) > 0){
            return true;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'charity_id' => 'required|integer',
            'user_id' => 'required|integer',
            'stage' => 'required|string'
        ];
    }
}
