<?php

namespace App\Actions;

use App\Enums\FileTypeEnum;
use App\Exceptions\ErrorUploadException;
use App\Http\Requests\UploadFileRequest;
use App\Models\File;
use App\Models\VisitorFileSetting;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UploadFileAction
{
    /**
     * @var \Illuminate\Contracts\Filesystem\Filesystem|\Illuminate\Filesystem\FilesystemAdapter
     */
    protected $storage;

    /**
     * @param $uploadedFile
     * @param string|null $type
     * @param string|null $disk
     * @param \Illuminate\Http\Request $request
     * @return \App\Builders\FileBuilder|\App\Models\File|\Illuminate\Database\Eloquent\Model|\Illuminate\Support\Collection|null
     * @throws \App\Exceptions\ErrorUploadException
     */
    public function execute($uploadedFile, $request = null, string $type = null, string $disk = null)
    {
        if (is_array($uploadedFile)) {
            return collect($uploadedFile)
                ->filter(function ($file) {
                    return $file instanceof UploadedFile;
                })
                ->map(function ($file) use ($type, $disk, $request) {
                    return $this->upload($file, $type, $disk, $request);
                });
        }
        if ($uploadedFile instanceof UploadedFile) {
            return $this->upload($uploadedFile, $type, $disk, $request);
        }

        return null;
    }

    private function upload(UploadedFile $uploadedFile, string $type = null, string $disk = null, $request = null)
    {
        $attributes = [
            'name' => sprintf('%s_%s', now()->timestamp, $uploadedFile->getClientOriginalName()),
            'disk' => $disk ? $disk : config('filesystems.default'),
        ];
        $values = [
            'mime_type' => $uploadedFile->getClientMimeType(),
            'size'      => $uploadedFile->getSize(),
        ];
        $file = File::query()->firstOrNew($attributes, $values);
        $this->storage = Storage::disk($file->disk);

        if ($file->exists) {
            $file = $file->replicate();
            $timestamp = now()->timestamp;
            $pathinfo = pathinfo($uploadedFile->getClientOriginalName());
            $file->name = sprintf('%s_%s.%s', $timestamp, $pathinfo['filename'], $pathinfo['extension']);
        }

        // Handle file upload
        $path = $this->storage->putFileAs($this->getPathUpload(), $uploadedFile, $file->name);
        if (! $path) {
            throw ErrorUploadException::create($uploadedFile);
        }
        $file->path = $path;
        $file->is_published = true;
        $file->type = $type;

        if ($type === FileTypeEnum::VISITOR) {
            $file = $this->saveFileTypeVisitor($request, $file);
        } else {
            $file->save();
        }

        return $file;
    }

    private function getPathUpload(): string
    {
        return 'uploads/'.now()->format('Y/m/d');
    }

    /**
     * @param \App\Http\Requests\UploadFileRequest $request
     * @return array
     */
    private function getDataVisitorFileSetting(UploadFileRequest $request)
    {
        $data = $request->all();
        $isActive = (bool) Arr::get($data, 'is_active');
        $visitorFileType = Arr::get($data, 'visitor_file_type');

        return [
            'is_active' => $isActive,
            'type'      => $visitorFileType,
        ];
    }

    /**
     * @param \App\Http\Requests\UploadFileRequest $request
     * @param \App\Models\File $file
     * @return \App\Models\File
     */
    private function saveFileTypeVisitor(UploadFileRequest $request, File $file)
    {
        $visitorFileSettingData = $this->getDataVisitorFileSetting($request);
        $visitorFileType = $request->get('visitor_file_type');
        $oldVisitorFileSetting = VisitorFileSetting::query()->where('type', $visitorFileType);

        DB::beginTransaction();
        try {
            $file->save();

            if ($oldVisitorFileSetting->count() !== 0) {
                $oldVisitorFileSetting->update(['is_active' => false]);
            }

            $newVisitorFileSetting = VisitorFileSetting::query()->create($visitorFileSettingData);
            $newVisitorFileSetting->files()->sync($file->id);

            DB::commit();
        } catch (\HttpException $exception) {
            DB::rollBack();

            throw new $exception->getMessage();
        }

        return $file;
    }
}
