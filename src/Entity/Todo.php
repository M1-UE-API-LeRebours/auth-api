<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\TodoRepository;
use App\State\CreateTodoProcessor;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TodoRepository::class)]
#[ApiResource(
    operations:[
        new GetCollection(
            normalizationContext: ["groups" => ["todos:read"]],
            security: "is_authenticated()"
        ),
        new Get(
            normalizationContext: ["groups" => ["todos:read"]],
            security: "is_authenticated()"
        ),
        new Post(
            normalizationContext: ["groups" => ["todos:read"]],
            denormalizationContext: ["groups" => ["todos:write"]],
            security: "is_authenticated()",
            processor: CreateTodoProcessor::class
        ),
        new Put(
            normalizationContext: ["groups" => ["todos:read"]],
            denormalizationContext: ["groups" => ["todos:write"]],
            security: "is_authenticated()"
        ),
        new Patch(
            normalizationContext: ["groups" => ["todos:read"]],
            denormalizationContext: ["groups" => ["todos:write"]],
            security: "is_authenticated()"
        ),
        new Delete(
            security: "is_authenticated()"
        )
    ]
)]
class Todo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['todos:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['todos:read', 'todos:write'])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Length(min: 3, max: 255)]
    #[Assert\Type(type: 'string')]
    private ?string $label = null;

    #[ORM\Column]
    #[Groups(['todos:read','todos:write'])]
    #[Assert\NotNull]
    #[Assert\Type(type: 'boolean')]
    private ?bool $done = false;

    #[ORM\ManyToOne(inversedBy: 'todos')]
    #[ORM\JoinColumn(nullable: false)]
    //#[Groups(['todos:read'])]
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

    public function getDone(): ?bool
    {
        return $this->done;
    }

    public function setDone(bool $done): static
    {
        $this->done = $done;

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
