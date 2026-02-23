<?php

declare(strict_types=1);

namespace App\Supadata\Enums;

enum EntityType: string
{
    case Video = 'video';
    case Image = 'image';
    case Post = 'post';
    case Carousel = 'carousel';
}
