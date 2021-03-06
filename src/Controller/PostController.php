<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Cocur\Slugify\Slugify;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    /**
     * @Route("/", name="blog_posts")
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
     * @Route("/post/search", name="post_search")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function search(Request $request) {
        $repo = $this->getDoctrine()->getRepository(Post::class);

        $query = $request->query->get('q');
        $posts = $repo->searchByQuery($query);

        return $this->render('post/query_post.html.twig',[
            'posts' => $posts
        ]);
    }

    /**
     * @Route("/post/add", name="add_post")
     */
    public function addPost(Request $request, Slugify $slugify) {
        $post = new Post();

        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $post->setSlug($slugify->slugify($post->getTitle()));
            $post->setCreatedAt(new \DateTime());

            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute("blog_posts");
        }

        return $this->render("post/add.html.twig",[
            'form' => $form->createView()
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

    /**
     * @Route("/post/{slug}/edit", name="edit_post")
     * @param Post $post
     * @param Request $request
     * @param Slugify $slugify
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(Post $post, Request $request, Slugify $slugify) {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $post->setSlug($slugify->slugify($post->getTitle()));
            $em->flush();

            return $this->redirectToRoute("blog_show", [
                'slug' => $post->getSlug()
            ]);
        }

        return $this->render("post/add.html.twig", [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/post/{slug}/delete", name="delete_post")
     * @param Post $post
     */
    public function delete(Post $post) {
        $em = $this->getDoctrine()->getManager();
        $em->remove($post);
        $em->flush();

        return $this->redirectToRoute("blog_posts");
    }
}
