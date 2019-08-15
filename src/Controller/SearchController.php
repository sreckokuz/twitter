<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{

    public function searchBar(){
        $form = $this->createFormBuilder(null)
            ->add('query', TextType::class)
            ->add('search', SubmitType::class)
            ->getForm();
        return '';
    }

    /**
     * @Route("/search", name="search")
     */
    public function search(Request $request) {

        $qresult = $this->getDoctrine()->getRepository(User::class)->searchUserByTitle($request->query->get('q'));
        //dd($qresult);
        /** @var User $user */
        $user = $this->getUser();
        $count = $user->getPosts()->count();
        $allUsers = $this->getDoctrine()->getRepository(User::class)->findAll();
        $usersWith5PostsAndMore = $this->getDoctrine()->getRepository(User::class)->usersWithMoreThan5Posts();
        return $this->render('search/index.html.twig',
                [
                    'user' => $user,
                    'allUsers' => $allUsers,
                    'count' => $count,
                    'usersWith5PostsAndMore' => $usersWith5PostsAndMore,
                    'searchedUsers' => $qresult
                ]);
    }


}
