<?php

namespace App\Controller;

use App\ApiResource\WelcomeRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class WelcomeController extends AbstractController
{
    public function __invoke(WelcomeRequest $data): WelcomeRequest
    {
        $data->message = 'Hello World, you are gracefully authenticated!';
        return $data;
    }

}