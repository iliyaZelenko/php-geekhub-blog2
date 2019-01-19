<?php
/**
 * Created by PhpStorm.
 * User: yamadote
 * Date: 1/17/19
 * Time: 11:49 AM.
 */

namespace App\Menu;

use App\Entity\Category;
use App\Entity\Post;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class MenuBuilder
{
    private $factory;
    private $em;
    private $requestStack;

    public function __construct(FactoryInterface $factory, EntityManagerInterface $em, RequestStack $requestStack)
    {
        $this->factory = $factory;
        $this->em = $em;
        $this->requestStack = $requestStack;
    }

    public function createMainMenu(): ItemInterface
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav');

        // add 'Home' link
        $menu
            ->addChild('Home', ['route' => 'post_index'])
            ->setLinkAttribute('class', 'nav-link')
        ;

        // add 'Last post' link
        /** @var PostRepository $postRepository */
        $postRepository = $this->em->getRepository(Post::class);
        $recentPost = $postRepository->findMostRecent();

        if ($recentPost !== null) {
            $menu
                ->addChild('Most Recent', [
                    'route' => 'post_show',
                    'routeParameters' => ['slug' => $recentPost->getSlug()],
                ])
                ->setLinkAttribute('class', 'nav-link')
            ;
        }

        // add 'Create post' link
        $menu
            ->addChild('New Post', ['route' => 'post_new'])
            ->setLinkAttribute('class', 'nav-link')
        ;

        // add 'Categories' link
        $menu
            ->addChild('Categories', ['route' => 'category_index'])
            ->setLinkAttribute('class', 'nav-link')
        ;

        return $menu;
    }

    public function createCategoryMenu(): ItemInterface
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'list-unstyled');

        $repository = $this->em->getRepository(Category::class);

        $categories = $repository->findAll();

        $query = $this->requestStack->getCurrentRequest()->query->all();

        foreach ($categories as $category) {
            $menu->addChild($category->getTitle(), [
                'route' => 'post_index',
                'routeParameters' => array_merge($query, ['filter_post[category]' => $category->getId()]),
            ]);
        }

        return $menu;
    }
}
