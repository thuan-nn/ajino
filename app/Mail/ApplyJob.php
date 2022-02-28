<?php

namespace App\Mail;

use App\Enums\MailTemplateType;
use App\Supports\Traits\HasMailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;

class ApplyJob extends Mailable
{
    use Queueable, SerializesModels, HasMailTemplate;

    protected $data;

    protected $files;

    /**
     * ApplyJob constructor.
     *
     * @param $data
     * @param $files
     */
    public function __construct($data, $files = null)
    {
        $this->data = $data;
        $this->files = $files ? $files->filter() : collect();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $template = $this->renderTemplate(MailTemplateType::APPLY, $this->data);
        $mail = $this->html($template->content);
        $mail->subject($template->title);

        foreach ($this->files as $file) {
            $path = public_path('storage/'.$file->path);
            if (File::exists($path)) {
                $mail->attach($path);
            }
        }

        return $mail;
    }
}
