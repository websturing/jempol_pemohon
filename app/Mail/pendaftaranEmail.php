<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class pendaftaranEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public function __construct($email)
    {
        $this->nama = $email['perusahaan']['nama'];
        $this->email = $email['perusahaan']['email'];
        $this->linkUrl = $email->linkUrl;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from("no-replay@dpmptsp.kepriprov.go.id")
            ->view('panel.email')
            ->with(['nama' => $this->nama, 'website' => 'dpmptsp.kepriprov.go.id', "confirmasi" => $this->linkUrl]);
    }
}
