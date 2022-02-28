<?php

namespace App\Mail;

use App\Enums\MailTemplateType;
use App\Supports\Traits\HasMailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ContactUs extends Mailable
{
    use Queueable, SerializesModels, HasMailTemplate;

    /**
     * @var $content
     */
    private $content;

    /**
     * @var $title
     */
    private $files;

    /**
     * ContactUs constructor.
     *
     * @param $content
     * @param $files
     */
    public function __construct($content, $files = null)
    {
        $this->content = $content;
        $this->files = $files ? $files->filter() : collect();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $reason = Arr::get($this->content, 'reason');
        if ($reason) {
            $this->content['reason'] = trans('languages.'.Str::upper($reason));
        }

        $template = $this->renderTemplate(MailTemplateType::CONTACT, $this->content);
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
