<?php


namespace App\Models\Entities;
/**
 * @Entity @Table(name="perguntaQuiz")
 * @ORM @Entity(repositoryClass="App\Models\Repository\PerguntaQuizRepository")
 */

class PerguntaQuiz
{
    /**
     * @Id @GeneratedValue("NONE")
     * @ManyToOne(targetEntity="Quiz", inversedBy="perguntas", cascade={"persist"})
     * @JoinColumn(name="quiz", referencedColumnName="id")
     */
    private Quiz $quiz;

    /**
     * @Id @GeneratedValue("NONE")
     * @ManyToOne(targetEntity="Pergunta", inversedBy="perguntas", cascade={"persist"})
     * @JoinColumn(name="pergunta", referencedColumnName="id")
     */
    private Pergunta $pergunta;

    public function getQuiz(): Quiz
    {
        return $this->quiz;
    }

    public function setQuiz(Quiz $quiz): PerguntaQuiz
    {
        $this->quiz = $quiz;
        return $this;
    }

    public function getPergunta(): Pergunta
    {
        return $this->pergunta;
    }

    public function setPergunta(Pergunta $pergunta): PerguntaQuiz
    {
        $this->pergunta = $pergunta;
        return $this;
    }
}