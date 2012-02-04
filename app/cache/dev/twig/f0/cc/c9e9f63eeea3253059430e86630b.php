<?php

/* GameHangmanBundle:Game:index.html.twig */
class __TwigTemplate_f0ccc9e9f63eeea3253059430e86630b extends Twig_Template
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
        echo "Hangman Game";
    }

    // line 9
    public function block_body($context, array $blocks = array())
    {
        // line 10
        echo "
    <p>
        You still have ";
        // line 12
        echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, "game"), "remainingAttempts"), "html", null, true);
        echo " remaining attempts.
    </p>

    <p>
        ";
        // line 16
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute($this->getContext($context, "game"), "wordLetters"));
        foreach ($context['_seq'] as $context["_key"] => $context["letter"]) {
            // line 17
            echo "
            ";
            // line 18
            echo twig_escape_filter($this->env, (($this->getAttribute($this->getContext($context, "game"), "isLetterFound", array($this->getContext($context, "letter"), ), "method")) ? ($this->getContext($context, "letter")) : ("?")), "html", null, true);
            echo "

        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['letter'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
        // line 21
        echo "    </p>

    <h2>Try a letter</h2>

        <p>
            ";
        // line 26
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable(range("A", "Z"));
        foreach ($context['_seq'] as $context["_key"] => $context["letter"]) {
            // line 27
            echo "                <a href=\"";
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("play_letter", array("letter" => $this->getContext($context, "letter"))), "html", null, true);
            echo "\">
                    ";
            // line 28
            echo twig_escape_filter($this->env, $this->getContext($context, "letter"), "html", null, true);
            echo "
                </a>&nbsp;
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['letter'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
        // line 31
        echo "        </p>

    <h2>Try a word</h2>

        <form action=\"";
        // line 35
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("play_word"), "html", null, true);
        echo "\" method=\"post\">
            <p>
                <label for=\"word\">Word:</label>
                <input type=\"text\" name=\"word\"/>
                <button type=\"submit\">Let me guess...</button>
            </p>
        </form>

";
    }

    public function getTemplateName()
    {
        return "GameHangmanBundle:Game:index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
