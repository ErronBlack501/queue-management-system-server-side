<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCounterRequest extends FormRequest
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
        $method = $this->method();

        if ($method === "PUT") {
            return [
                'counter_number' => 'required|alpha_num:ascii',
                'counter_status' => 'required|in:open,closed,suspended',
                'service_id' => 'required|exists:services,id',
            ];
        } else {
            return [
                'counter_number' => 'sometimes|required|alpha_num:ascii',
                'counter_status' => 'sometimes|required|in:open,closed,suspended',
                'service_id' => 'sometimes|required|exists:services,id',
            ];
        }
    }
    protected function prepareForValidation()
    {
        $input = [
            'counter_number' => $this->counterNumber,
            'service_description' => $this->counterStatus,
            'service_id' => !is_null($this->serviceId) ? (int)$this->serviceId : null,
        ];

        if ($this->isThereAnyNullValue($input)) {
            $filtratedInput = array_filter(
                $input,
                function ($value) {
                    return $value !== null;
                }
            );
            if (count($filtratedInput) > 0) $this->merge($filtratedInput);
        } else {
            $this->merge($input);
        }
    }

    private function isThereAnyNullValue(array $array): bool
    {
        foreach ($array as $value) {
            if (is_null($value)) return true;
        }
        return false;
    }
}
