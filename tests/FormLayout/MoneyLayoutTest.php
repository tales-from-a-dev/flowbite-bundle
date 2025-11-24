<?php

declare(strict_types=1);

namespace TalesFromADev\FlowbiteBundle\Tests\FormLayout;

use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormError;
use TalesFromADev\FlowbiteBundle\Tests\AbstractFlowbiteLayoutTestCase;

final class MoneyLayoutTest extends AbstractFlowbiteLayoutTestCase
{
    public function testMoney(): void
    {
        $form = $this->factory->createNamed('name', MoneyType::class, 1234.56, [
            'currency' => 'EUR',
        ]);

        $this->assertWidgetMatchesXpath($form->createView(), [],
            '/div
                [@class="flex"]
                [
                    ./span
                        [@class="inline-flex items-center px-3 shadow-xs text-sm text-body bg-neutral-tertiary border-y border-default-medium rounded-s-base border-s"]
                    /following-sibling::input
                        [@type="text"]
                        [@name="name"]
                        [@id="name"]
                        [@class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base block w-full px-3 py-2.5 shadow-xs focus:ring-brand focus:border-brand placeholder:text-body rounded-s-none"]
                        [@value="1234.56"]
                ]
            '
        );
    }

    public function testMoneyError(): void
    {
        $form = $this->factory->createNamed('name', MoneyType::class, 1234.56, [
            'currency' => 'EUR',
        ]);
        $form->addError(new FormError('[trans]Error message[/trans]'));
        $form->submit([]);

        $this->assertWidgetMatchesXpath($form->createView(), [],
            '/div
                [@class="flex"]
                [
                    ./span
                        [@class="inline-flex items-center px-3 shadow-xs text-sm text-body bg-neutral-tertiary border-y border-default-medium rounded-s-base border-s"]
                    /following-sibling::input
                        [@type="text"]
                        [@name="name"]
                        [@id="name"]
                        [@class="border text-sm rounded-base block w-full px-3 py-2.5 shadow-xs rounded-s-none bg-danger-soft border-danger-subtle text-fg-danger-strong focus:ring-danger focus:border-danger placeholder:text-fg-danger-strong"]
                ]
            '
        );
    }
}
