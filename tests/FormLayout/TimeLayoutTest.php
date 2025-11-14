<?php

declare(strict_types=1);

namespace TalesFromADev\FlowbiteBundle\Tests\FormLayout;

use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormError;
use TalesFromADev\FlowbiteBundle\Tests\AbstractFlowbiteLayoutTestCase;

final class TimeLayoutTest extends AbstractFlowbiteLayoutTestCase
{
    public function testTime(): void
    {
        $form = $this->factory->createNamed('name', TimeType::class, '04:05:06', [
            'input' => 'string',
            'with_seconds' => false,
            'widget' => 'choice',
        ]);

        $this->assertWidgetMatchesXpath($form->createView(), [],
            '/div
            [@id="name"]
            [@class="flex"]
            [
                ./select
                    [@name="name[hour]"]
                    [@id="name_hour"]
                    [@class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base block w-full px-3 py-2.5 shadow-xs focus:ring-brand focus:border-brand placeholder:text-body rounded-e-none"]
                    [not(@size)]
                    [
                        ./option
                        [@value="4"]
                        [@selected="selected"]
                    ]
                    [count(./option)>23]
                /following-sibling::span
                    [@class="inline-flex items-center px-3 shadow-xs text-sm text-body bg-neutral-tertiary border-y border-default-medium"]
                /following-sibling::select
                    [@name="name[minute]"]
                    [@id="name_minute"]
                    [@class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base block w-full px-3 py-2.5 shadow-xs focus:ring-brand focus:border-brand placeholder:text-body rounded-s-none"]
                    [not(@size)]
                    [
                        ./option
                        [@value="5"]
                        [@selected="selected"]
                    ]
                    [count(./option)>59]
            ]
            [count(./select)=2]'
        );
    }

    public function testTimeWithSeconds(): void
    {
        $form = $this->factory->createNamed('name', TimeType::class, '04:05:06', [
            'input' => 'string',
            'with_seconds' => true,
            'widget' => 'choice',
        ]);

        $this->assertWidgetMatchesXpath($form->createView(), [],
            '/div
            [@id="name"]
            [@class="flex"]
            [
                ./select
                    [@name="name[hour]"]
                    [@id="name_hour"]
                    [@class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base block w-full px-3 py-2.5 shadow-xs focus:ring-brand focus:border-brand placeholder:text-body rounded-e-none"]
                    [not(@size)]
                    [
                        ./option
                            [@value="4"]
                            [@selected="selected"]

                    ]
                    [count(./option)>23]
                /following-sibling::span
                    [@class="inline-flex items-center px-3 shadow-xs text-sm text-body bg-neutral-tertiary border-y border-default-medium"]
                /following-sibling::select
                    [@name="name[minute]"]
                    [@id="name_minute"]
                    [@class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base block w-full px-3 py-2.5 shadow-xs focus:ring-brand focus:border-brand placeholder:text-body rounded-none"]
                    [not(@size)]
                    [
                        ./option
                            [@value="5"]
                            [@selected="selected"]
                    ]
                    [count(./option)>59]
                /following-sibling::span
                    [@class="inline-flex items-center px-3 shadow-xs text-sm text-body bg-neutral-tertiary border-y border-default-medium"]
                /following-sibling::select
                    [@name="name[second]"]
                    [@id="name_second"]
                    [@class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base block w-full px-3 py-2.5 shadow-xs focus:ring-brand focus:border-brand placeholder:text-body rounded-s-none"]
                    [not(@size)]
                    [
                        ./option
                            [@value="6"]
                            [@selected="selected"]
                    ]
                    [count(./option)>59]
            ]
            [count(./select)=3]'
        );
    }

    public function testTimeText(): void
    {
        $form = $this->factory->createNamed('name', TimeType::class, '04:05:06', [
            'input' => 'string',
            'widget' => 'text',
        ]);

        $this->assertWidgetMatchesXpath($form->createView(), [],
            '/div
            [@id="name"]
            [@class="flex"]
            [
                ./input
                    [@name="name[hour]"]
                    [@id="name_hour"]
                    [@class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base block w-full px-3 py-2.5 shadow-xs focus:ring-brand focus:border-brand placeholder:text-body rounded-e-none"]
                    [@value="04"]
                    [@required="required"]
                /following-sibling::span
                    [@class="inline-flex items-center px-3 shadow-xs text-sm text-body bg-neutral-tertiary border-y border-default-medium"]
                /following-sibling::input
                    [@name="name[minute]"]
                    [@id="name_minute"]
                    [@class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base block w-full px-3 py-2.5 shadow-xs focus:ring-brand focus:border-brand placeholder:text-body rounded-s-none"]
                    [@value="05"]
                    [@required="required"]
            ]
            [count(./input)=2]'
        );
    }

    public function testTimeSingleText(): void
    {
        $form = $this->factory->createNamed('name', TimeType::class, '04:05:06', [
            'input' => 'string',
            'widget' => 'single_text',
        ]);

        $this->assertWidgetMatchesXpath($form->createView(), [],
            '/input
            [@type="time"]
            [@name="name"]
            [@id="name"]
            [@class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base block w-full px-3 py-2.5 shadow-xs focus:ring-brand focus:border-brand placeholder:text-body"]
            [@value="04:05"]
            [@required="required"]
            [not(@size)]'
        );
    }

    public function testTimeSingleTextError(): void
    {
        $form = $this->factory->createNamed('name', TimeType::class, '04:05:06', [
            'input' => 'string',
            'widget' => 'single_text',
        ]);
        $form->addError(new FormError('[trans]Error message[/trans]'));
        $form->submit([]);

        $this->assertWidgetMatchesXpath($form->createView(), [],
            '/input
            [@type="time"]
            [@id="name"]
            [@name="name"]
            [@class="border text-sm rounded-base block w-full px-3 py-2.5 shadow-xs bg-danger-soft border-danger-subtle text-fg-danger-strong focus:ring-danger focus:border-danger placeholder:text-fg-danger-strong"]'
        );
    }
}
