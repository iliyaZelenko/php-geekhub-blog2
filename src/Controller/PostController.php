<?php
/**
 * Created by PhpStorm.
 * User: yamadote
 * Date: 1/15/19
 * Time: 10:41 AM.
 */

namespace App\Controller;

use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/post")
 */
class PostController extends AbstractController
{
    /**
     * @param Post $post
     * @return Response
     *
     * @Route("/{slug}", name="post_show")
     */
    public function show(Post $post): Response
    {
        return $this->render('post/show.html.twig', [
            'post' => $post,
        ]);
    }
}
