<?php

declare(strict_types=1);

namespace App\Services;

use App\ValueObjects\YoutubeUrl;
use Illuminate\Support\Uri;
use Webmozart\Assert\Assert;

final class ResponseService
{
    /**
     * Return text with encoded links to timestamps. Example: [00:00:10](link to YouTube video)
     */
    public function linkTimestamps(string $outputText, YoutubeUrl $url): string
    {
        $result = $outputText;
        preg_match_all('/\d\d:\d\d:\d\d/', $outputText, $matches);

        foreach ($matches[0] as $timestamp) {
            Assert::string($timestamp);
            $timestampLink = $this->createTimestampLink($timestamp, $url);
            $result = str_replace($timestamp, $timestampLink, $result);
        }

        return $result;
    }

    private function createTimestampLink(string $timestamp, YoutubeUrl $youtubeUrl): string
    {
        $url = (string) Uri::of($youtubeUrl->toUrl()->value())
            ->withQuery(['t' => $this->timeToSeconds($timestamp)]);

        return sprintf('[%s](%s)', $timestamp, $url);
    }

    private function timeToSeconds(string $time): int
    {
        [$hours, $minutes, $seconds] = explode(':', $time);

        return (int) $hours * 3600 + (int) $minutes * 60 + (int) $seconds;
    }
}
