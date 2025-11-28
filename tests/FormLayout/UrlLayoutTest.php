<?php

declare(strict_types=1);

namespace FormLayout;

use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormError;
use TalesFromADev\FlowbiteBundle\Tests\AbstractFlowbiteLayoutTestCase;

final class UrlLayoutTest extends AbstractFlowbiteLayoutTestCase
{
    public function testInputWithDefaultProtocol()
    {
        $url = 'http://www.example.com?foo1=bar1&foo2=bar2';

        $form = $this->factory->createNamed('name', UrlType::class, $url, ['default_protocol' => 'http']);

        $this->assertWidgetMatchesXpath($form->createView(), [],
            '/input
                [@type="text"]
                [@name="name"]
                [@id="name"]
                [@class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base block w-full px-3 py-2.5 shadow-xs focus:ring-brand focus:border-brand placeholder:text-body"]
                [@value="http://www.example.com?foo1=bar1&foo2=bar2"]
                [@inputmode="url"]
            '
        );
    }

    public function testInputWithoutDefaultProtocol()
    {
        $url = 'http://www.example.com?foo1=bar1&foo2=bar2';

        $form = $this->factory->createNamed('name', UrlType::class, $url, ['default_protocol' => null]);

        $this->assertWidgetMatchesXpath($form->createView(), [],
            '/input
                [@type="url"]
                [@name="name"]
                [@id="name"]
                [@class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base block w-full px-3 py-2.5 shadow-xs focus:ring-brand focus:border-brand placeholder:text-body"]
                [@value="http://www.example.com?foo1=bar1&foo2=bar2"]
            '
        );
    }

    public function testInputError(): void
    {
        $url = 'http://www.example.com?foo1=bar1&foo2=bar2';

        $form = $this->factory->createNamed('name', UrlType::class, $url, ['default_protocol' => null]);
        $form->addError(new FormError('[trans]Error message[/trans]'));
        $form->submit([]);

        $this->assertWidgetMatchesXpath($form->createView(), [],
            '/input
                [@type="url"]
                [@name="name"]
                [@id="name"]
                [@class="border text-sm rounded-base block w-full px-3 py-2.5 shadow-xs bg-danger-soft border-danger-subtle text-fg-danger-strong focus:ring-danger focus:border-danger placeholder:text-fg-danger-strong"]
            '
        );
    }

    public function testInputDisabled(): void
    {
        $url = 'http://www.example.com?foo1=bar1&foo2=bar2';

        $form = $this->factory->createNamed('name', UrlType::class, $url, ['default_protocol' => null, 'disabled' => true]);
        $form->submit([]);

        $this->assertWidgetMatchesXpath($form->createView(), [],
            '/input
                [@type="url"]
                [@name="name"]
                [@id="name"]
                [@disabled="disabled"]
                [@class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base block w-full px-3 py-2.5 shadow-xs focus:ring-brand focus:border-brand placeholder:text-body disabled:text-fg-disabled disabled:cursor-not-allowed"]
                [@value="http://www.example.com?foo1=bar1&foo2=bar2"]
            '
        );
    }
}
