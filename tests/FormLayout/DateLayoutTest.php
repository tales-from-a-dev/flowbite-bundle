<?php

declare(strict_types=1);

namespace TalesFromADev\FlowbiteBundle\Tests\FormLayout;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use TalesFromADev\FlowbiteBundle\Tests\AbstractFlowbiteLayoutTestCase;

final class DateLayoutTest extends AbstractFlowbiteLayoutTestCase
{
    public function testDate(): void
    {
        $form = $this->factory->createNamed('date', DateType::class, date('Y').'-02-03', [
            'input' => 'string',
            'widget' => 'choice',
        ]);

        $this->assertWidgetMatchesXpath($form->createView(), [],
            '/div
                [@id="date"]
                [@class="flex"]
                [
                    ./select
                        [@name="date[month]"]
                        [@id="date_month"]
                        [@class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base block w-full px-3 py-2.5 shadow-xs focus:ring-brand focus:border-brand placeholder:text-body rounded-none first-of-type:rounded-s-base first-of-type:border-e-0 last-of-type:rounded-e-base last-of-type:border-s-0"]
                        [
                            ./option
                                [@value="2"]
                                [@selected="selected"]
                        ]
                    /following-sibling::select
                        [@name="date[day]"]
                        [@id="date_day"]
                        [@class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base block w-full px-3 py-2.5 shadow-xs focus:ring-brand focus:border-brand placeholder:text-body rounded-none first-of-type:rounded-s-base first-of-type:border-e-0 last-of-type:rounded-e-base last-of-type:border-s-0"]
                        [
                            ./option
                                [@value="3"]
                                [@selected="selected"]
                        ]
                    /following-sibling::select
                        [@name="date[year]"]
                        [@id="date_year"]
                        [@class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base block w-full px-3 py-2.5 shadow-xs focus:ring-brand focus:border-brand placeholder:text-body rounded-none first-of-type:rounded-s-base first-of-type:border-e-0 last-of-type:rounded-e-base last-of-type:border-s-0"]
                        [
                            ./option
                                [@value="'.date('Y').'"]
                                [@selected="selected"]
                        ]
                ]
                [count(./select)=3]
            '
        );
    }

    public function testDateSingleText(): void
    {
        $form = $this->factory->createNamed('date', DateType::class, date('Y').'-02-03', [
            'input' => 'string',
            'widget' => 'single_text',
        ]);

        $this->assertWidgetMatchesXpath($form->createView(), [],
            '/input
                [@type="date"]
                [@name="date"]
                [@id="date"]
                [@class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base block w-full px-3 py-2.5 shadow-xs focus:ring-brand focus:border-brand placeholder:text-body"]
                [@value="'.date('Y').'-02-03"]
                [@required="required"]
            '
        );
    }
}
