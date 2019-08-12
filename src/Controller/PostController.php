<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use App\Form\PostType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Carbon\Carbon;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
class PostController extends AbstractController
{
    /**
     * @Route("/", name="main_page")
     */
    public function index(Request $request)
    {
        //get form
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
            $user = $this->getUser();
            $em= $this->getDoctrine()->getManager();
            $post->setUser($user);
            $em->persist($post);
            $em->flush();
            $this->addFlash('success', 'You added a tweet');
            return $this->redirectToRoute('main_page');
        }

        //get all posts
        $currentUser = $this->getUser();
        $countOfAllUserPosts=0;
        $usersWith5PostsAndMore = 0;
        if($currentUser instanceof User) {

            $arrayOfUsers = $currentUser->getFollowing();

            $allPosts = $this->getDoctrine()->getRepository(Post::class)->findAllUsersFollowingPosts($arrayOfUsers, $currentUser->getId());
            $usersWith5PostsAndMore = $this->getDoctrine()->getRepository(User::class)->usersWithMoreThan5Posts();
            $countOfAllUserPosts = $currentUser->getPosts()->count();

        }
        else{
            $allPosts = $this->getDoctrine()->getRepository(Post::class)->findBy([], ['updatedAt'=>'DESC']);
        }
        return $this->render('post/index.html.twig', [
            'posts' => $allPosts,
            'form' => $form->createView(),
            'carbon'=> new Carbon(),
            'user' => $currentUser,
            'allUsers' => $this->getDoctrine()->getRepository(User::class)->findAll(),
            'count' => $countOfAllUserPosts,
            'usersWith5PostsAndMore' => $usersWith5PostsAndMore
        ]);
    }

    /**
     * @Route("/edit/{id}", name="edit_post")
     */
    public function edit(Post $post, Request $request) {
        $count = $this->getUser()->getPosts()->count();
        $usersWith5PostsAndMore = $this->getDoctrine()->getRepository(User::class)->usersWithMoreThan5Posts();
        $this->denyAccessUnlessGranted('edit', $post);
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $this->addFlash('success', 'Your twitt is edited');
            return $this->redirectToRoute('main_page');
        }
        return $this->render('post/edit.html.twig',
            [
                'form'=> $form->createView(),
                'user' => $this->getUser(),
                'allUsers' => $this->getDoctrine()->getRepository(User::class)->findAll(),
                'count' => $count,
                'usersWith5PostsAndMore' => $usersWith5PostsAndMore

            ]);
    }

    /**
     * @Route("/delete/{id}", name="delete_post")
     * @Security("is_granted('edit', post)", message="Log in first")
     *
     */
    public function delete(Post $post) {
//        $this->denyAccessUnlessGranted('delete', $post);
        $em = $this->getDoctrine()->getManager();
        $em->remove($post);
        $em->flush();
        $this->addFlash('danger', 'Your twitt is delated');
        return $this->redirectToRoute("main_page");
    }

    /**
     * @Route("/show/{id}", name="show_one_post")
     * @Security("is_granted('ROLE_USER')", message="Log in first")
     */
    public function show(Post $post) {
        $count = $this->getUser()->getPosts()->count();
        $usersWith5PostsAndMore = $this->getDoctrine()->getRepository(User::class)->usersWithMoreThan5Posts();
        return $this->render('post/show.html.twig',
            [
                'post'=>$post, 'carbon'=> new Carbon(),
                'user' => $this->getUser(),
                'allUsers' => $this->getDoctrine()->getRepository(User::class)->findAll(),
                'count' => $count,
                'usersWith5PostsAndMore' => $usersWith5PostsAndMore
        ,]);
    }

    /**
     * @Route("/user/{id}", name="all_user_tweets")
     * @Security("is_granted('ROLE_USER')")
     */
    public function userPosts(User $user) {
        $allPosts = $this->getDoctrine()->getRepository(Post::class)->findBy(['user'=>$user], ['createdAt'=>'DESC']);
        $count = $this->getUser()->getPosts()->count();
        $usersWith5PostsAndMore = $this->getDoctrine()->getRepository(User::class)->usersWithMoreThan5Posts();

        return $this->render('post/allposts.html.twig',
            [
                'allPosts' => $allPosts,
                'carbon'=> new Carbon(),
                'user' => $user,
                'allUsers' => $this->getDoctrine()->getRepository(User::class)->findAll(),
                'count' => $count,
                'usersWith5PostsAndMore' => $usersWith5PostsAndMore
            ]);
    }
}
