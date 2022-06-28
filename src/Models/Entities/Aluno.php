<?php


namespace App\Models\Entities;

/**
 * @Entity @Table(name="alunos")
 * @ORM @Entity(repositoryClass="App\Models\Repository\AlunoRepository")
 */
class Aluno
{
    /**
     * @Id @GeneratedValue @Column(type="integer")
     */
    protected ?int $id = null;

    /**
     * @Column(type="string")
     */
    protected string $name = '';

    /**
     * @Column(type="string")
     */
    protected string $email = '';

    /**
     * @Column(type="string")
     */
    protected string $password = '';

    /**
     * @Column(type="string")
     */
    public string $matricula = '';

    public function getMatricula(): string
    {
        return $this->matricula;
    }

    public function setMatricula(string $matricula): Aluno
    {
        $this->matricula = $matricula;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): Aluno
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Aluno
    {
        $this->name = $name;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): Aluno
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): Aluno
    {
        $this->password = $password;
        return $this;
    }
}