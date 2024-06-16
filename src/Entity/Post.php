<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post as ApiPost;
use App\Controller\Admin\PostController;
use App\Repository\PostRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;

#[ORM\Entity(repositoryClass: PostRepository::class)]
#[ApiResource(operations:[
    new Get(),
    new ApiPost(),
    new Patch(),
    new Delete(
        name: "massDeletePost",
        routeName: 'app_admin_mass_delete_post',
        controller: PostController::class,
        uriTemplate: "/api/admin/massDelete/post" 
    ),
    new Delete()
])]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\Column(type: 'text')]
    private $content;

    #[ORM\Column(type: 'datetime')]
    private $dateEntered;

    #[ORM\Column(type: 'datetime')]
    private $dateModified;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'posts')]
    #[JoinColumn(name: "category_id", referencedColumnName: "id", nullable: true, onDelete:"SET NULL")]
    private $category;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getDateEntered(): ?\DateTimeInterface
    {
        return $this->dateEntered;
    }

    public function setDateEntered(\DateTimeInterface $dateEntered): self
    {
        $this->dateEntered = $dateEntered;

        return $this;
    }

    public function getDateModified(): ?\DateTimeInterface
    {
        return $this->dateModified;
    }

    public function setDateModified(\DateTimeInterface $dateModified): self
    {
        $this->dateModified = $dateModified;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function beforeSave(): self
    {
        $nowDate = new DateTime();
        if(empty($this->getDateEntered())){
            $this->setDateEntered($nowDate);
        }
        $this->setDateModified($nowDate);
        return $this;
    }
}
