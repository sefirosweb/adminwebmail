<?php

namespace AdminWebMailBundle\Controller;

use AdminWebMailBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $domains_raw = $em->createQueryBuilder()
            ->select('d.id, d.name')
            ->from('AdminWebMailBundle:Domain', 'd')
            ->getQuery()
            ->getResult();

        foreach ($domains_raw as $domain) {
            $domains[] = array(
                "value" => $domain['id'],
                "text" => $domain['name']
            );
        }
        return $this->render('AdminWebMailBundle::users.html.twig', array('domains' => $domains));
    }

    public function getUsersJSONAction()
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->createQueryBuilder()
            ->select('u.id, u.email, d.id AS domain')
            ->from('AdminWebMailBundle:User', 'u')
            ->join('u.Domain', 'd')
            ->getQuery()->getArrayResult();
        $data = $this->container->get('serializer')->serialize($users, 'json');
        return new Response($data);
    }

    private function getUserAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->createQueryBuilder()
            ->select('u.id, u.email, d.id AS domain')
            ->from('AdminWebMailBundle:User', 'u')
            ->join('u.Domain', 'd')
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
        $pass2 = $request->get('newPasswordText2');
        $domain = explode("@", $email)[1];

        if ($pass1 != $pass2) {
            $data = $serializer->serialize(array("success" => "false", "error" => "Passwords don't match"), 'json');
            return new Response($data);
        }

        $em = $this->getDoctrine()->getManager();
        $exists = $em->getRepository('AdminWebMailBundle:User')->findBy(array(
            'email' => $email
        ));

        if ($exists) {
            $data = $serializer->serialize(array("success" => "false", "error" => "Email alredy exist"), 'json');
            return new Response($data);
        }

        $domain = $this->getDoctrine()
            ->getRepository("AdminWebMailBundle:Domain")
            ->findOneBy(array("name" => $domain));

        $user = new User();
        $user->setEmail($email);
        $user->setPassword(crypt($pass1, '$6$' . $this->container->getParameter('saltpassword')));
        $user->setDomain($domain);

        $em->persist($user);
        $em->flush();

        $data = $serializer->serialize(array("success" => "true", "user" => $this->getUserAction($user->getId())), 'json');
        return new Response($data);
    }

    public function deleteUserAction(Request $request)
    {
        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AdminWebMailBundle:User')->find($id);
        $em->remove($user);
        $em->flush();
        $data = $this->container->get('serializer')->serialize(array("success" => "true"), 'json');
        return new Response($data);
    }

    public function updateEmailUserAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $serializer = $this->container->get('serializer');
        $id = $request->get('id');
        $email = $request->get('email');
        $domainName = explode("@", $email)[1];


        $exists = $em->getRepository('AdminWebMailBundle:User')->findOneBy(array('email' => $email));

        if ($exists) {
            $data = $serializer->serialize(array("success" => "false", "error" => "Email alredy exist"), 'json');
            return new Response($data);
        }

        $user = $em->getRepository('AdminWebMailBundle:User')->find($id);
        $domain = $em->getRepository('AdminWebMailBundle:Domain')->findOneBy(array("name" => $domainName));
        $user->setEmail($email);
        $user->setDomain($domain);
        $em->persist($user);
        $em->flush();
        $data = $serializer->serialize(array("success" => "true", "domainId" => $domain->getId()), 'json');
        return new Response($data);
    }

    public function updatePasswordUserAction(Request $request)
    {
        $serializer = $this->container->get('serializer');
        $id = $request->get('id');
        $pass1 = $request->get('changePasswordText1');
        $pass2 = $request->get('changePasswordText2');
        if ($pass1 != $pass2) {
            $data = $serializer->serialize(array("success" => "false", "error" => "Passwords don't match"), 'json');
            return new Response($data);
        }

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AdminWebMailBundle:User')->find($id);
        $user->setPassword(crypt($pass1, '$6$' . $this->container->getParameter('saltpassword')));
        $em->persist($user);
        $em->flush();

        $data = $serializer->serialize(array("success" => "true"), 'json');
        return new Response($data);
    }

    public function updateDomainUserAction(Request $request)
    {
        $id = $request->get('id');
        $idDomain = $request->get('domain');
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AdminWebMailBundle:User')->find($id);
        $domain = $em->getRepository('AdminWebMailBundle:Domain')->find($idDomain);

        $user->setDomain($domain);
        $em->persist($user);
        $em->flush();

        $data = $this->container->get('serializer')->serialize(array("success" => "true"), 'json');
        return new Response($data);
    }

}
