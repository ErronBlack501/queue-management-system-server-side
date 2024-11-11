<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCounterRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'counter_number' => ['required', 'alpha_num:ascii', Rule::unique('counters')->ignore($this->route()->parameter('counter'))],
            'counter_status' => 'required|in:open,serving,closed,suspended',
            'service_id' => 'required|exists:services,id',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'counter_number' => $this->counterNumber,
            'counter_status' => $this->counterStatus,
            'service_id' => (int)$this->serviceId,
        ]);
    }
}
