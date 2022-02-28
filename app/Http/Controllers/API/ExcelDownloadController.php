<?php

namespace App\Http\Controllers\API;

use App\Enums\ExportTypeEnum;
use App\Exports\CompanyTourExport;
use App\Exports\CVisitorExport;
use App\Exports\VisitorExport;
use App\Filters\CompanyTourFilter;
use App\Filters\VisitorFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\CSVDownloadRequest;
use App\Http\Requests\DownloadExcelCompanyTourRequest;
use App\Http\Requests\DownloadExcelVisitorRequest;
use App\Models\CompanyTour;
use App\Models\Visitor;
use Maatwebsite\Excel\Facades\Excel;

class ExcelDownloadController extends Controller
{
    /**
     * @param \App\Http\Requests\DownloadExcelVisitorRequest $request
     * @param \App\Filters\VisitorFilter $filter
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function visitorDownload(DownloadExcelVisitorRequest $request, VisitorFilter $filter)
    {
        $visitors = Visitor::query()
                           ->filter($filter)
                           ->get();

        return Excel::download(new VisitorExport($visitors), self::setFileName(ExportTypeEnum::VISITOR));
    }

    /**
     * @param \App\Http\Requests\DownloadExcelCompanyTourRequest $request
     * @param \App\Filters\CompanyTourFilter $filter
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function companyTourDownload(DownloadExcelCompanyTourRequest $request, CompanyTourFilter $filter)
    {
        $companyTours = CompanyTour::query()->dateExportCompanyTour()->filter($filter)->get();

        return Excel::download(new CompanyTourExport($companyTours), self::setFileName(ExportTypeEnum::COMPANY_TOUR));
    }

    /**
     * @param $typeExport
     * @return string
     */
    protected function setFileName($typeExport)
    {
        $timestamp = now(env('APP_TIMEZONE'))->toDateTimeString();

        return sprintf('%s_%s.%s', $timestamp, $typeExport, 'xlsx');
    }
}
