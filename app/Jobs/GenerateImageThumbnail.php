<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class GenerateImageThumbnail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $attachment;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($attachment)
    {
        $this->attachment = $attachment;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $disk = $this->attachment->storage_disk;
        $path = $this->attachment->file_path;
        $stream = Storage::disk($disk)->get($path);
        $img = Image::make($stream);

        // create small thumb
        $thumb = $img->fit(300, 300, function ($constraint) {
            $constraint->upsize();
        })->encode('jpg', 75);

        $thumbPath = 'tasks/' . $this->attachment->task_id . '/thumbs/' . $this->attachment->file_name . '.jpg';
        Storage::disk($disk)->put($thumbPath, (string) $thumb);

        // persist thumb path if you want
        $this->attachment->update(['thumbnail_path' => $thumbPath]);
    }
}
