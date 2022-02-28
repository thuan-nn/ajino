<?php

namespace App\Supports\Traits;

use App\Enums\LanguageEnum;
use App\Enums\MailParameterEnum;
use App\Models\MailTemplate;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

trait HasMailTemplate
{
    private function renderTemplate(string $type, $data = [])
    {
        // Get template html
        $language = Arr::get($data, 'locale') ?? LanguageEnum::VI;
        $template = MailTemplate::query()->firstWhere([
            'type'     => $type,
            'language' => $language,
        ]);
        if ($template) {
            // Parameters
            $parameters = MailParameterEnum::getValue(Str::upper($type));
            $content = $template->content;
            // Replace content
            collect($parameters)->each(function ($item) use (&$content, $data) {
                $content = str_replace('{'.Str::lower($item).'}', Arr::get($data, $item), $content);
            });
            // Set content
            $template->content = $content;
            $template->title = $template->title.'-'.Arr::get($data, 'title');
        } else {
            // New template
            $template = new MailTemplate();
            $template->content = '<html></html>';
            $template->title = config('app.name');
        }

        return $template;
    }
}
