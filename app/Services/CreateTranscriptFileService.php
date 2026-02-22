<?php

declare(strict_types=1);

namespace App\Services;

use App\Supadata\Entities\Metadata;
use App\Supadata\Entities\Transcript;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

final class CreateTranscriptFileService
{
    public function handle(Metadata $metadata, Transcript $transcript): string
    {
        $filename = storage_path('app/private/'.Str::slug($metadata->title).'.txt');

        $file = fopen($filename, 'w');
        fwrite($file, $this->getFileContent($metadata, $transcript));
        fclose($file);

        Log::info('Transcript saved in '.$filename);

        return $filename;
    }

    private function getFileContent(Metadata $metadata, Transcript $transcript): string
    {
        return <<<EOT
Title: {$metadata->title}
Author: {$metadata->author->displayName}
Description: {$metadata->description}
Transcript: {$transcript->content}
EOT;
    }
}
