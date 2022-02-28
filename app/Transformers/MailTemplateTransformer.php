<?php

namespace App\Transformers;

use \App\Models\MailTemplate;
use Flugg\Responder\Transformers\Transformer;

class MailTemplateTransformer extends Transformer
{
    /**
     * List of available relations.
     *
     * @var string[]
     */
    protected $relations = [];

    /**
     * List of autoloaded default relations.
     *
     * @var array
     */
    protected $load = [];

    /**
     * Transform the model.
     *
     * @param \App\Models\MailTemplate $mailTemplate
     * @return array
     */
    public function transform(MailTemplate $mailTemplate)
    {
        return [
            'id'         => (string) $mailTemplate->id,
            'type'       => (string) $mailTemplate->type,
            'title'      => (string) $mailTemplate->title,
            'content'    => (string) $mailTemplate->content,
            'language'   => (string) $mailTemplate->language,
            'created_at' => (string) $mailTemplate->created_at,
            'updated_at' => (string) $mailTemplate->updated_at,
        ];
    }
}
