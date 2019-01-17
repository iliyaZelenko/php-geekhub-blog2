<?php

namespace App\DataFixtures;

use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class PostFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $title = 'Title of %u post! Lorem ipsum dolor!';
        $description = '<p>Title of %u post. Lorem ipsum dolor sit amet, fusce ullamcorper montes ipsum lorem, suscipit augue convallis eu sodales tincidunt, proin maecenas risus ultricies luctus. Etiam velit. Maecenas id sodales. Ante mi neque.</p>';
        $content = '
            <p>Content for %u post. Congue tincidunt pede mi sed. Eget per rutrum massa, vitae ut cursus consequat vestibulum, adipiscing non aliquet accumsan. Morbi fringilla volutpat vel magna, mauris ut sem pellentesque libero, neque congue, condimentum pellentesque purus phasellus augue, et platea pharetra sit dolor nibh quam. Dolor quam. Praesent mauris magnam cras lorem interdum, lorem curabitur tempor at perferendis, luctus volutpat. Amet sodales elit eu ipsum maecenas duis, ultrices consectetuer et vestibulum suspendisse congue sem, nisl in mollis nec maecenas pulvinar congue. Diam hendrerit augue pellentesque elit, rhoncus porttitor vestibulum nibh, dapibus aliquam, dictum neque suscipit risus, scelerisque ut fermentum. Quis id hendrerit, natoque eget nam donec pede sit eros. Metus at, mauris non, nulla in consectetuer, sed ipsum, eget sed. Adipiscing mollis nostra pulvinar. Et nunc nibh ultricies, dolorem pellentesque faucibus molestie proin at enim, cras leo nulla, iaculis natoque aliquet sodales est mattis. Faucibus est, sed semper velit sit ac, eu dui cursus, eu suscipit vestibulum platea imperdiet orci, quam donec commodo lorem sed iaculis accumsan.</p>
            <p>Molestie porta amet, ultrices aliquet porttitor hac feugiat. Neque ante sed condimentum sit, sapien tortor. Mollit scelerisque nam praesent ea, porta id ridiculus taciti elit volutpat eu, vel auctor. Et nisl nunc, aliquam justo posuere, ut in, turpis justo elit. At dui vehicula eu in, per aliquam, rhoncus tempor et maecenas nec in tortor.</p>
            <p>Vivamus ac. Ac augue. Purus nisl tellus. Sem etiam elementum, quis felis aliquam sodales, ornare quam morbi proin ut dui. Lectus in quis duis, vehicula quam nec at ac ut venenatis, velit vestibulum amet vel ut placerat pharetra, facilisi aenean vitae. Quisque mollis etiam elit et ullamcorper tempus, vulputate eros tincidunt at sem. Nulla imperdiet, ut sit et curabitur. Integer wisi malesuada nec metus lorem. Sapien ac aenean.</p>
        ';

        $count = 40;

        for ($i = 0; $i < $count; ++$i) {
            $post = new Post();
            $manager->persist($post);
            $post->setTitle(sprintf($title, $i));
            $post->setDescription(sprintf($description, $i));
            $post->setContent(sprintf($content, $i));
        }

        $manager->flush();
    }
}
