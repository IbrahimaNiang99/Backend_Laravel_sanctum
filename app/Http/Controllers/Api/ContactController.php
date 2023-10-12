<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use Exception;

class ContactController extends Controller
{
    public function listeContact(){
        try {
            $listeContact = Contact::all();
            return $listeContact;

        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function ajoutContact(ContactRequest $contactRequest){
        try {
            $contact = new Contact();
            $contact->prenom = $contactRequest->prenom;
            $contact->nom = $contactRequest->nom;
            $contact->adresse = $contactRequest->adresse;
            $contact->telephone = $contactRequest->telephone;
            $contact->user_id = auth()->user()->id;
            $contact->save();

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Enregistrement effectué',
                'data' => $contact
            ]);

        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function updateContact(ContactRequest $contactRequest, Contact $contact){
        try {
            $contact->prenom = $contactRequest->prenom;
            $contact->nom = $contactRequest->nom;
            $contact->adresse = $contactRequest->adresse;
            $contact->telephone = $contactRequest->telephone;

            if ($contact->user_id === auth()->user()->id) {
                $contact->user_id = auth()->user()->id;
                $contact->save();
                return response()->json([
                    'status_code' => 200,
                    'status_message' => 'Modification effectué',
                    'data' => $contact
                ]);
            }else {
                return response()->json([
                    'status_code' => 422,
                    'status_message' => 'Vous n\'etes pas le créateur de ce contact'
                ]);
            } 

        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function deleteContact(Contact $contact){
        try {
            if ($contact->user_id === auth()->user()->id) {
                $contact->delete();
                return response()->json([
                        'status_code' => 200,
                        'status_message' => 'Contact supprimé'
                    ]);
            }else {
                return response()->json([
                    'status_code' => 422,
                    'status_message' => 'Vous n\'etes pas le créateur de ce contact'
                ]);
            }
            
        } catch (Exception $e) {
            return response()->json($e);
        }
    }
}
