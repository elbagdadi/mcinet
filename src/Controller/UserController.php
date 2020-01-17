<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Entity\FuturInvestisseur;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Doctrine\ORM\EntityManagerInterface;


class UserController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/login", name="api_login", methods={"POST"})
     */
    public function login()
    {
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
     * @Route("/register", name="api_register", methods={"POST"})
     */
    public function register(UserPasswordEncoderInterface $passwordEncoder, Request $request, \Swift_Mailer $mailer)
    {

        $user = new User();
        $investisseur = new FuturInvestisseur();

        $email                  = $request->request->get("email");
        $password               = $request->request->get("password");

        //get invester data
        $nom = $request->request->get("nom");
        $prenom = $request->request->get("prenom");
       // $password = random_bytes(10);
        /* $passwordConfirmation   = $request->request->get("password_confirmation");*/
        $role                   = "ROLE_SUBSCRIBER";

        $errors = [];
        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('mcinet.ma@gmail.com')
            ->setTo($email)
            ->setBody('BONJOUR VOTRE MOT DE PASSE EST '.$password);

        $mailer->send($message);
      /*  if($password != $passwordConfirmation)
        {
            $errors[] = "Password does not match the password confirmation.";
        }

        if(strlen($password) < 6)
        {
            $errors[] = "Password should be at least 6 characters.";
        }
        */
        if(!$errors)
        {
            $encodedPassword = $passwordEncoder->encodePassword($user, $password);
            $user->setEmail($email);
            $user->setPassword($encodedPassword);
            $user->setRoles([$role]);
            //store investor data
            $investisseur->setNom($nom);
            $investisseur->setPrenom($prenom);


            try
            {
                $this->entityManager->persist($user);
                $this->entityManager->flush();

                $investisseur->setUserId($user->getId());

                $this->entityManager->persist($investisseur);
                $this->entityManager->flush();

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
     * @IsGranted({"ROLE_ADMIN", "ROLE_SUBSCRIBER"}, message="No access! Get out!")
     */
    public function profile()
    {



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
