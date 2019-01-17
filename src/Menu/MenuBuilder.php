<?php
/**
 * Created by PhpStorm.
 * User: yamadote
 * Date: 1/17/19
 * Time: 11:49 AM.
 */

namespace App\Menu;

use App\Entity\Post;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;

class MenuBuilder
{
    private $factory;
    private $em;

    public function __construct(FactoryInterface $factory, EntityManagerInterface $em)
    {
        $this->factory = $factory;
        $this->em = $em;
    }

    public function createMainMenu(): ItemInterface
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav');

        // add 'Home' link
        $menu
            ->addChild('Link.Home', ['route' => 'post_index'])
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

        return $menu;
    }
}
