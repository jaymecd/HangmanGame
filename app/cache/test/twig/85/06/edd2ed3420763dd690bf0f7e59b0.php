<?php

/* GameHangmanBundle:Default:index.html.twig */
class __TwigTemplate_8506edd2ed3420763dd690bf0f7e59b0 extends Twig_Template
{
    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "Hello ";
        echo twig_escape_filter($this->env, $this->getContext($context, "name"), "html", null, true);
        echo "!
";
    }

    public function getTemplateName()
    {
        return "GameHangmanBundle:Default:index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
