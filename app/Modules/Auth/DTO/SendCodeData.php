<?php

namespace App\Modules\Auth\DTO;

use Spatie\LaravelData\Data;

class SendCodeData extends Data
{
    public function __construct(
        public string $email,
        public string $code,
    )
    {
    }
}
