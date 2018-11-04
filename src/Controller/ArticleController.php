<?php

namespace App\Controller;



use App\Entity\Article;
use App\Entity\Comment;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Twig\Environment;

class ArticleController extends AbstractController
{




    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage(ArticleRepository $repository)
    {

        $articles = $repository->findAll();



        return $this->render('article/homepage.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/news/{slug}", name="article_show")
     */
    public function show(Article $article, Request $request )
    {
        $author = $request->getSession()->get(Security::LAST_USERNAME);
        if ($author == null){
            $author = 'anonymous';
        }

        return $this->render('article/show.html.twig', [
            'article' => $article,
            'author' => $author,
        ]);
    }
    /**
     * @Route("/news/{slug}/comment", name="app_article_comment")
     */
    public function comment(EntityManagerInterface $em, Request $request, Article $article)
    {
        $author = $request->getSession()->get(Security::LAST_USERNAME);
        if ($author == null){
            $author = 'anonymous';
        }


        $comment = new Comment();
        $comment->setContent($request->request->get('comment'))
            ->setAuthorName($author)
            ->setArticle($article)
        ->setIsDeleted($request->request->getBoolean('false'));




        $em->persist($comment);
        $em->flush();

        return $this->redirectToRoute( 'article_show', ['slug' => $article->getSlug()]);

    }




}