<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleAdminController extends AbstractController
{

    /**
     * @Route("/admin/article/create", name="app_admin_article_create")
     */
    public function create()
    {
        return $this->render('article/create.html.twig');
    }

    /**
     * @Route("/admin/{slug}/updateForm", name="app_admin_article_updateForm")
     */
    public function updateForm(Article $article)
    {
        return $this->render('article/update.html.twig',[
            'article' => $article,

        ]);

    }

    /**
     * @Route("/admin/article/new", name="app_admin_article_new")
     */
    public function new(EntityManagerInterface $em, Request $request)
    {

            $article = new Article();
            $article->setTitle($request->request->get('title'))
                ->setAuthor($request->request->get('author'))
                ->setSlug($request->request->get('title') . rand(100, 999))
                ->setContent($request->request->get('content'))
                ->setCreatedAt(new \DateTime());


            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('app_homepage');


    }

    /**
     * @Route("/admin/{slug}/update", name="app_admin_article_update")
     */
    public function update(Article $article, EntityManagerInterface $em, Request $request)
    {

        $article->setTitle($request->request->get('title'))
            ->setAuthor($request->request->get('author'))
            ->setSlug($request->request->get('title') . rand(100, 999))
            ->setContent($request->request->get('content'))
            ->setCreatedAt(new \DateTime());



        $em->flush();

        return $this->redirectToRoute('app_homepage');


    }

    /**
     * @Route("/admin/{slug}/delete", name="app_admin_article_delete")
     */
    public function delete(Article $article, EntityManagerInterface $em)
    {
        $em->remove($article);
        $em->flush();
        return $this->redirectToRoute('app_homepage');

    }

    /**
     * @Route("/admin/{slug}/comment/delete", name="app_admin_comment_delete")
     */
    public function deleteComment(Article $article, EntityManagerInterface $em, Comment $comment)
    {

        $em->remove($comment);
        $em->flush();

        return $this->redirectToRoute( 'article_show', ['slug' => $article->getSlug()]);
    }




}
