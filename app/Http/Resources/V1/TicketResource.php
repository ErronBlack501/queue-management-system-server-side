<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return  [
            'id' => (string)$this->id,
            'ticketNumber' => $this->ticket_number,
            'ticketStatus' => $this->ticket_status,
            'service' => new ServiceResource($this->whenLoaded('service')),
            'counter' => new CounterResource($this->whenLoaded(relationship: 'counter')),
            'processedAt' => $this->processed_at,
            'completedAt' => $this->completed_at,
            'canceledAt' => $this->canceled_at,
            'processingDuration' => $this->processing_duration,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    }
}
