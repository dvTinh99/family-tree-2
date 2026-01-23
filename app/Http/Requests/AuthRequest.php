<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class AuthRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        Log::debug('vao rule');
        $method = $this->method();
        Log::debug('vao rule', [$method]);

        switch($method) {
            case 'GET' : {
                Log::debug('get ne');
                return $this->getRequest();
            }
            case 'POST' : {
                Log::debug('posst ne');
                return $this->postRequest();
            }
            case 'PUT' : {
                Log::debug('put ne');
                return $this->putRequest();
            }
            case 'DELETE' : {
                Log::debug('delete ne');
                return $this->deleteRequest();
            }
        }
    }

    public function getRequest(){
        return [];
    }
    public function postRequest(){
        $routeName = $this->route()->getName();
        Log::debug('vao post');
        switch($routeName) {
            case 'register.post' : {
                Log::debug('vao register');
                return [
                    'name' => 'required|string|max:255',
                    'email' => 'required|string|email|max:255|unique:users',
                    'password' => 'required|string|min:6|confirmed',
                ];
            }
            case 'login.post' : {
                Log::debug('vao login');
                return [
                    'email' => 'required|string|email|min:3|max:255',
                    'password' => 'required|string|min:6',
                ];
            }
        }
        return [];
    }
    public function putRequest(){
        return [];
    }
    public function deleteRequest(){
        return [];
    }
}
