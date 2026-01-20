<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileRequest;
use App\Http\Resources\FileResource;
use App\Models\File;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class FileController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', File::class);

        return FileResource::collection(File::all());
    }

    public function store(FileRequest $request)
    {
        $this->authorize('create', File::class);

        return new FileResource(File::create($request->validated()));
    }

    public function show(File $file)
    {
        $this->authorize('view', $file);

        return new FileResource($file);
    }

    public function update(FileRequest $request, File $file)
    {
        $this->authorize('update', $file);

        $file->update($request->validated());

        return new FileResource($file);
    }

    public function destroy(File $file)
    {
        $this->authorize('delete', $file);

        $file->delete();

        return response()->json();
    }
}
