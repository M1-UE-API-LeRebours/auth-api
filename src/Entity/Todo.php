<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\TodoRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: TodoRepository::class)]
#[ApiResource(
    operations:[
        new GetCollection(
            normalizationContext: ["groups" => ["todo:read"]],
            security: "is_authenticated()"
        )
    ]
)]
class Todo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['todo:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['todo:read'])]
    private ?string $label = null;

    #[ORM\Column]
    #[Groups(['todo:read'])]
    private ?bool $isDone = null;

    #[ORM\ManyToOne(inversedBy: 'todos')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['todo:read'])]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function isDone(): ?bool
    {
        return $this->isDone;
    }

    public function setDone(bool $isDone): static
    {
        $this->isDone = $isDone;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
