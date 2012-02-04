<?php

/* GameHangmanBundle:Game:won.html.twig */
class __TwigTemplate_5fcb9aa73125c2efcd0a956b844bc0eb extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'body' => array($this, 'block_body'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "GameHangmanBundle::layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->getParent($context)->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_title($context, array $blocks = array())
    {
        // line 5
        echo "Hangman Game - You won!";
    }

    // line 9
    public function block_body($context, array $blocks = array())
    {
        // line 10
        echo "
    <p>
        Congratulations, you found the word <strong>";
        // line 12
        echo twig_escape_filter($this->env, $this->getContext($context, "word"), "html", null, true);
        echo "</strong> and won this party.
    </p>

";
    }

    public function getTemplateName()
    {
        return "GameHangmanBundle:Game:won.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
