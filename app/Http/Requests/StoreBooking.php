<?php

namespace App\Http\Requests;

class StoreBooking extends \App\Http\FormRequest {

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
        $dateNow = date('d/m/Y');
        $rules = [
            'email' => 'required|email',
            'firstname' => 'required|min:2|max:255',
            'lastname' => 'required|min:2|max:255',
            'phone_number' => 'required|regex:/^[0-9 ]+$/',
            //'time_reservation' => 'required|date_format:H:i',
            'datetime_reservation' => 'date_format:d/m/Y|after_or_equal:' . $dateNow,
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
            'time_reservation.required' => 'Veuillez choisir un horaire pour votre réservation',
            'time_reservation.date_format' => "Merci de resaisir votre demande, l'horaire choisi n'est pas correct",
            'datetime_reservation.after_or_equal' => 'La date pour votre réservation est passée de date',
        ];
        return $messages;
    }

}
