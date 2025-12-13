<?php

declare(strict_types=1);

namespace App\Supadata\Enums;

enum TypeEnum: string
{
    case Video = 'video';
    case Image = 'image';
    case Post = 'post';
    case Carousel = 'carousel';
}
