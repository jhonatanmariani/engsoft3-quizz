<?php


namespace App\Models\Entities;

/**
 * @Entity @Table(name="perguntas")
 * @ORM @Entity(repositoryClass="App\Models\Repository\PerguntaRepository")
 */
class Pergunta
{
    /**
     * @Id @GeneratedValue @Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @Column(type="text")
     */
    private string $descricao = '';

    /**
     * @ManyToOne(targetEntity="UserQuiz")
     * @JoinColumn(name="professor", referencedColumnName="id")
     */
    private UserQuiz $professor;

    /**
     * @Column(type="string")
     */
    private string $dificuldade = '';

    /**
     * @Column(type="text")
     */
    private string $alternativa1 = '';

    /**
     * @Column(type="text")
     */
    private string $alternativa2 = '';

    /**
     * @Column(type="text")
     */
    private string $alternativa3 = '';

    /**
     * @Column(type="text")
     */
    private string $alternativa4 = '';

    /**
     * @Column(type="text")
     */
    private string $alternativa5 = '';

    /**
     * @Column(type="text")
     */
    private string $alternativaCorreta = '';


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescricao(): string
    {
        return $this->descricao;
    }

    public function setDescricao(string $descricao): Pergunta
    {
        $this->descricao = $descricao;
        return $this;
    }

    public function getProfessor(): UserQuiz
    {
        return $this->professor;
    }

    public function setProfessor(UserQuiz $professor): Pergunta
    {
        $this->professor = $professor;
        return $this;
    }

    public function getDificuldade(): string
    {
        return $this->dificuldade;
    }

    public function setDificuldade(string $dificuldade): Pergunta
    {
        $this->dificuldade = $dificuldade;
        return $this;
    }

    public function getAlternativa1(): string
    {
        return $this->alternativa1;
    }

    public function setAlternativa1(string $alternativa1): Pergunta
    {
        $this->alternativa1 = $alternativa1;
        return $this;
    }

    public function getAlternativa2(): string
    {
        return $this->alternativa2;
    }

    public function setAlternativa2(string $alternativa2): Pergunta
    {
        $this->alternativa2 = $alternativa2;
        return $this;
    }

    public function getAlternativa3(): string
    {
        return $this->alternativa3;
    }

    public function setAlternativa3(string $alternativa3): Pergunta
    {
        $this->alternativa3 = $alternativa3;
        return $this;
    }

    public function getAlternativa4(): string
    {
        return $this->alternativa4;
    }

    public function setAlternativa4(string $alternativa4): Pergunta
    {
        $this->alternativa4 = $alternativa4;
        return $this;
    }

    public function getAlternativa5(): string
    {
        return $this->alternativa5;
    }

    public function setAlternativa5(string $alternativa5): Pergunta
    {
        $this->alternativa5 = $alternativa5;
        return $this;
    }

    public function getAlternativaCorreta(): string
    {
        return $this->alternativaCorreta;
    }

    public function setAlternativaCorreta(string $alternativaCorreta): Pergunta
    {
        $this->alternativaCorreta = $alternativaCorreta;
        return $this;
    }
}