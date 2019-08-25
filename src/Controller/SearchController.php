<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use App\Services\ChartService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Security("is_granted('ROLE_USER')")
 */
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
    public function search(Request $request, ChartService $chartService) {

        $qresult = $this->getDoctrine()->getRepository(User::class)->searchUserByTitle($request->query->get('q'));
//        dd($qresult);
        /** @var User $user */
        return $this->render('search/index.html.twig',
                [
                    'user' => $this->getUser(),
                    'allUsers' => $this->getDoctrine()->getRepository(User::class)->findAll(),
                    'count' => $this->getUser()->getPosts()->count(),
                    'usersWith5PostsAndMore' => $this->getDoctrine()->getRepository(User::class)->usersWithMoreThan5Posts(),
                    'searchedUsers' => $qresult,
                    'mostLikedPostAndUser' => $this->getDoctrine()->getRepository(Post::class)->mostLikedPostAndHisUser(),
                    'chartStatistic' => $chartService->getMostLikedUsersStatistic()
                ]);
    }


}
