<?php

declare(strict_types=1);

namespace TalesFromADev\FlowbiteBundle\Tests;

use Symfony\Contracts\Translation\TranslatorInterface;

class StubTranslator implements TranslatorInterface
{
    public function trans($id, array $parameters = [], $domain = null, $locale = null): string
    {
        return '[trans]'.strtr($id, $parameters).'[/trans]';
    }

    public function getLocale(): string
    {
        return 'en';
    }
}
