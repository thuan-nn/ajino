<?php

namespace Database\Seeders;

use App\Enums\LanguageEnum;
use App\Enums\MailTemplateType;
use App\Enums\VisitorStatusEnum;
use App\Models\MailTemplate;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class MailTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MailTemplate::query()->truncate();
        $types = MailTemplateType::asArray();
        foreach ($types as $type) {
            $html = view('mail.templates.'.$type);
            switch ($type) {
                case MailTemplateType::CONTACT:
                    $title = '[AVN Site] Tư vấn khách hàng';
                    break;
                case MailTemplateType::APPROVED:
                    $title = '[Tham quan công ty AVN] Mail thông báo đăng ký tour đã được duyệt';
                    break;
                case MailTemplateType::APPLY:
                    $title = 'Thông báo có vị trí ứng tuyển mới';
                    break;
                case MailTemplateType::WAITING:
                    $title = '[Tham quan công ty AVN] Thông báo về việc đăng ký tour';
                    break;
                case MailTemplateType::VISITED:
                    $title = '[Tham quan công ty AVN] Thư cám ơn';
                    break;
                case MailTemplateType::CANCEL:
                    $title = '[Tham quan công ty AVN] Xác nhận về việc hủy tour';
                    break;
                default:
                    $title = $type;
            }
            MailTemplate::create([
                'type'     => $type,
                'title'    => $title,
                'content'  => $html,
                'language' => LanguageEnum::VI,
            ]);
        }
    }
}
