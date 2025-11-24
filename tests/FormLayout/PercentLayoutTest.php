<?php

declare(strict_types=1);

namespace TalesFromADev\FlowbiteBundle\Tests\FormLayout;

use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\FormError;
use TalesFromADev\FlowbiteBundle\Tests\AbstractFlowbiteLayoutTestCase;

final class PercentLayoutTest extends AbstractFlowbiteLayoutTestCase
{
    public function testPercent(): void
    {
        $form = $this->factory->createNamed('name', PercentType::class, 0.5, [
            'rounding_mode' => \NumberFormatter::ROUND_CEILING,
        ]);

        $this->assertWidgetMatchesXpath($form->createView(), [],
            '/div
                [@class="flex"]
                [
                    ./input
                        [@type="text"]
                        [@name="name"]
                        [@id="name"]
                        [@class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base block w-full px-3 py-2.5 shadow-xs focus:ring-brand focus:border-brand placeholder:text-body rounded-e-none"]
                        [@value="50"]
                    /following-sibling::span
                        [@class="inline-flex items-center px-3 shadow-xs text-sm text-body bg-neutral-tertiary border-y border-default-medium rounded-e-base border-e"]
                        [.="%"]
                ]
            '
        );
    }

    public function testPercentWithoutSymbol(): void
    {
        $form = $this->factory->createNamed('name', PercentType::class, 0.5, [
            'symbol' => false,
            'rounding_mode' => \NumberFormatter::ROUND_CEILING,
        ]);

        $this->assertWidgetMatchesXpath($form->createView(), [],
            '/input
                [@type="text"]
                [@name="name"]
                [@id="name"]
                [@class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base block w-full px-3 py-2.5 shadow-xs focus:ring-brand focus:border-brand placeholder:text-body"]
                [@value="50"]
            '
        );
    }

    public function testPercentError(): void
    {
        $form = $this->factory->createNamed('name', PercentType::class, 0.5, [
            'rounding_mode' => \NumberFormatter::ROUND_CEILING,
        ]);
        $form->addError(new FormError('[trans]Error message[/trans]'));
        $form->submit([]);

        $this->assertWidgetMatchesXpath($form->createView(), [],
            '/div
                [@class="flex"]
                [
                    ./input
                        [@type="text"]
                        [@name="name"]
                        [@id="name"]
                        [@class="border text-sm rounded-base block w-full px-3 py-2.5 shadow-xs rounded-e-none bg-danger-soft border-danger-subtle text-fg-danger-strong focus:ring-danger focus:border-danger placeholder:text-fg-danger-strong"]
                    /following-sibling::span
                        [@class="inline-flex items-center px-3 shadow-xs text-sm text-body bg-neutral-tertiary border-y border-default-medium rounded-e-base border-e"]
                        [.="%"]
                ]
            '
        );
    }
}
