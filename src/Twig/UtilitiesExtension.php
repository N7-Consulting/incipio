<?php

namespace App\Twig;

use Twig_SimpleFilter;

class UtilitiesExtension extends \Twig_Extension
{
  public function getFilters()
  {
    return array(
      new Twig_SimpleFilter(
        'ucfirst',
        array($this, 'ucFirst'),
        array('needs_environment' => true)
      ),
    );
  }

  public function ucFirst($env, $string)
  {
    if (null !== $charset = $env->getCharset()) {
      $prefix = mb_strtoupper(mb_substr($string, 0, 1, $charset), $charset);
      $suffix = mb_substr($string, 1, mb_strlen($string, $charset));
      return sprintf('%s%s', $prefix, $suffix);
    }
    return ucfirst(strtolower($string));
  }
}
