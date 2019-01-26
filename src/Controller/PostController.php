<?php
/**
 * Created by PhpStorm.
 * User: yamadote
 * Date: 1/15/19
 * Time: 10:41 AM.
 */

namespace App\Controller;

use App\Entity\FilterPost;
use App\Entity\Post;
use App\Form\FilterPostType;
use App\Form\PostType;
use App\Repository\PostRepository;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
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
     * @param PostRepository $repository
     * @param PaginatorInterface $paginator
     * @return Response
     *
     * @Route("/", name="post_index", methods={"GET"})
     */
    public function index(Request $request, PostRepository $repository, PaginatorInterface $paginator): Response
    {
        switch ($request->query->get('view')) {
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

        $filter = new FilterPost();
        $form = $this->createForm(FilterPostType::class, $filter);
        $form->handleRequest($request);

        $queryBuilder = $repository->findAllQueryBuilder();

        if (!$form->isEmpty()) {
            $queryBuilder = $repository->filterQueryBuilder($filter, $queryBuilder);
        }

        /** @var SlidingPagination $pagination */
        $pagination = $paginator->paginate(
            $queryBuilder->getQuery(),
            $request->query->getInt('page', 1),
            $count
        );

        return $this->render($template, [
            'pagination' => $pagination,
            'filter' => $filter,
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @Route("/new", name="post_new", methods={"GET", "POST"})
     * @IsGranted("ROLE_USER")
     */
    public function new(Request $request): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            $this->addFlash('success', 'Post created');

            return $this->redirectToRoute('post_show', ['slug' => $post->getSlug()]);
        }

        return $this->render('post/new.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param Post $post
     * @return Response
     *
     * @Route("/{slug}/edit", name="post_edit", methods={"GET", "POST"})
     * @IsGranted("POST_EDIT", subject="post")
     */
    public function edit(Request $request, Post $post): Response
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Post updated');

            return $this->redirectToRoute('post_show', ['slug' => $post->getSlug()]);
        }

        return $this->render('post/edit.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Post $post
     * @return Response
     *
     * @Route("/{slug}", name="post_show", methods={"GET"})
     */
    public function show(Post $post): Response
    {
        return $this->render('post/show.html.twig', [
            'post' => $post,
        ]);
    }

    /**
     * @param Request $request
     * @param Post $post
     * @return Response
     *
     * @Route("/{slug}", name="post_delete", methods={"DELETE"})
     * @IsGranted("POST_EDIT", subject="post")
     */
    public function delete(Request $request, Post $post): Response
    {
        if ($this->isCsrfTokenValid('delete' . $post->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($post);
            $em->flush();

            $this->addFlash('success', 'Post deleted');
        }

        return $this->redirectToRoute('post_index');
    }
}
