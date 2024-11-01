<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PurchaseOrderNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $user;
    public $product;
    public $qtyOrder;

    public function __construct($user, $product, $qtyOrder)
    {
        $this->user = $user;
        $this->product = $product;
        $this->qtyOrder = $qtyOrder;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Principal Notification',
            from: env('MAIL_FROM_ADDRESS')
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.purchase_order_alert',
            with: [
                'user' => $this->user,
                'product' => $this->product,
                'qtyOrder' =>  $this->qtyOrder
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }

    public function build()
    {
        return $this->view('emails.purchase_order_alert')
                    ->subject('Principal Notification !')
                    ->with([
                        'user' => $this->user,
                        'product' => $this->product
                        'qtyOrder' =>  $this->qtyOrder
                    ]);
    }
}
