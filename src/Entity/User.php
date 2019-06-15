<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(
 *      fields = {"email"},
 *      message = "L'email '{{ value }}' que vous avez saisie est déjà utilisé !")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 3,
     *      minMessage = "Votre nom doit contenir au minimum {{ limit }} caratères")
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email(
     *      mode = "html5",
     *      message = "L'adresse email '{{ value }}' n'est pas une adresse email valide.")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 8,
     *      minMessage = "Votre mot de passe doit contenir au minimum {{ limit }} caratères")
     */
    private $password;

    /**
     * Champ de confirmation de mot de passe inexistant dans la db
     * @Assert\EqualTo(
     *      propertyPath = "password",
     *      message = "Vous n'avez pas entré le même mot de passe")
     */
    private $confirm_password;

    /**
     * tableau des roles utilisateurs ROLE_USER|ROLE_ADMIN
     * @ORM\Column(type="array")
     */
    private $roles = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getConfirmPassword(): ?string
    {
        return $this->confirm_password;
    }

    public function setConfirmPassword(string $confirm_password): self
    {
        $this->confirm_password = $confirm_password;

        return $this;
    }

    public function getRoles(){

        //return ['ROLE_USER'];
        return $this->roles;
    }

    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    public function getSalt() {
        return null;
    }

    public function eraseCredentials(){}

}
