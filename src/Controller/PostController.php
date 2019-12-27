<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    /**
     * @Route("/", name="post")
     */
    public function index()
    {
        $repo = $this->getDoctrine()->getRepository(Post::class);
        $posts = $repo->findAll();
        return $this->render('post/index.html.twig', [
            'posts' => $posts
        ]);
    }

    /**
     * @Route("/post/{slug}", name="blog_show")
     */
    public function post(Post $post) {
        return $this->render('post/post.html.twig', [
           'post' => $post
        ]);
    }
}
