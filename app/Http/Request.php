<?php

namespace App\Http;
use Illuminate\Http\Request as BaseRequest;

/**
 * Description of Request
 *
 * @author Nico
 */
class Request extends BaseRequest{
    use ExtendRequestTrait;
    
}
