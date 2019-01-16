<?php
/**
 * Created by PhpStorm.
 * User: yamadote
 * Date: 1/15/19
 * Time: 10:41 AM.
 */

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/post")
 */
class PostController extends AbstractController
{
    /**
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     *
     * @Route("/", name="post_index")
     */
    public function index(Request $request, PaginatorInterface $paginator): Response
    {
        switch ($request->query->get('type')) {
            case 'table':
                $template = 'post/index/table.html.twig';
                $count = Post::QUANTITY_PER_PAGE['table'];
                break;
            case 'list':
                $template = 'post/index/list.html.twig';
                $count = Post::QUANTITY_PER_PAGE['list'];
                break;
            default:
                $template = 'post/index/list.html.twig';
                $count = Post::QUANTITY_PER_PAGE['list'];
        }

        /** @var PostRepository $postRepository */
        $postRepository = $this->getDoctrine()->getRepository(Post::class);

        $queryBuilder = $postRepository->findAllQueryBuilder();

        /** @var PaginationInterface $pagination */
        $pagination = $paginator->paginate(
            $queryBuilder->getQuery(),
            $request->query->getInt('page', 1),
            $count
        );

        return $this->render($template, [
            'pagination' => $pagination,
        ]);
    }

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
