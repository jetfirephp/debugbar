<?php
/*
 * This file is part of the DebugBar package.
 *
 * (c) 2013 Maxime Bouroumeau-Fuseau
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DebugBar\Bridge\Twig;

use DebugBar\DataCollector\AssetProvider;
use DebugBar\DataCollector\DataCollector;
use DebugBar\DataCollector\Renderable;
use Twig_Profiler_Profile;

/**
 * Collects data about rendered templates
 *
 * http://twig.sensiolabs.org/
 *
 * Your Twig_Environment object needs to be wrapped in a
 * TraceableTwigEnvironment object
 *
 * <code>
 * $env = new TraceableTwigEnvironment(new Twig_Environment($loader));
 * $debugbar->addCollector(new TwigCollector($env));
 * </code>
 */
class TwigCollector extends DataCollector implements Renderable, AssetProvider
{
    private $dumper;
    private $profiler;

    public function __construct(TwigProfilerDumperHtml $dumper,Twig_Profiler_Profile $profiler)
    {
        $this->dumper = $dumper;
        $this->profiler = $profiler;
    }

    public function collect()
    {
        return $this->dumper->dump($this->profiler);
    }

    public function getName()
    {
        return 'twig';
    }

    public function getWidgets()
    {
        return array(
            'twig' => array(
                'icon' => 'leaf',
                'widget' => 'PhpDebugBar.Widgets.TemplatesWidget',
                'map' => 'twig',
                'default' => '[]'
            ),
            'twig:badge' => array(
                'map' => 'twig.nb_templates',
                'default' => 0
            )
        );
    }

    public function getAssets()
    {
        return array(
            'css' => 'widgets/templates/widget.css',
            'js' => 'widgets/templates/widget.js'
        );
    }
}
