<?php

namespace App\Http\Requests\V1;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTicketRequest extends FormRequest
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
                'ticket_status' => 'required|in:waiting,completed,canceled',
                'processed_at' => 'required',
                'completed_at' => 'required',
                'canceled_at' => 'required',
            ];
        } else {
            return [
                'ticket_status' => 'sometimes|required|in:waiting,completed,canceled',
                'processed_at' => 'sometimes|required',
                'completed_at' => 'sometimes|required',
                'canceled_at' => 'sometimes|required',
            ];
        }
    }

    protected function prepareForValidation()
    {
        $input = [
            'ticket_status' => $this->ticketStatus,
            'processed_at' => $this->processedAt,
            'completed_at' => $this->completedAt,
            'canceled_at' => $this->canceledAt, 
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
