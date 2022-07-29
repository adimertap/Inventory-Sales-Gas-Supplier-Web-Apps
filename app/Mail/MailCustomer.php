<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailCustomer extends Mailable
{
    public $penjualan;
    use Queueable, SerializesModels;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($penjualan)
    {
        $this->penjualan = $penjualan;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('info@suksesberkahbertumbuh.com')
        ->subject('Invoice - Sukses Berkah Bertumbuh')
        ->markdown('Mail/MailCustomer', [
            'url' => 'suksesberkahbertumbuh.com',
            'data' => $this->penjualan,
        ]);
    }
}
