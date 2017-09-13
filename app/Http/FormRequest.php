<?php

namespace App\Http;
use Illuminate\Foundation\Http\FormRequest as BaseFormRequest;

/**
 * Description of FormRequest
 *
 * @author Nico
 */
class FormRequest extends BaseFormRequest{
    use ExtendRequestTrait;
}
