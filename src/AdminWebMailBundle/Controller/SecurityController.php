<?php

namespace AdminWebMailBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends Controller
{
    public function LoginAction(Request $request)
    {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirect($this->generateUrl('admin_web_mail_homepage'));
        }

        /*$email = $request->get('inputEmail');
        $password = $request->get('inputPassword');

        //Salt from BBDD!
        $salt = "SaltWebMail";
        $password = crypt($password, sprintf('$6$' . $salt));

        $user = $this->getDoctrine()
            ->getRepository('AdminWebMailBundle:User')
            ->findOneBy(array(
                "username" => $email,
                "password" => $password,
                "admin" => 1
            ));
//
        if($user){
            $session = $request->getSession();
            $session->set("id",$user->getId());
            $session->set("username",$user->getUsername());
        }else{
            return $this->redirect($this->generateUrl('form_web_mail_homepage'));
        }


        die('<hr>died');*/

        $authenticationUtils = $this->get('security.authentication_utils');

        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('AdminWebMailBundle::login.html.twig', array(
            'last_username' => $lastUsername,
            'error' => $error
        ));

    }
}
