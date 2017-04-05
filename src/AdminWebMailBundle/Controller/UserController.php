<?php

namespace AdminWebMailBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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

}
