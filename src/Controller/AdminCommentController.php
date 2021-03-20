<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\AdminCommentType;
use App\Repository\CommentRepository;

use App\Service\PaginationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminCommentController extends AbstractController
{
    /**
     * permet d'afficher la liste des commentaires
     */
    /**
     * @Route("/admin/comment/{page<\d+>?1}", name="admin_comment")
     */
    public function index(CommentRepository $repo, $page, PaginationService $pagination): Response
    {
        $pagination->setEntityClass(Comment::class)
                    ->setPage($page);


    //$comments= $repo->findAll();
        return $this->render('admin/comment/index.html.twig', [
//'comments'=> $comments
        'pagination'=>$pagination

        ]);
    }

    /**
     * permet d afficher le formulaire d édition d'un commentaire
     */
    /**
     *
     * @Route("/admin/comment/{id}/edit", name="admin_comment_edit")
     * @param Comment $comment
     */
    public function edit(Comment $comment, Request $request ,EntityManagerInterface $manager)
    {
        $form= $this->createForm(AdminCommentType::class, $comment);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {$manager->persist($comment);
        $manager->flush();
        $this->addFlash('success',
            " le commentaire numero <stong>{$comment->getId()}</stong> à été bien modifiée");

        }
        return $this->render('admin/comment/edit.html.twig' ,[
       'comment'=>$comment,
            'form'=>$form->createView()
        ]);
    }
    /**
     * permet à un admin de supprimer un commentaire
     */
    /**
     * @Route("/admin/comment/{id}/delete", name="admin_comment_delete")
     */
     public function delete(Comment $comment , EntityManagerInterface $manager){
        $manager->remove($comment);
        $manager->flush();
         $this->addFlash('success', "le commentaire <stong>{$comment->getAuthor()->getfullName()}</stong> à été supprimé");
        return $this->redirectToRoute('admin_comment');
     }
}
