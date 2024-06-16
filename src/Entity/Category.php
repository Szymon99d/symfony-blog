<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Post as ApiPost;
use App\Controller\Admin\CategoryController;
use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ApiResource(operations:[
    new Get(),
    new ApiPost(),
    new Patch(),
    new Delete(
        name: "massDeleteCategory",
        routeName: 'app_admin_mass_delete_category',
        controller: CategoryController::class,
        uriTemplate: "/api/admin/massDelete/category" 
    ),
    new Delete()
])]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\OneToMany(targetEntity: Post::class, mappedBy: 'category')]
    private $posts;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Post[]
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts[] = $post;
            $post->setCategory($this);
        }

        return $this;
    }

    public function removePosts(): self
    {
        foreach($this->posts as $post){
            if ($this->posts->removeElement($post) && $post->getCategory() === $this) {
                $post->setCategory(null);
            }
        }
        return $this;
    }
    
    public function __toString()
    {
        return $this->name;
    }
}
