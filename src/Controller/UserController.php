<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class UserController extends AbstractController
{
    /**
     * @Route("/login", name="api_login", methods={"POST"})
     */
    public function login()
    {
        return $this->json(['result' => true]);
    }
    /**
     * @Route("/register", name="api_register", methods={"POST"})
     */
    public function register(ObjectManager $om, UserPasswordEncoderInterface $passwordEncoder, Request $request)
    {

        $user = new User();

        $email                  = $request->request->get("email");
        $password               = $request->request->get("password");
        $passwordConfirmation   = $request->request->get("password_confirmation");
        $role                   = $request->request->get("role");

        $errors = [];
        if($password != $passwordConfirmation)
        {
            $errors[] = "Password does not match the password confirmation.";
        }

        if(strlen($password) < 6)
        {
            $errors[] = "Password should be at least 6 characters.";
        }

        if(!$errors)
        {
            $encodedPassword = $passwordEncoder->encodePassword($user, $password);
            $user->setEmail($email);
            $user->setPassword($encodedPassword);
            $user->setRoles([$role]);
            try
            {
                $om->persist($user);
                $om->flush();

                return $this->json([
                    'user' => $user->getEmail()
                ]);
            }
            catch(UniqueConstraintViolationException $e)
            {
                $errors[] = "The email provided already has an account!";
            }
            catch(\Exception $e)
            {
                $errors[] = "Unable to save new user at this time.";
            }

        }


        return $this->json([
            'errors' => $errors
        ], 400);

    }
    /**
     * @Route("/profile", name="api_profile")
     */
    public function profile()
    {
        $current_user = $this->getUser();
        $roles = $current_user->getRoles();

        return $this->json([
            'user' => $this->getUser()
        ],
            200,
            [],
            [
                'groups' => ['api']
            ]
        );
    }
    /**
     * @Route("/logout", name="api_logout")
     **/
    public function logout(){

    }
}
