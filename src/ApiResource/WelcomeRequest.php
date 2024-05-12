<?php

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use App\Controller\WelcomeController;

#[ApiResource(
    operations:[
        new Get(
            uriTemplate: '/welcome',
            controller: WelcomeController::class,
            security: "is_authenticated()",
            output: WelcomeRequest::class,
            read: false
        )
    ]
)]
class WelcomeRequest
{
    public string $message;
}