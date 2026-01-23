<?php

namespace App\Http\Resources;

use App\Models\User;
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
        return [
            'type' => 'ticket',
            'id' => $this->id,
            'attributes' => [
                'subject' => $this->subject,
                'status' => $this->status,
                'priority' => $this->priority,
                'createdAt' => $this->created_at->format('Y-M-d H:i:s'),
                'updatedAt' => $this->updated_at->format('Y-M-d H:i:s'),
            ],
            'relationships' => [
                'customer' => UserResource::make($this->whenLoaded('customer')),
                'messages' => MessageResource::collection($this->whenLoaded('messages')),
            ],
        ];
    }
}
