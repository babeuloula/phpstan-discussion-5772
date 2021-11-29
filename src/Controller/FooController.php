<?php

namespace App\Controller;

use App\Contract\IsInstanceOfInterface;
use App\Entity\Company;
use App\Entity\User;
use App\Traits\IsInstanceOfTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class FooController extends AbstractController implements IsInstanceOfInterface
{
    use IsInstanceOfTrait;

    /**
     * @Route("/foo", name="foo")
     */
    public function index(Security $security): Response
    {
        /** @var User $user */
        $user = $security->getUser();

        $this->isInstanceOf(
            Company::class,
            $user->getCompany(),
            BadRequestHttpException::class,
            'Unable to find company.',
            [
                'user' => $user,
            ],
        );

        return $this->json([
            'message' => $user->getCompany()->getName(),
            'path' => 'src/Controller/FooController.php',
        ]);
    }
}
