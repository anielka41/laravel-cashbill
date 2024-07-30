<?php

namespace MsCode\Cashbill\Events;

use MsCode\Cashbill\Payload;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class TransactionCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Payload $payload;
    public string $orderId;
    /**
     * Create a new event instance.
     */
    public function __construct(Payload $payload, string $orderId)
    {
        $this->payload = $payload;
        $this->orderId = $orderId;
    }
}
