<?php
/**
 * Created by PhpStorm.
 * User: yamadote
 * Date: 1/17/19
 * Time: 8:47 PM.
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Title is empty")
     */
    private $title;

    /**
     * @var int
     *
     * @ORM\Column(name="`order1`", type="integer")
     * @Assert\NotNull(message="Order is null")
     */
    private $order;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Post", mappedBy="category", cascade={"remove"})
     */
    private $posts;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    private $updatedAt;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return int
     */
    public function getOrder(): ?int
    {
        return $this->order;
    }

    /**
     * @param int $order
     */
    public function setOrder(int $order): void
    {
        $this->order = $order;
    }

    /**
     * @return Collection|Post[]
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    /**
     * @param Post $post
     * @return Category
     */
    public function addPost(Post $post): self
    {
        if ($this->posts->contains($post)) {
            throw new \LogicException('Add post that already exists in array!');
        }

        $this->posts->add($post);

        if ($post->getCategory() === null) {
            $post->setCategory($this);
        } elseif ($post->getCategory() !== $this) {
            throw new \LogicException('Add post that already has another category!');
        }

        return $this;
    }

    /**
     * @param Post $post
     * @return Category
     */
    public function removePost(Post $post): self
    {
        if (!$this->posts->contains($post)) {
            throw new \LogicException('Remove post that already removed from array!');
        }

        $this->posts->removeElement($post);
        if ($post->getCategory() === $this) {
            $post->setCategory(null);
        }

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }
}
