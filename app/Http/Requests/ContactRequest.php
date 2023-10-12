<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Contracts\Service\Attribute\Required;

class ContactRequest extends FormRequest
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
            'prenom' => 'required|min:3',
            'nom' => 'required|min:2',
            'adresse' => 'required|min:3',
            'telephone' => 'required|min:9'
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
            'prenom.required'=>'Le prenom est obligatoire',
            'nom.required'=>'Le nom est obligatoire',
            'adresse.required'=>"L'adressse est obligatoire",
            'telephone.required'=>'Le numéro de téléphone est obligatoire'
        ];
    }
}
