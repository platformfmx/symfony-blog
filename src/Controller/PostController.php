<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    /**
     * @Route("/post", name="post")
     */
    public function index()
    {
        $posts = [
          [
              'title' => 'Заголовок 1 поста',
              'body'  => 'Тело 1 поста'
          ],
          [
              'title' => 'Заголовок 2 поста',
              'body'  => 'Тело 2 поста'
          ],
        ];
        return $this->render('post/index.html.twig', [
            'posts' => $posts
        ]);
    }
}
