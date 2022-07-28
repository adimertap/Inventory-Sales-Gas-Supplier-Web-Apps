<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailSupplier extends Mailable
{
    use Queueable, SerializesModels;

    public $item;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($item)
    {
        $this->item = $item;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('info@ptriastavalasindo.com')
                ->subject('Pembelian Produk')
                ->markdown('SendEmail', [
                    'url' => 'suksesberkahbertumbuh.com',
                    'data' => $this->item,
        ]);
    }
}
