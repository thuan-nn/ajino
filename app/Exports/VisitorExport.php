<?php

namespace App\Exports;

use App\Enums\MajorEnum;
use App\Enums\TourType;
use App\Enums\VisitorStatusEnum;
use App\Models\Location;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class VisitorExport implements FromCollection, WithMapping, WithHeadings, WithStyles, ShouldAutoSize
{
    /**
     * @var
     */
    private $visitors;

    public function __construct($visitors)
    {
        $this->visitors = $visitors;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->visitors;
    }

    /**
     * @param mixed $visitor
     * @return array
     */
    public function map($visitor): array
    {
        return [
            Carbon::parse($visitor->created_at)->format('Y-m-d'),
            $visitor->companyTour->date,
            TourType::getDescription($visitor->companyTour->type),
            (string) $visitor->amount_visitor,
            $visitor->name,
            MajorEnum::getDescription($visitor->majors),
            $visitor->job_location,
            $visitor->address,
            $visitor->email,
            $visitor->phone_number,
            Location::query()->findOrFail($visitor->city)->name,
            VisitorStatusEnum::getDescription($visitor->status),
            $visitor->note,
        ];
    }

    /**
     * @return array|string[]
     */
    public function headings(): array
    {
        return [
            'Ngày đăng ký',
            'Ngày Tham Quan',
            'Buổi Tham Quan',
            'Số Lượng Đăng Kí',
            'Người Đăng Kí',
            'Đối Tượng Tham Quan',
            'Trường/Công ty/Đơn vị',
            'Địa Chỉ',
            'Email',
            'SĐT',
            'Thành Phố',
            'Trạng Thái',
            'Ghi Chú',
        ];
    }

    /**
     * @param \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet
     * @return \bool[][][]
     */
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
