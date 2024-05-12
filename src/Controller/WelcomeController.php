<?php

namespace App\Controller;

use App\ApiResource\WelcomeRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;

class WelcomeController extends AbstractController
{


    public function __construct(
        private readonly Security $security
    )
    {
    }

    public function __invoke(WelcomeRequest $data): WelcomeRequest
    {
        $userEmail = $this->security->getUser()->getEmail();
        $data->message = "Hello World, you are gracefully authenticated as $userEmail !";
        return $data;
    }

}