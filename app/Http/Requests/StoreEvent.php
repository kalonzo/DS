<?php

namespace App\Http\Requests;

class StoreEvent extends \App\Http\FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
 public function rules() {
        $rules = array();
        if ($this->get('action') !== 'feed-establishment-list') {
            if ($this->ajax() === true) {
                $dateNow = date('Y-m-d');
                $rules = [
                    'name' => 'required|min:2|max:255',
                    'description' => 'nullable|numeric|min:2',
                    'start_date' => 'date_format:Y-m-d|after_or_equal:' . $dateNow,
                    'start_hour' => 'required',
                    'end_date' => 'date_format:Y-m-d|after_or_equal:' . $this->get('start_date'),
                    'end_hour' => 'required',
                    'id_establishment' => 'required',
                    'type_event' => 'required|min:2|max:255',
                ];
            }
        }
        return $rules;
    }

    function messages() {
        $messages = [
            'name.required' => 'Veuillez entrer le nom de votre événement',
            'name.min' => 'Nom trop court',
            'name.max' => 'Nom trop long',
            'description.min' => 'Description trop courte',
            'start_date.date_format' => 'Le format de date n\'est pas correcte',
            'start_date.after_or_equal' => 'La date de début dois être supérieur à la date du jour',
            'end_date.date_format' => 'Le format de date n\'est pas correcte',
            'end_date.after_or_equal' => 'La date de fin dois être supérieur à la date de début',
            'id_establishment.required' => 'Veuillez séléctionner un établissement pour votre événement',
        ];
        return $messages;
    }
}
