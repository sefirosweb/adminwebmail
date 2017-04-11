<?php

namespace AdminWebMailBundle\Controller;

use AdminWebMailBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function getUsersJSONAction()
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->createQueryBuilder()
            ->select('u.id, u.email, d.id AS domain')
            ->from('AdminWebMailBundle:User', 'u')
            ->join('u.domain', 'd')
            ->getQuery()->getArrayResult();

        $serializer = $this->container->get('serializer');
        $data = $serializer->serialize($users, 'json');
        return new Response($data);
    }

    private function getUserAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->createQueryBuilder()
            ->select('u.id, u.email, d.id AS domain')
            ->from('AdminWebMailBundle:User', 'u')
            ->join('u.domain', 'd')
            ->where('u.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getSingleResult();
        return $user;
    }

    public function addUserAction(Request $request)
    {
        $serializer = $this->container->get('serializer');

        $email = $request->get('newEmailText');
        $pass1 = $request->get('newPasswordText1');
        $pass2 = $request->get('newPasswordText1');
        $domain = explode("@", $email)[1];

        if ($pass1 != $pass2) {
            $data = $serializer->serialize(array("success" => "false"), 'json');
            return new Response($data);
        }
        $em = $this->getDoctrine()->getManager();


        $domain = $this->getDoctrine()
            ->getRepository("AdminWebMailBundle:Domain")
            ->findOneBy(array("name" => $domain));


        $user = new User();
        $user->setEmail($email);
        $user->setPassword($pass1);
        $user->setDomain($domain);

        $em->persist($user);
        $em->flush();


        $data = $serializer->serialize(array("success" => "true", "user" => $user), 'json');
        return new Response($data);
    }

}
