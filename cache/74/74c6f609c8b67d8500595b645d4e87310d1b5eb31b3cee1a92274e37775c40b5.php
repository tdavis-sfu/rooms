<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* inspect_view.html */
class __TwigTemplate_46ada0dbda30c87a3817fdca72d3ca4b20ce1a864c3f9309b3595b97fa457309 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "
\t
<head>
  <meta charset=\"utf-8\">
  <meta http-equiv=\"x-ua-compatible\" content=\"ie=edge\">
  <title></title>
  <meta name=\"description\" content=\"\">
  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">
   <link rel=\"stylesheet\" href=\"phone.css\" >\t  

</head>

<body>

<div id='box'>
<div class='boxrow'>
\t<div id='resp-table'>
\t\t<div id='resp-table-body'>
\t\t\t<div class='row' >
\t\t\t\t<div class='cell'>
\t\t\t   \tRoom: ";
        // line 21
        echo twig_escape_filter($this->env, ($context["room"] ?? null), "html", null, true);
        echo " Building: ";
        echo twig_escape_filter($this->env, ($context["building_name"] ?? null), "html", null, true);
        echo " Faculty: ";
        echo twig_escape_filter($this->env, ($context["faculty_name"] ?? null), "html", null, true);
        echo "<br>
\t   \t\t\t
\t   \t\t\tRoom not found<br>
\t   \t\t</div>
\t   \t</div>
\t</div>
\t</div>
\t</div><div class='boxrow'><div id='resp-table'>
\t\t<div id='resp-table-body' class='container'>

\t\t\t<div class='row'><div class='cell'>\$question[number]</div><div class='cell'>\$question[question]</div><div class='cell'>\";
\t\t\t\t   if(is_null(\$form[\$question['number']])) \$stat='N/A';
\t\t\t\t   else if (\$form[\$question['number']] == 1) \$stat=\"Yes\";
\t\t\t\t   else \$stat=\"<font color='red'>No</font>\";
\t\t\t\t   echo \"\$stat </div></div>\\r\";
\t\t\t   }
\t\t\t   echo \"</div></div></div><div class='boxrow'><div id='resp-table'><div id='resp-table-body' class='container'>\\r\";
\t\t\t   echo \"<div class='row'><div class='cell'><b>Comments</b><br>\\r\";
\t\t\t   echo \"\$form[comments]</div></div>\\r<br>\";
\t\t\t   echo \"<div class='row'><div class='cell'><b>Actions</b>\\r\";
\t\t\t   echo \"\$form[actions]</div></div>\\r\";
\t\t\t   echo \"</div></div></div>\\r\";
\t\t\t   
\t\t\t   
\t\t   }
\t   }
\t   
   }
   
  echo \"</body></html>\";
  
?>";
    }

    public function getTemplateName()
    {
        return "inspect_view.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  59 => 21,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "inspect_view.html", "/Users/tjdavis/sfuvault/Sites/contracts/templates/inspect_view.html");
    }
}
