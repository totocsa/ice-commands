<?php

namespace Totocsa\IceCommands\Mail;

use Illuminate\Mail\Mailable;

class TestEmail extends Mailable
{
    public function __construct($subject, $html)
    {
        $this->subject($subject);
        $this->html($html);
    }

    public function build()
    {
        return $this->subject($this->subject)->text('');
    }
}
