<?php
/**
 * Created by PhpStorm.
 * User: sreckokuzmanovic
 * Date: 16/08/2019
 * Time: 11:19
 */

namespace App\Services;


use App\Entity\Comment;
use App\Form\CommentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;


class CommentService
{
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var RouterInterface
     */
    private $router;

    public function __construct(FormFactoryInterface $formFactory, EntityManagerInterface $entityManager, RouterInterface $router)
    {
        $this->formFactory = $formFactory;
        $this->entityManager = $entityManager;
        $this->router = $router;
    }

    /**
     * @param Request $request
     * @param $post
     * @param $user
     * @return \Symfony\Component\Form\FormView
     */
    public function createCommentsForm(Request $request, $post, $user) {
        $comment = new Comment();
        $form = $this->formFactory->create(CommentType::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {

            $this->entityManager->persist($comment);
            $comment->setUser($user);
            $comment->setPost($post);
            $this->entityManager->flush();
            return $form->createView();
        }
        return $form->createView();
    }
}