<?php


namespace App\Models\Entities;
use App\Helpers\Utils;

/**
 * @Entity @Table(name="users")
 * @ORM @Entity(repositoryClass="App\Models\Repository\UserRepository")
 */

class User
{
    /**
     * @Id @GeneratedValue @Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @Column(type="string")
     */
    private string $name = '';

    /**
     * @Column(type="string")
     */
    private string $email = '';

    /**
     * @Column(type="string")
     */
    private string $phone = '';

    /**
     * @Column(type="string")
     */
    private string $path = '';


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): User
    {
        $this->name = $name;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): User
    {
        $this->email = $email;
        return $this;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): User
    {
        $this->phone = Utils::onlyNumbers($phone);
        return $this;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function setPath(string $path): User
    {
        $this->path = $path;
        return $this;
    }
}