<?php

namespace DebugBar\Bridge\Twig;

use Twig_Profiler_Profile;

class TwigProfilerDumperArray
{
    private $root;

    public function dump(Twig_Profiler_Profile $profile)
    {
        return $this->dumpProfile([],$profile);
    }

    protected function formatTemplate(Twig_Profiler_Profile $profile)
    {
        return $profile->getTemplate();
    }

    protected function formatNonTemplate(Twig_Profiler_Profile $profile)
    {
        return sprintf('%s::%s(%s)', $profile->getTemplate(), $profile->getType(), $profile->getName());
    }

    protected function formatTime(Twig_Profiler_Profile $profile, $percent)
    {
        return sprintf('%.2fms/%.0f%%', $profile->getDuration() * 1000, $percent);
    }

    private function dumpProfile($dump = [], Twig_Profiler_Profile $profile)
    {
        if ($profile->isRoot()) {
            $this->root = $profile->getDuration();
            $start = $profile->getName();
        } else {
            if ($profile->isTemplate()) {
                $start = $this->formatTemplate($profile);
            } else {
                $start = $this->formatNonTemplate($profile);
            }
        }

        $percent = $this->root ? $profile->getDuration() / $this->root * 100 : 0;

        if ($profile->getDuration() * 1000 < 1) {
            $dump['template'] = $start."\n";
        } else {
            $dump['template'] = sprintf("%s %s\n", $start, $this->formatTime($profile, $percent));
        }

        foreach ($profile as $i => $p) {
            $dump[$i] = $this->dumpProfile([],$p);
        }

        return $dump;
    }
}
