<?php

namespace App\Http\Controllers\API;

use App\Exports\CompanyTourExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\CSVDownloadRequest;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Maatwebsite\Excel\Facades\Excel;

class CSVDownloadController extends Controller
{
    /**
     * @param \App\Http\Requests\CSVDownloadRequest $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download(CSVDownloadRequest $request)
    {
        $condition = $request->validated();

        $month = Carbon::parse(Arr::get($condition, 'date'))->month;
        $status = Arr::get($condition, 'status');
        $location = Arr::get($condition, 'location_id');

        return Excel::download(new CompanyTourExport($month, $location, $status), self::setCSVFileName());
    }

    /**
     * @return string
     */
    protected function setCSVFileName()
    {
        $timestamp = now()->timestamp;

        return sprintf('%s_%s.%s', $timestamp, 'monthly_report', 'xlsx');
    }
}
