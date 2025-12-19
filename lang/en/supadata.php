<?php

declare(strict_types=1);

return [
    'errors' => [
        'invalid_request' => 'Something went wrong with the video link. Please check the URL and try again.',
        'unauthorized' => 'We couldn’t verify your request. Please sign in again and try one more time.',
        'upgrade_required' => 'This video requires a higher plan to process. Please upgrade to continue.',
        'forbidden' => 'We don’t have permission to access this video. It may be private or restricted.',
        'not_found' => 'We couldn’t find this video. It may have been removed or the link is incorrect.',
        'limit_exceeded' => 'You’ve reached today’s limit. Please try again later or upgrade your plan.',
        'transcript_unavailable' => 'This video doesn’t have an available transcript, so we can’t process it.',
        'internal_error' => 'Something went wrong on our side. Please try again in a few minutes.',
    ],
];
