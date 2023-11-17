<?php

declare(strict_types=1);

namespace TalesFromADev\FlowbiteBundle\Tests;

use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Bridge\Twig\Extension\TranslationExtension;
use Symfony\Bridge\Twig\Form\TwigRendererEngine;
use Symfony\Component\Form\FormRenderer;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\Test\FormIntegrationTestCase;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use TalesFromADev\FlowbiteBundle\Tests\Fixtures\StubTranslator;
use TalesFromADev\Twig\Extra\Tailwind\TailwindExtension;
use TalesFromADev\Twig\Extra\Tailwind\TailwindRuntime;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\RuntimeLoader\RuntimeLoaderInterface;

abstract class FormLayoutTestCase extends FormIntegrationTestCase
{
    private FormRenderer $renderer;

    protected function setUp(): void
    {
        parent::setUp();

        $loader = new FilesystemLoader([
            __DIR__.'/../vendor/symfony/twig-bridge/Resources/views/Form',
            __DIR__.'/../templates/form',
        ]);

        $environment = new Environment($loader, ['strict_variables' => true]);
        $environment->addExtension(new TranslationExtension(new StubTranslator()));
        $environment->addExtension(new FormExtension());
        $environment->addExtension(new TailwindExtension());

        $rendererEngine = new TwigRendererEngine([
            'default.html.twig',
        ], $environment);

        $this->renderer = new FormRenderer($rendererEngine, $this->getMockBuilder(CsrfTokenManagerInterface::class)->getMock());
        $this->registerTwigRuntimeLoader($environment, $this->renderer);
    }

    protected function renderLabel(FormView $view, string $label = null, array $vars = []): string
    {
        if (null !== $label) {
            $vars += ['label' => $label];
        }

        return $this->renderer->searchAndRenderBlock($view, 'label', $vars);
    }

    protected function renderHelp(FormView $view): string
    {
        return $this->renderer->searchAndRenderBlock($view, 'help');
    }

    protected function renderErrors(FormView $view): string
    {
        return $this->renderer->searchAndRenderBlock($view, 'errors');
    }

    protected function renderWidget(FormView $view, array $vars = []): string
    {
        return $this->renderer->searchAndRenderBlock($view, 'widget', $vars);
    }

    private function registerTwigRuntimeLoader(Environment $environment, FormRenderer $renderer): void
    {
        $formRendererLoader = $this->createMock(RuntimeLoaderInterface::class);
        $formRendererLoader->expects($this->any())->method('load')->willReturnMap([
            [FormRenderer::class, $renderer],
        ]);

        $tailwindLoader = $this->createMock(RuntimeLoaderInterface::class);
        $tailwindLoader->expects($this->any())->method('load')->willReturn(new TailwindRuntime());

        $environment->addRuntimeLoader($formRendererLoader);
        $environment->addRuntimeLoader($tailwindLoader);
    }

    protected function assertMatchesXpath(string $html, string $expression, int $count = 1): void
    {
        $dom = new \DOMDocument('UTF-8');
        try {
            // Wrap in <root> node so we can load HTML with multiple tags at
            // the top level
            $dom->loadXML('<root>'.$html.'</root>');
        } catch (\Exception $e) {
            $this->fail(sprintf(
                "Failed loading HTML:\n\n%s\n\nError: %s",
                $html,
                $e->getMessage()
            ));
        }
        $xpath = new \DOMXPath($dom);
        $nodeList = $xpath->evaluate('/root'.$expression);

        if ($nodeList->length != $count) {
            $dom->formatOutput = true;
            $this->fail(sprintf(
                "Failed asserting that \n\n%s\n\nmatches exactly %s. Matches %s in \n\n%s",
                $expression,
                1 == $count ? 'once' : $count.' times',
                1 == $nodeList->length ? 'once' : $nodeList->length.' times',
                // strip away <root> and </root>
                substr($dom->saveHTML(), 6, -8)
            ));
        } else {
            $this->addToAssertionCount(1);
        }
    }

    protected function assertWidgetMatchesXpath(FormView $view, array $vars, string $xpath): void
    {
        $this->assertMatchesXpath($this->renderWidget($view, array_merge([], $vars)), $xpath);
    }
}
