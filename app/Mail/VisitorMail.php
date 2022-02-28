<?php

namespace App\Mail;

use App\Enums\LanguageEnum;
use App\Enums\VisitorStatusEnum;
use App\Supports\Traits\HasMailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;

class VisitorMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels, HasMailTemplate;

    protected $status;

    protected $fromUser;

    protected $attachFiles;

    protected $language = LanguageEnum::VI;

    protected $location;

    /**
     * VisitorMail constructor.
     *
     * @param string|null $status
     * @param array $attachFiles
     * @param null $fromUser
     * @param string $language
     * @param null $location
     */
    public function __construct(
        string $status = null,
        $attachFiles = [],
        $fromUser = null,
        $language = LanguageEnum::VI,
        $location = null
    ) {
        $this->status = $status;
        $this->attachFiles = $attachFiles ? array_filter($attachFiles) : [];
        $this->fromUser = $fromUser;
        $this->language = $language;
        $this->location = $location;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        switch ($this->status) {
            case VisitorStatusEnum::WAITING:
                if ($this->attachFiles) {
                    foreach ($this->attachFiles as $file) {
                        $path = public_path('storage/'.$file);
                        if (File::exists($path)) {
                            $this->attach($path);
                        }
                    }
                }
                break;
            case VisitorStatusEnum::CANCEL:
            case VisitorStatusEnum::DENY:
                $this->status = VisitorStatusEnum::CANCEL;
                break;
        }
        $email = optional($this->location)->email ?? config('mail.from.address');
        $name = optional($this->location)->name ?? config('mail.from.name');
        $template = $this->renderTemplate($this->status, $this->fromUser);
        $this->subject($template->title)->html($template->content)->from($email, $name)->replyTo($email);

        return $this;
    }
}
