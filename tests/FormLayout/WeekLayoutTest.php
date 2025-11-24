<?php

declare(strict_types=1);

namespace TalesFromADev\FlowbiteBundle\Tests\FormLayout;

use Symfony\Component\Form\Extension\Core\Type\WeekType;
use Symfony\Component\Form\FormError;
use TalesFromADev\FlowbiteBundle\Tests\AbstractFlowbiteLayoutTestCase;

final class WeekLayoutTest extends AbstractFlowbiteLayoutTestCase
{
    public function testWeek(): void
    {
        $form = $this->factory->createNamed('name', WeekType::class, '1970-W01', [
            'input' => 'string',
            'widget' => 'single_text',
        ]);

        $this->assertWidgetMatchesXpath($form->createView(), [],
            '/input
                [@type="week"]
                [@name="name"]
                [@id="name"]
                [@class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base block w-full px-3 py-2.5 shadow-xs focus:ring-brand focus:border-brand placeholder:text-body"]
                [@value="1970-W01"]
                [@required="required"]
            '
        );
    }

    public function testWeekChoices(): void
    {
        $data = ['year' => (int) date('Y'), 'week' => 1];

        $form = $this->factory->createNamed('name', WeekType::class, $data, [
            'input' => 'array',
            'widget' => 'choice',
        ]);

        $this->assertWidgetMatchesXpath($form->createView(), [],
            '/div
                [@id="name"]
                [
                    ./select
                        [@id="name_year"]
                        [@name="name[year]"]
                        [@class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base block w-full px-3 py-2.5 shadow-xs focus:ring-brand focus:border-brand placeholder:text-body"]
                        [
                            ./option
                                [@value="'.$data['year'].'"]
                                [@selected="selected"]
                        ]
                    /following-sibling::select
                        [@id="name_week"]
                        [@name="name[week]"]
                        [@class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base block w-full px-3 py-2.5 shadow-xs focus:ring-brand focus:border-brand placeholder:text-body"]
                        [
                            ./option
                                [@value="'.$data['week'].'"]
                                [@selected="selected"]
                        ]
                ]
                [count(.//select)=2]
            '
        );
    }

    public function testWeekText(): void
    {
        $form = $this->factory->createNamed('name', WeekType::class, '2000-W01', [
            'input' => 'string',
            'widget' => 'text',
        ]);

        $this->assertWidgetMatchesXpath($form->createView(), [],
            '/div
                [@id="name"]
                [
                    ./input
                        [@type="number"]
                        [@id="name_year"]
                        [@name="name[year]"]
                        [@class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base block w-full px-3 py-2.5 shadow-xs focus:ring-brand focus:border-brand placeholder:text-body"]
                        [@value="2000"]
                    /following-sibling::input
                        [@type="number"]
                        [@id="name_week"]
                        [@name="name[week]"]
                        [@class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base block w-full px-3 py-2.5 shadow-xs focus:ring-brand focus:border-brand placeholder:text-body"]
                        [@value="1"]
                ]
                [count(./input)=2]
            '
        );
    }

    public function testWeekError(): void
    {
        $form = $this->factory->createNamed('name', WeekType::class, '1970-W01', [
            'input' => 'string',
            'widget' => 'single_text',
        ]);
        $form->addError(new FormError('[trans]Error message[/trans]'));
        $form->submit([]);

        $this->assertWidgetMatchesXpath($form->createView(), [],
            '/input
                [@type="week"]
                [@name="name"]
                [@id="name"]
                [@class="border text-sm rounded-base block w-full px-3 py-2.5 shadow-xs bg-danger-soft border-danger-subtle text-fg-danger-strong focus:ring-danger focus:border-danger placeholder:text-fg-danger-strong"]
            '
        );
    }
}
