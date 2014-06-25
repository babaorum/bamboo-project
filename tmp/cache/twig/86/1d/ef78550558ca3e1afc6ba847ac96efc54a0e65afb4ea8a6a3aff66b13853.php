<?php

/* hello/world.html.twig */
class __TwigTemplate_861def78550558ca3e1afc6ba847ac96efc54a0e65afb4ea8a6a3aff66b13853 extends Twig_Template
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
        echo "

<!doctype html>
<html lang=\"en\">
<head>
    <meta charset=\"UTF-8\">
    <title>Walrus welcome page</title>
</head>
<body>
<h1>";
        // line 10
        echo twig_escape_filter($this->env, (isset($context["speak"]) ? $context["speak"] : null), "html", null, true);
        echo "</h1>

<p>Welcome on Walrus Framework.</p>
</body>
</html>
";
    }

    public function getTemplateName()
    {
        return "hello/world.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  30 => 10,  19 => 1,);
    }
}
