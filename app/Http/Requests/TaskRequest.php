<?php

namespace ScandiWebTest\Http\Requests;

use Log;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exception\HttpResponseException;

class TaskRequest extends Request
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
    public function rules()
    {
        return [
            'description' => 'required',
            'time_spent' => 'required|min:1|integer'
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  Validator  $validator
     * @return mixed
     */
    protected function failedValidation(Validator $validator)
    {
        Log::error(
            'Task validation failed',
            [
                'input' => json_encode($this->all()),
                'error' => json_encode($this->formatErrors($validator))
            ]
        );

        throw new HttpResponseException($this->response(
            $this->formatErrors($validator)
        ));
    }
}
