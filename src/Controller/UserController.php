<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Bundle\SecurityBundle\Security;

#[AsController]
class UserController extends AbstractController
{

        public function __construct(private Security $security)
        {
            
        }

        public function __invoke()
        {
            $user = $this->security->getUser();
            return $user;
        }
}