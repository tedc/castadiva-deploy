<?php

/* dialog.twig */
class __TwigTemplate_d1977c35b664b2949114fc69b57dd4c0da15aedf6b27080eeb65b43bd4105681 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<div class=\"dialog wpml-dialog\" title=\"";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["strings"]) ? $context["strings"] : null), "title", array()));
        echo "\" data-close=\"";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["strings"]) ? $context["strings"] : null), "close", array()));
        echo "\" data-refresh=\"";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["strings"]) ? $context["strings"] : null), "refresh", array()));
        echo "\" style=\"display: none;\">
\t";
        // line 2
        $this->loadTemplate("source-language.twig", "dialog.twig", 2)->display(array_merge($context, (isset($context["sourceLanguage"]) ? $context["sourceLanguage"] : null)));
        // line 3
        echo "\t<div class=\"summary\" style=\"display: none;\"></div>
\t<div class=\"spinner\"></div>
</div>
";
    }

    public function getTemplateName()
    {
        return "dialog.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  30 => 3,  28 => 2,  19 => 1,);
    }
}
/* <div class="dialog wpml-dialog" title="{{ strings.title|e }}" data-close="{{ strings.close|e }}" data-refresh="{{ strings.refresh|e }}" style="display: none;">*/
/* 	{% include 'source-language.twig' with sourceLanguage %}*/
/* 	<div class="summary" style="display: none;"></div>*/
/* 	<div class="spinner"></div>*/
/* </div>*/
/* */
