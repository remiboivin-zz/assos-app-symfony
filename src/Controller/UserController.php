<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\UserType;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Flex\Response;

class UserController extends AbstractController
{

    /**
    * @Route("/users/{id}/remove/", name="remove")
    */
    public function remove($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $users =  $this->getDoctrine()
        ->getRepository(User::class)
        ->find($id);
        if (!$users) {
            throw $this->createNotFoundException(
                'No User found for id '.$id
            );
        }
        $entityManager->remove($users);
        $entityManager->flush();
        return $this->redirectToRoute('users');
    }

    /**
    * @Route("/users/", name="users")
    */
    public function index()
    {
        $tmp =  $this->getDoctrine()
        ->getRepository(User::class)
        ->findAll();
        $i = 0;
        if (!$tmp) {
            throw $this->createNotFoundException(
                'No datas found'
            );
        }
        foreach ($tmp as $key => $value) {
            $users[$i] = ['id' => $value->getId(),
            'name' => $value->getName(),
            'email' => $value->getEmail()
        ];
        $i +=1;
    }
    return $this->render('user/index.html.twig', [
        'users' => $users,
    ]);
}

/**
* @Route("/user/{id}", name="user")
*/

public function user($id)
{
    $tmp =  $this->getDoctrine()
    ->getRepository(User::class)
    ->find($id);
    if (!$tmp){
        throw $this->createNotFoundException(
            'No User found for id '.$id
        );
    }
    $user = ['id' => $tmp->getId(),
    'name' => $tmp->getName(),
    'email' => $tmp->getEmail()
];
return $this->render('user/profil.html.twig', [
    'user' => $user,
]);

}

/**
* @Route("/user/{id}/update", name="update")
*/

public function update($id, Request $request)
{
    // $entityManager = $this->getDoctrine()->getManager();
    $users =  $this->getDoctrine()
    ->getRepository(User::class)
    ->find($id);
    if (!$users) {
        throw $this->createNotFoundException(
            'No User found for id '.$id
        );
    }
    $user = new User();
    $form = $this->createForm(UserType::class, $user);

    $form->handleRequest($request);

    //echo $article->getTitle();
    if ($form->isSubmitted()) {
        $entityManager = $this->getDoctrine()->getManager();
        $users->setName($user->getName());
        $users->setPassword($user->getPassword());
        $users->setEmail($user->getEmail());

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($users);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();
        dump($users);
    }

    return $this->render('user/new.html.twig', array(
        'form' => $form->createView(),
    ));
}

/**
* @Route("/users/new", name="new")
*/
public function new(Request $request)
{

    $users = new User();
    $users->setName('Hello World');
    $users->setPassword('Un très court article.');
    $users->setEmail('Zozor');

    $form = $this->createForm(UserType::class, $users);

    $form->handleRequest($request);

    //echo $article->getTitle();
    if ($form->isSubmitted()) {
        $entityManager = $this->getDoctrine()->getManager();
        $user = new User();

        $user->setName($users->getName());
        $user->setPassword($users->getPassword());
        $user->setEmail($users->getEmail());

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($user);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        dump($users);
    }

    return $this->render('user/new.html.twig', array(
        'form' => $form->createView(),
    ));
}
}
