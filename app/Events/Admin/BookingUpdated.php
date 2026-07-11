<?php

namespace App\Events\Admin;

use App\Models\Book;
use App\Models\Sclinic;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BookingUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $book, $clinic;

    public function __construct(Book $book, Sclinic $clinic)
    {
        $this->book = $book;
        $this->clinic = $clinic;
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('booking-updated'),
        ];
    }
}
