<?php

namespace App\Http\Requests\V1;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateServiceRequest extends FormRequest
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
                'service_name' => ['required', 'string', 'alpha', Rule::unique('services')->ignore($this->route()->parameter('service'))],
                'service_description' => ['required', 'string', Rule::unique('services')->ignore($this->route()->parameter('service'))],
                'is_active' => 'required|boolean'
            ];
        } else {
            return [
                'service_name' => ['sometimes', 'required', 'string','alpha', Rule::unique('services')->ignore($this->route()->parameter('service'))],
                'service_description' => ['sometimes', 'required', 'string',Rule::unique('services')->ignore($this->route()->parameter('service'))],
                'is_active' => 'sometimes|required|boolean'
            ];
        }
    }

    protected function prepareForValidation()
    {
        $input = [
            'service_name' => $this->serviceName,
            'service_description' => $this->serviceDescription,
            'is_active' => is_null($this->isActive) ? null : filter_var($this->isActive, FILTER_VALIDATE_BOOLEAN)
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
