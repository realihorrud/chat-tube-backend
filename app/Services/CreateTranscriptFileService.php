<?php

declare(strict_types=1);

namespace App\Services;

use App\Supadata\Entities\Content;
use App\Supadata\Entities\Metadata;
use App\Supadata\Entities\Transcript;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use LogicException;

final class CreateTranscriptFileService
{
    public function handle(Metadata $metadata, Transcript $transcript): string
    {
        $filename = storage_path('app/private/'.Str::slug($metadata->title).'.txt');

        $file = fopen($filename, 'w');
        fwrite($file, $this->getFileContent($metadata, $transcript));
        fclose($file);

        Log::info('Transcript saved in ' . $filename);

        return $filename;
    }

    private function getFileContent(Metadata $metadata, Transcript $transcript): string
    {
        return <<<EOT
Title: {$metadata->title}
Author: {$metadata->author->displayName}
Description: {$metadata->description}
Timestamps:
{$this->getTimestamps($transcript)}
EOT;
    }

    private function getTimestamps(Transcript $transcript): string
    {
        /** @var array{string} $timestamps */
        $timestamps = [];

        if (is_string($transcript->content)) {
            throw new LogicException('Cannot create timestamps from a string.');
        }
        $transcript->content->each(function (Content $item) use (&$timestamps): void {
            $timestamps[] = [$this->calculateTimestamp($item->offset), $item->text];
        });

        foreach ($timestamps as &$timestamp) {
            $timestamp = implode(' - ', $timestamp);
        }
        /** @var array{string} $timestamps */

        return implode("\n", $timestamps);
    }

    private function calculateTimestamp(float $offset): string
    {
        $seconds = (int) round($offset / 1000);

        return gmdate('H:i:s', $seconds);
    }
}
