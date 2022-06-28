<?php


namespace App\Models\Entities;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity @Table(name="quiz")
 * @ORM @Entity(repositoryClass="App\Models\Repository\QuizRepository")
 */

class Quiz
{
    /**
     * @Id @GeneratedValue @Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @Column(type="string")
     */
    private string $dificuldade = '';

    /**
     * @Column(type="string")
     */
    private string $name = '';

    /**
     * @OneToMany(targetEntity="PerguntaQuiz", mappedBy="quiz", cascade={"persist"})
     */
    private $perguntas;

    public function __construct()
    {
        $this->perguntas = new ArrayCollection();
    }

    public function addPergunta(PerguntaQuiz $perguntaQuiz): Quiz
    {
        $this->perguntas->add($perguntaQuiz);
        $perguntaQuiz->setQuiz($this);
        return $this;
    }

    public function resetPerguntas()
    {
        return $this->perguntas->clear();
    }

    public function removeFunction(PerguntaQuiz $perguntaQuiz): bool
    {
        return $this->perguntas->removeElement($perguntaQuiz);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDificuldade(): string
    {
        return $this->dificuldade;
    }

    public function setDificuldade(string $dificuldade): Quiz
    {
        $this->dificuldade = $dificuldade;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Quiz
    {
        $this->name = $name;
        return $this;
    }

    public function getPerguntas()
    {
        return $this->perguntas;
    }

    public function setPerguntas(ArrayCollection $perguntas): Quiz
    {
        $this->perguntas = $perguntas;
        return $this;
    }
}