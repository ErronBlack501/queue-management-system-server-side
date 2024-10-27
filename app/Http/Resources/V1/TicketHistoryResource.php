<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketHistoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => (string)$this->id,
            'thStatus' => $this->th_status,
            'processedAt' => $this->processed_at,
            'completedAt' => $this->completed_at,
            'canceledAt' => $this->canceled_at,
            'processingDuration' => $this->processing_duration,
            'handledBy' => $this->handled_by,
            'ticketId' => $this->ticket_id,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    }
}
