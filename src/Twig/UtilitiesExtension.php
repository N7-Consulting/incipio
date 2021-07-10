<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class UtilitiesExtension extends AbstractExtension
{
  public function getFilters()
  {
    return array(
      new TwigFilter(
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
