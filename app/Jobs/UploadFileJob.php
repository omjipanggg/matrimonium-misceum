<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
// use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\UploadedFile;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class UploadFileJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $file;
    protected $name;

    public function __construct($file, $name)
    {
        $this->file = $file;
        $this->name = $name;
    }

    public function handle(): void
    {
        $file = UploadedFile::createFromBase($this->file);
        Storage::disk('sftp')->put($this->name, file_get_contents($file->path()));
    }
}
