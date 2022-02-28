<?php

namespace App\Http\Controllers\API;

use App\Actions\AttachFilesModelAction;
use App\Enums\ModelTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\AttachFileToModelRequest;

class AttachFilesModelController extends Controller {
    /**
     * @param \App\Http\Requests\AttachFileToModelRequest $request
     * @param string $modelId
     * @param string $modelType
     * @param \App\Actions\AttachFilesModelAction $action
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(AttachFileToModelRequest $request, string $modelId, string $modelType, AttachFilesModelAction $action) {
        $modelTypeCheck = ModelTypeEnum::asArray();
        if (!in_array($modelType, $modelTypeCheck)) {
            return $this->httpNotFound([], null, 'Model Not Found');
        }
        $action->execute($modelId, $modelType, $request->validated());
    }
}
