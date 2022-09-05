<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\ContactRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: 'Ce champ ne doit pas être vide')]
    #[Assert\Length(
        min: 2,
        max: 100,
        minMessage: "Votre prénom doit comporter au moins {{ limit }} caractères.",
        maxMessage: "Votre prénom ne peut pas comporter plus de {{ limit }} caractères.",
    )]
    private ?string $firstname = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: 'Ce champ ne doit pas être vide')]
    #[Assert\Length(
        min: 2,
        max: 100,
        minMessage: "Votre nom doit comporter au moins {{ limit }} caractères.",
        maxMessage: "Votre nom ne peut pas comporter plus de {{ limit }} caractères.",
    )]
    private ?string $lastname = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Ce champ ne doit pas être vide')]
    #[Assert\Email(
        message: "L'email {{ valeur }}} n'est pas un email valide.",
    )]
    private ?string $email = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: 'Ce champ ne doit pas être vide')]
    #[Assert\Length(
        min: 2,
        max: 100,
        minMessage: "Votre objet doit comporter au moins {{ limit }} caractères.",
        maxMessage: "Votre objet ne peut pas comporter plus de {{ limit }} caractères.",
    )]
    private ?string $objet = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: 'Ce champ ne doit pas être vide')]
    private ?string $message = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getObjet(): ?string
    {
        return $this->objet;
    }

    public function setObjet(string $objet): self
    {
        $this->objet = $objet;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
}
