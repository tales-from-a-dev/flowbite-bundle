<?php

declare(strict_types=1);

namespace TalesFromADev\FlowbiteBundle\Tests;

use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Bridge\Twig\Extension\TranslationExtension;
use Symfony\Bridge\Twig\Test\FormLayoutTestCase;
use Symfony\Component\Form\FormRenderer;
use Symfony\Component\Form\FormView;
use TalesFromADev\FlowbiteBundle\Tests\Fixtures\StubTranslator;
use TalesFromADev\Twig\Extra\Tailwind\TailwindExtension;
use TalesFromADev\Twig\Extra\Tailwind\TailwindRuntime;
use Twig\Environment;
use Twig\RuntimeLoader\RuntimeLoaderInterface;

abstract class AbstractFlowbiteLayoutTestCase extends FormLayoutTestCase
{
    protected function registerTwigRuntimeLoader(Environment $environment, FormRenderer $renderer): void
    {
        parent::registerTwigRuntimeLoader($environment, $renderer);

        $tailwindLoader = $this->createMock(RuntimeLoaderInterface::class);
        $tailwindLoader->expects($this->any())->method('load')->willReturn(new TailwindRuntime());

        $environment->addRuntimeLoader($tailwindLoader);
    }

    protected function assertWidgetMatchesXpath(FormView $view, array $vars, string $xpath): void
    {
        $this->assertMatchesXpath($this->renderWidget($view, array_merge([], $vars)), $xpath);
    }

    protected function getTemplatePaths(): array
    {
        return [
            __DIR__.'/../vendor/symfony/twig-bridge/Resources/views/Form',
            __DIR__.'/../templates/form',
        ];
    }

    protected function getTwigExtensions(): array
    {
        return [
            new TranslationExtension(new StubTranslator()),
            new FormExtension(),
            new TailwindExtension(),
        ];
    }

    protected function getThemes(): array
    {
        return [
            'default.html.twig',
        ];
    }
}
