<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $book;
    public $specialty;
    public $doctor;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($book, $specialty, $doctor)
    {
        $this->book = $book;
        $this->specialty = $specialty;
        $this->doctor = $doctor;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.booking-confirmation')
                    ->subject('Xác nhận đặt lịch khám')
                    ->with([
                        'book' => $this->book,
                        'specialty' => $this->specialty,
                        'doctor' => $this->doctor,
                    ]);
    }
}