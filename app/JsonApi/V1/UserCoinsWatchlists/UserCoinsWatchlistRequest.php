<?php

namespace App\JsonApi\V1\UserCoinsWatchlists;

use Illuminate\Validation\Rule;
use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;
use LaravelJsonApi\Validation\Rule as JsonApiRule;

class UserCoinsWatchlistRequest extends ResourceRequest
{

    /**
     * Get the validation rules for the resource.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'code' => ['required', 'string', Rule::exists('coins', 'code')],
        ];
    }

}
