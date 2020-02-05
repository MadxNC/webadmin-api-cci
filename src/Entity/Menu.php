<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MenuRepository")
 */
class Menu
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $route;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $icon;

    /**
     * @ORM\Column(type="integer")
     */
    private $position;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isRouteValid;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Menu", mappedBy="parent")
     */
    private $children;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Menu", inversedBy="children")
     */
    private $parent;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Groupe", inversedBy="menus")
     */
    private $groupe;

    /**
     * @ORM\Column(type="integer")
     */
    private $niveauPermission;


    public function __construct()
    {
        $this->setIsActive(true);
        $this->setPosition(0);
        $this->children = new ArrayCollection();
        $this->setIsRouteValid(false);
        $this->groupe = new ArrayCollection();
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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getRoute(): ?string
    {
        return $this->route;
    }

    public function setRoute(string $route): self
    {
        $this->route = $route;

        return $this;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * @return Collection|Menu[]
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addChild(Menu $child): self
    {
        if (!$this->children->contains($child)) {
            $this->children[] = $child;
            $child->setParent($this);
        }

        return $this;
    }

    public function removeChild(Menu $child): self
    {
        if ($this->children->contains($child)) {
            $this->children->removeElement($child);
            // set the owning side to null (unless already changed)
            if ($child->getParent() === $this) {
                $child->removeParent();
            }
        }

        return $this;
    }


    public function getParent():? self
    {
        return $this->parent;
    }


    public function setParent($parent): self
    {
        $this->parent = $parent;
        if($parent !== null) {
            if (!$parent->children->contains($this)) {
                $parent->children[] = $this;
            }
        }
        return $this;
    }

    public function removeParent()
    {
        $this->setParent(null);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getisRouteValid()
    {
        return $this->isRouteValid;
    }

    /**
     * @param mixed $isRouteValid
     */
    public function setIsRouteValid($isRouteValid): void
    {
        $this->isRouteValid = $isRouteValid;
    }

    /**
     * @return Collection|Groupe[]
     */
    public function getGroupe(): Collection
    {
        return $this->groupe;
    }

    public function addGroupe(Groupe $groupe): self
    {
        if (!$this->groupe->contains($groupe)) {
            $this->groupe[] = $groupe;
        }

        return $this;
    }

    public function removeGroupe(Groupe $groupe): self
    {
        if ($this->groupe->contains($groupe)) {
            $this->groupe->removeElement($groupe);
        }

        return $this;
    }

    public function getNiveauPermission(): ?int
    {
        return $this->niveauPermission;
    }

    public function setNiveauPermission(int $niveauPermission): self
    {
        $this->niveauPermission = $niveauPermission;

        return $this;
    }



}
