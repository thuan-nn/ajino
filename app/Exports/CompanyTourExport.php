<?php

namespace App\Exports;

use App\Enums\MajorEnum;
use App\Enums\TourType;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CompanyTourExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    /**
     * @var
     */
    private $companyTours;

    public function __construct($companyTours)
    {
        $this->companyTours = $companyTours;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->companyTours;
    }

    /**
     * @param mixed $companyTour
     * @return string[]
     */
    public function map($companyTour): array
    {
        return [
            $companyTour->date,
            TourType::getDescription($companyTour->type),
            $this->getMajors($companyTour->visitors),
            (string) $companyTour->registry_amount,
            (string) $companyTour->participant_amount,
        ];
    }

    /**
     * @return string[]
     */
    public function headings(): array
    {
        return [
            'Ngày tham quan',
            'Buổi',
            'Đối tượng tham quan',
            'Tổng số lượng đăng kí',
            'Tổng số lượng thực tế',
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

    /**
     * @param $visitors
     * @return string
     */
    public function getMajors($visitors)
    {
        $majors = array_unique($visitors->pluck('majors')->toArray());

        $result[] = array_reduce($majors, function ($major, $item) {
            return $major = MajorEnum::getDescription($item);
        });

        return implode(',', $result);
    }
}
