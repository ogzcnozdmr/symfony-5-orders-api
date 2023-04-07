<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;

/**
 * @Route("/api", name="api_")
 */

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="register", methods={"POST"})
     */
    public function index(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $em = $this->getDoctrine()->getManager();
        $decoded = json_decode($request->getContent());
        $email = $decoded->email;
        $password = $decoded->password;

        try {
            $user = new User();
            $user->setPassword($encoder->encodePassword($user, $password));
            $user->setEmail($email);
            $em->persist($user);
            $em->flush();
        } catch (\Exception $ex) {
            return new JsonResponse(['status' => 'Kayıt başarısız.'], Response::HTTP_METHOD_NOT_ALLOWED);
        }

        return new JsonResponse(['status' => 'Kayıt başarılı.'], Response::HTTP_CREATED);
    }
}