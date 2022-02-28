<?php

namespace App\Models;

use App\Builders\VisitorBuilder;
use App\Enums\LanguageEnum;
use App\Enums\VisitorStatusEnum;
use App\Mail\VisitorMail;
use App\Supports\Traits\AdditionalTrait;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class Visitor extends BaseModel
{
    use AdditionalTrait;

    protected $table = 'visitors';

    protected $fillable = [
        'company_tour_id',
        'name',
        'address',
        'email',
        'phone_number',
        'amount_visitor',
        'majors',
        'job_location',
        'city',
        'status',
        'created_by',
        'additional',
        'note',
    ];

    protected $casts = [
        'additional' => 'object',
    ];

    public function provideCustomBuilder()
    {
        return VisitorBuilder::class;
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function (Visitor $visitor) {
            $visitor->addAdditional('send_mail_visited', false);
        });

        static::updating(function (Visitor $visitor) {
            $visitor->addAdditional('send_mail_visited', false);
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function companyTour()
    {
        return $this->belongsTo(CompanyTour::class, 'company_tour_id', 'id');
    }

    /**
     * @param string $status
     * @param array $files
     * @param string $language
     * @param null $history
     * @param null $location
     * @throws \ReflectionException
     */
    public function sendEmail(string $status, $files = [], $language = LanguageEnum::VI, $history = null, $location = null)
    {
        $user = $this->toArray();
        $user['date'] = $this->companyTour->date;
        $user['type'] = trans('languages.'. Str::upper($this->companyTour->type));
        $mailView = new VisitorMail($status, $files, $user, $language, $location);
        if ($history && $this->status !== VisitorStatusEnum::REGISTERED) {
            // Render html
            $history['content'] = $mailView->render();
            // Update/create history
            MailHistory::query()->updateOrCreate($history, $history);
        }

        Mail::to($this->email)->queue($mailView->afterCommit());
    }
}
