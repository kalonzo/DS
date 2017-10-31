<?php

namespace App\Http\Requests;

use App\Models\User;

class StoreBooking extends \App\Http\FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }
    
    public function withValidator(\Illuminate\Validation\Validator $validator){
        $validator->after(function ($validator) {
            if(!empty($this->get('email'))){
                $userQuery = User::where('email', 'LIKE', $this->get('email'));
                if ($userQuery->exists()) {
                    $userActivated = $userQuery->where('status', '=', User::STATUS_ACTIVE)->exists();
                    if($userActivated){
                        $validator->errors()->add('email', "Cette adresse email n'est pas disponible. Si ce compte vous appartient, "
                                . "veuillez vous connecter avant d'envoyer votre demande de réservation.");
                    }
                }
            }

            if(!empty($this->get('invited_emails'))){
                $guestMailError = false;
                $guestsEmailArray = explode(',', $this->get('invited_emails'));
                foreach($guestsEmailArray as $guestsEmail){
                    if (!filter_var(trim($guestsEmail), FILTER_VALIDATE_EMAIL)) {
                        $guestMailError = true;
                        break;
                    }
                }
                if($guestMailError){
                    $validator->errors()->add('invited_emails', "Le format de l'une des adresses email saisies n'est pas correct.");
                }
            }
        });
    }
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        $dateNow = date('d/m/Y');
        $rules = [
            'email' => 'required|email',
            'firstname' => 'required|min:2|max:255',
            'lastname' => 'required|min:2|max:255',
            'phone_number' => 'required|regex:/^[0-9 ]+$/',
            'time_reservation' => 'required|date_format:H:i',
            'datetime_reservation' => 'date_format:d/m/Y|after_or_equal:' . $dateNow,
            'password' => 'required_if:create_account,1|nullable|min:6|string|confirmed:password_confirmation',
            'password_confirmation' => 'required_if:create_account,1',
            'invited_emails' => 'nullable',
        ];
        
        return $rules;
    }

    function messages() {
        $messages = [
            'email.email' => 'Veuillez saisir une adresse e mail valide.',
            'email.required' => 'Veuillez saisir une adresse e mail.',
            'firstname.required' => 'Veuillez saisir votre prénom.',
            'firstname.min' => 'Veuillez renseigner au minimum 2 caractères pour votre prénom',
            'firstname.max' => 'Merci de ne pas saisir plus de 255 caractères pour votre prénom',
            'lastname.required' => 'Veuillez saisir votre nom.',
            'lastname.min' => 'Veuillez renseigner au minimum 2 caractères pour votre nom',
            'lastname.max' => 'Merci de ne pas renseigner plus de 255 caractères pour votre nom',
            'time_reservation.required' => 'Horaire manquant',
            'time_reservation.date_format' => "Merci de resaisir votre demande, l'horaire choisi n'est pas correct",
            'datetime_reservation.after_or_equal' => 'La date pour votre réservation est passée de date',
            'password.required_if' => 'Veuillez renseigner un mot de passe valide',
            'password_confirmation.required_if' => 'Veuillez renseigner un mot de passe valide',
        ];
        return $messages;
    }

}
