<?php

namespace App\Http\Controllers\API;

use App\Actions\UploadFileAction;
use App\Filters\FileFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\UploadFileRequest;
use App\Models\File;
use App\Sorts\FileSort;
use App\Transformers\FileTransformer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class FileController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param FileFilter $filter
     * @param FileSort $sort
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, FileFilter $filter, FileSort $sort)
    {
        $files = File::query()->filter($filter)->sortBy($sort)->paginate($this->perPage);

        return $this->httpOK($files, FileTransformer::class);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UploadFileRequest $request
     *
     * @param UploadFileAction $action
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function upload(UploadFileRequest $request, UploadFileAction $action)
    {
        $uploadedFile = $request->file('files');
        $fileType = $request->get('type');
        $files = $action->execute($uploadedFile, $request, $fileType);

        return $this->httpOK($files, FileTransformer::class);
    }

    /**
     * @param $file
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download(File $file)
    {
        $path = storage_path('app/public/'.$file->path);

        $fileName = $file->name;

        return response()->download($path, $fileName);
    }

    /**
     * Display the specified resource.
     *
     * @param string $path
     *
     * @return \Intervention\Image\Image
     */
    public function show($path)
    {
        return Cache::remember($path, 1000000, function () use ($path) {
            if (strpos($path, 'uploads/images') === false) {
                $file = File::wherePath($path)->firstOrFail();
                $path = Storage::disk($file->disk)->path($file->path);
            } else {
                $path = $this->fetchContentFile($path);
            }
            header('Cache-Control: max-age='.(60 * 60 * 24 * 365));
            header('Expires: '.gmdate(DATE_RFC1123, time() + 60 * 60 * 24 * 365));
            header('Last-Modified: '.gmdate(DATE_RFC1123, filemtime($path)));

            return Image::make($path)->response();
        });
    }

    /**
     * @param \App\Models\File $file
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(File $file)
    {
        $file->delete();

        return $this->httpNoContent();
    }

    /**
     * @param $path
     * @return mixed
     */
    public function fetchContentFile ($path) {
        $isCorrectFile = Storage::disk('public')->exists($path);

        if (! $isCorrectFile) {
            throw (new ModelNotFoundException);
        }

        return Storage::disk('public')->path($path);
    }
}
