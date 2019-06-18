<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WorkRepository")
 * @UniqueEntity("title")
 * @Vich\Uploadable
 */
class Work
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=40)
     * @Assert\Length(
     *      min = 3,
     *      max = 40,
     *      minMessage = "Votre titre doit contenir au minimum {{ limit }} caractères",
     *      maxMessage = "Votre titre doit contenir au maximum {{ limit }} caractères")
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=60)
     * @Assert\Length(
     *      min = 3,
     *      max = 60,
     *      minMessage = "Votre sous-titre doit contenir au minimum {{ limit }} caractères",
     *      maxMessage = "Votre sous-titre doit contenir au maximum {{ limit }} caractères")
     */
    private $subtitle;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(
     *      min = 10,
     *      minMessage = "Votre contenu doit contenir au minimum {{ limit }} caractères")
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Url(
     *      message = "Cette '{{ value }}' n'est pas une URL valide")
     */
    private $link;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Category", mappedBy="works")
     */
    private $categories;

    /**
     * @Vich\UploadableField(mapping="work_images", fileNameProperty="imageName")
     * @Assert\Image(
     *      mimeTypes = "image/jpeg", "image/jpg", "image/png")
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $imageName;
    
    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $imageAlt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
    }

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

    public function getSubtitle(): ?string
    {
        return $this->subtitle;
    }

    public function setSubtitle(string $subtitle): self
    {
        $this->subtitle = $subtitle;

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

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->addWork($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
            $category->removeWork($this);
        }

        return $this;
    }

    /**
     * @return  File
     */ 
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * @param  File|null  $imageFile
     * @return  self
     */ 
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if ($this->imageFile instanceof UploadedFile) {
            $this->updatedAt = new \DateTime('now');
        }
    }

    /**
     * @return  string
     */ 
    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    /**
     * @param  string|null  $imageName
     * @return  self
     */ 
    public function setImageName(?string $imageName = null): self
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * @return  string
     */ 
    public function getImageAlt(): ?string
    {
        return $this->imageAlt;
    }

    /**
     * @param  string  $imageAlt
     * @return  self
     */ 
    public function setImageAlt(string $imageAlt): self
    {
        $this->imageAlt = $imageAlt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
