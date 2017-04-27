<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AddTask extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $template;
    protected $name;
    protected $data;

    public function __construct($template, $name, $data = [])
    {
        $this->template = $template;
        $this->name =$name;
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view($this->template)
            ->with($this->data)
            ->subject($this->name);
    }
}
