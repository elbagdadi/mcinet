<?php

namespace App\Controller;

use phpDocumentor\Reflection\DocBlock\Tags\Uses;
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
use Symfony\Component\HttpFoundation\Response;
use App\Repository\UserRepository;


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
       // $password               = $request->request->get("password");

        //get invester data
        $nom = $request->request->get("nom");
        $prenom = $request->request->get("prenom");
        $password = random_bytes(10);
        /* $passwordConfirmation   = $request->request->get("password_confirmation");*/
        $role                   = "ROLE_SUBSCRIBER";

        $errors = [];
       /* $message = (new \Swift_Message('Hello Email'))
            ->setFrom('mcinet.ma@gmail.com')
            ->setTo($email)
            ->setBody('BONJOUR VOTRE MOT DE PASSE EST '.$password);

        $mailer->send($message);*/
      /*  if($password != $passwordConfirmation)
        {
            $errors[] = "Password does not match the password confirmation.";
        }

        if(strlen($password) < 6)
        {
            $errors[] = "Password should be at least 6 characters.";
        }
        */
      //function to send email via api wigaming
     //   $this->sendEmail($email,"Votre compte au mcinet platform","Ci joint vous trouverez vos access: bonjour");
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
                    'user' => $user->getId(),
                    'result' => true,
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
    /**
     * @Route("/api/{id}/changepwd", name="api_changepwd", methods={"POST"})
     */
    public function changepwd(Request $request,UserRepository $userRepository,UserPasswordEncoderInterface $passwordEncoder){
        $id = $request->get('id');
        $pwd = $request->request->get('usrpwd');
        $confirmusrpwd = $request->request->get('confirmusrpwd');
        $user = $userRepository->getTheUser($id);
         $errors = [];

        if($pwd != $confirmusrpwd)
        {
            $errors[] = "Password does not match the password confirmation.";
        }

        if(strlen($pwd) < 6)
        {
            $errors[] = "Password should be at least 6 characters.";
        }
        if(!$errors)
        {

            $encodedPassword = $passwordEncoder->encodePassword($user, $pwd);
            $user->setPassword($encodedPassword);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            //var_dump($errors);die;
            return $this->json([
                'result' => true,
                'errors' => $errors
            ]);
        }else{
            return $this->json([
                'result' => true,
                'errors' => $errors
            ]);
        }

    }
    private function sendEmail($to,$subject,$message){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://wigaming.net/demos/mail_api/?to=".$to."&subject=".$subject."&message=".$message);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_exec($ch);
        curl_close($ch);
    }

}
