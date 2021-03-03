<?php
namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreUser extends FormRequest
{
    /*
     * Determina se o usuário está autorizado
     * @return bool
     */

    public function authorize()
    {
        return true;
    }

    /*
     * Regras de validação
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'unique:users,email|email|required',
            'name'  => 'required',
            'password' => 'required'
        ];
    }

    /*
     * Configurar a validação
     *
     * return void()
     */
    public function withValidator($validator)
    {
        if($validator->fails()){
            throw new HttpResponseException(response()->json([
                'msg' => 'Ops! Algum campo não foi preenchido.',
                'status' => false,
                'errors' => $validator->errors(),
                'url'   => route('users.store')
            ],403));
        }
    }
}
