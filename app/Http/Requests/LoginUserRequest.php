<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginUserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:2',
        ];
    }

    public function failedValidation(Validator $validator){
        throw new HttpResponseException(response()->json(
            [
                'success'=>false,
                'error'=>true,
                'message'=>'Erreur de validation',
                'ErrorList'=>$validator->errors()
            ]
        ));
    }

    public function messages()
    {
        return[
            'email.required'=>'L\'adresse email est obligatoire',
            'email.email'=>'Adresse email non valide',
            'email.exists'=>'Cet adresse email n\'existe pas',
            'password.required'=>'Le mot de passe est obligatoire'
        ];
    }
}
