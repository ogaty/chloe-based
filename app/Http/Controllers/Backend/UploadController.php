<?php
/**
 * Created by PhpStorm.
 * User: talv
 * Date: 10/08/16
 * Time: 12:23.
 */

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\Controller;

use App\Http\Requests\UploadFileRequest;
use App\Http\Requests\UploadNewFolderRequest;
use App\Models\UploadedFiles;
use App\Services\MediaManager;

/**
 * Class FileManagerController.
 */
class UploadController extends Controller
{
    /**
     * @var MediaManager
     */
    private $mediaManager;

    /**
     * FileManagerController constructor.
     *
     * @param MediaManager $mediaManager
     */
    public function __construct(MediaManager $mediaManager)
    {
        $this->mediaManager = $mediaManager;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ls()
    {
        $path = request('path');

        return $this->mediaManager->folderInfo($path);
    }

    /**
     * @param UploadNewFolderRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function createFolder(UploadNewFolderRequest $request)
    {
        $new_folder = $request->get('new_folder');
        $folder = $request->get('folder').'/'.$new_folder;

        try {
            $result = $this->mediaManager->createDirectory($folder);

            if ($result !== true) {
                $error = $this->mediaManager->errors() ?: trans('media-manager::messages.create_error', ['entity' => 'directory']);

                return $this->errorResponse($error);
            }

            return ['success' => 'create_success'];
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function deleteItem(Request $request)
    {
        $path = request('path');
	if (!Storage::exists('public' . $path)) {
	    return ['success' => 'no such file or folder.'];
	}
	if (Storage::getMetadata('public' . $path)['type'] === 'dir') {
	    return $this->deleteFolder($request, $path);
	} else {
	    return $this->deleteFile($request);
	}
    }

    /**
     * Delete a folder.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteFolder(Request $request, $folder = null)
    {
	if (is_null($folder)) {
            $folder = $request->get('path');
	}

        try {
            $result = $this->mediaManager->deleteDirectory($folder);
            if ($result !== true) {
                $error = $this->mediaManager->errors() ?: trans('media-manager::messages.delete_error', ['entity' => 'folder']);

                return $this->errorResponse($error);
            }

            return ['success' => 'delete_success'];
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteFile()
    {
        $path = request('path');

        try {
            $result = $this->mediaManager->deleteFile($path);

            if ($result !== true) {
                $error = $this->mediaManager->errors() ?: trans('media-manager::messages.delete_error', ['entity' => 'File']);

                return $this->errorResponse($error);
            }

            return ['success' => trans('media-manager::messages.delete_success', ['entity' => 'File'])];
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    /**
     * Upload new file.
     *
     * @param UploadFileRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadFiles(UploadFileRequest $request)
    {
        try {
            $directories = $this->mediaManager->allDirectories();
            $files = $request->file('file');
            $folder = $request->post('targetfolder', '/');
            if (!in_array($folder, $directories)) {
                return $this->errorResponse(['error: invalid path']);
            }

            $response = $this->mediaManager->saveUploadedFiles($files, $folder);
            if ($response != 0) {
                $response = trans('media-manager::messages.upload_success', ['entity' => $response.' New '.str_plural('File', $response)]);
            }

            $errors = $this->mediaManager->errors();
            if (!empty($errors)) {
                return $this->errorResponse($errors, $response);
            }

            return ['success' => $response];
        } catch (\Exception $e) {
            return $this->errorResponse([$e->getMessage()]);
        }
    }

    /**
     * @param Request $request
     *
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function renameItem(Request $request)
    {
        $path = $request->get('path');
        $original = $request->get('original');
        $newName = $request->get('newName');
        $type = $request->get('type');

        try {
            $result = $this->mediaManager->rename($path, $original, $newName);

            if ($result !== true) {
                $error = $this->mediaManager->errors() ?: trans('media-manager::messages.rename_error', ['entity' => $type]);

                return $this->errorResponse($error);
            }

            return ['success' => trans('media-manager::messages.rename_success', ['entity' => $type])];
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    /**
     * @param Request $request
     *
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function moveItem(Request $request)
    {
        $moveFrom = $request->post('from');
        $moveTo = $request->post('to');
        if (Storage::getMetadata('public' . $moveFrom)['type'] === 'dir') {
            return ['success' => 'move skipped'];
        }

        try {
//            if ($type == 'Folder') {
//                $result = $this->mediaManager->moveFolder($currentFile, $newFile);
//            } else {
            $result = $this->mediaManager->moveFile($moveFrom, $moveTo);
//            }

            if ($result !== true) {
                $error = $this->mediaManager->errors() ?: 'move_error';

                return $this->errorResponse($error);
            }

            return ['success' => 'move_success'];
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function allDirectories()
    {
        return $this->mediaManager->allDirectories();
    }

    /**
     * Upload multiple files.
     *
     * @param       $error
     * @param array $notices
     * @param int   $errorCode
     *
     * @return \Illuminate\Http\JsonResponse
     */
    private function errorResponse($error, $notices = [], $errorCode = 400)
    {
        if (is_array($error)) {
            json_encode($error);
        }
        $payload = ['error' => $error];
        if (!empty($notices)) {
            $payload['notices'] = $notices;
        }

        return \Response::json($payload, $errorCode);
    }

    public function index()
    {
        $images = [];
        return view('backend/upload/index', ['images' => $images]);
    }
}
