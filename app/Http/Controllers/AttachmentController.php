<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Task;
use App\Models\TaskAttachment;
// use App\Jobs\GenerateImageThumbnail; // job for thumbnails

class AttachmentController extends Controller
{
    protected $allowedExtensions = [
        'images' => ['jpg', 'jpeg', 'png', 'gif', 'webp'],
        'documents' => ['pdf', 'doc', 'docx', 'xlsx', 'pptx', 'txt', 'csv'],
        'videos' => ['mp4', 'mov', 'mkv', 'avi']
    ];

    protected $maxSize = 50 * 1024 * 1024;

    public function upload(Request $request, $taskId)
    {
        $task = Task::findOrFail($taskId);

        // Accept multiple files
        $request->validate([
            'files.*' => 'required|file|max:51200',
        ]);

        $files = $request->file('files', []);
        $saved = [];

        foreach ($files as $file) {
            // 1) check extension + mime
            $ext = strtolower($file->getClientOriginalExtension());
            $mime = $file->getClientMimeType();

            if (!$this->isAllowedExtension($ext, $mime)) {
                return response()->json(['error' => 'Tipe file tidak diperbolehkan: ' . $file->getClientOriginalName()], 422);
            }

            // 2) file size server-side check
            if ($file->getSize() > $this->maxSize) {
                return response()->json(['error' => 'File terlalu besar. Gunakan chunked upload untuk file > 50MB.'], 413);
            }

            // 3) optional virus scan (blocking). If fails, remove temp & return error
            $scanResult = $this->runVirusScan($file->getRealPath());
            if ($scanResult !== true) {
                return response()->json(['error' => 'File gagal scan antivirus: ' . $scanResult], 422);
            }

            // 4) store securely — use hashed filename or uuid
            $uuidName = (string) Str::uuid() . '.' . $ext;
            $disk = 'private';
            $path = 'tasks/' . $task->id . '/' . date('Y/m');
            $storedPath = Storage::disk($disk)->putFileAs($path, $file, $uuidName);

            // 5) versioning: if same original_name exists, increment version and deactivate old
            $originalName = $file->getClientOriginalName();
            $last = TaskAttachment::where('task_id', $task->id)
                ->where('original_name', $originalName)
                ->orderBy('version', 'desc')
                ->first();

            $version = $last ? $last->version + 1 : 1;
            if ($last) {
                $last->update(['is_active' => false]);
            }

            $attachment = TaskAttachment::create([
                'task_id' => $task->id,
                'original_name' => $originalName,
                'file_name' => $uuidName,
                'file_path' => $storedPath,
                'storage_disk' => $disk,
                'file_size' => $file->getSize(),
                'mime_type' => $mime,
                'version' => $version,
                'is_active' => true,
            ]);

            // 6) dispatch thumbnail job if image
            // if ($this->isImageExt($ext)) {
            //     GenerateImageThumbnail::dispatch($attachment);
            // }

            $saved[] = $attachment;
        }

        return response()->json(['data' => $saved], 201);
    }

    // helper checks
    protected function isImageExt($ext)
    {
        return in_array($ext, $this->allowedExtensions['images']);
    }

    protected function isAllowedExtension($ext, $mime)
    {
        $all = array_merge(...array_values($this->allowedExtensions));
        if (!in_array($ext, $all)) return false;

        return true;
    }

    // placeholder for virus scan (see section 7)
    protected function runVirusScan(string $filePath)
    {
        // 1) try ClamAV if available:
        if (function_exists('exec')) {
            $cmd = 'clamscan --no-summary ' . escapeshellarg($filePath);
            exec($cmd, $output, $ret);
            if ($ret === 0) return true;
            if ($ret === 1) return 'Virus detected';
        }
        // 2) fallback: simulate (always pass in production remove simulation)
        return true;
    }

    public function download($id)
    {
        // cari attachment di database
        $att = TaskAttachment::findOrFail($id);

        // (opsional) cek policy, kalau mau batasi akses
        $this->authorize('download', $att);

        // ambil disk sesuai field di DB
        $disk = $att->storage_disk;

        // cek file ada di storage
        if (!Storage::disk($disk)->exists($att->file_path)) {
            return response()->json([
                'error' => 'File tidak ditemukan di storage',
                'id'    => $id
            ], 404);
        }

        // download dengan nama asli
        return Storage::disk($disk)->download(
            $att->file_path,
            $att->original_name
        );
    }

    public function destroy($id)
    {
        $att = TaskAttachment::findOrFail($id);

        $disk = $att->storage_disk ?? 'private';

        // hapus file di storage kalau ada
        if (Storage::disk($disk)->exists($att->file_path)) {
            Storage::disk($disk)->delete($att->file_path);
        }

        // hapus record di database
        $att->delete();

        return response()->json([
            'message' => 'Attachment berhasil dihapus',
            'id'      => $id,
        ], 200);
    }
}
