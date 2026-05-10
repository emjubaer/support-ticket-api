<?php

namespace App\Notifications;

use App\Mail\CustomerTicketCreateMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomerTicketNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $ticket;

    /**
     * Create a new notification instance.
     */
    public function __construct($ticket)
    {
        logger()->info('Initializing CustomerTicketNotification with ticket ID: ' . $ticket->id);
        $this->ticket = $ticket;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        logger()->info('Preparing to send CustomerTicketNotification email for ticket ID: ' . $this->ticket->id);
        return (new CustomerTicketCreateMail ($this->ticket))
            ->to($notifiable->email);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'ticket_id' => $this->ticket->id,
            'subject' => $this->ticket->subject,
            'message' => $this->ticket->messages->first()?->message,
            'created_at' => $this->ticket->created_at,
        ];
    }
}
