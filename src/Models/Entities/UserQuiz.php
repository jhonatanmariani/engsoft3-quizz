<?php


namespace App\Models\Entities;

/**
 * @Entity @Table(name="user_quiz")
 * @ORM @Entity(repositoryClass="App\Models\Repository\UserQuizRepository")
 */
class UserQuiz
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
    private string $password = '';

    /**
     * @Column(type="string")
     */
    private string $matricula = '';

    /**
     * @Column(type="integer")
     */
    private int $tipoUsuario = 0;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): UserQuiz
    {
        $this->name = $name;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): UserQuiz
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): UserQuiz
    {
        $this->password = $password;
        return $this;
    }

    public function getMatricula(): string
    {
        return $this->matricula;
    }

    public function setMatricula(string $matricula): UserQuiz
    {
        $this->matricula = $matricula;
        return $this;
    }

    public function getTipoUsuario(): int
    {
        return $this->tipoUsuario;
    }

    public function setTipoUsuario(int $tipoUsuario): UserQuiz
    {
        $this->tipoUsuario = $tipoUsuario;
        return $this;
    }
}