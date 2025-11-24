<?php

declare(strict_types=1);

namespace TalesFromADev\FlowbiteBundle\Tests\FormLayout;

use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use TalesFromADev\FlowbiteBundle\Tests\AbstractFlowbiteLayoutTestCase;

final class BirthdayLayoutTest extends AbstractFlowbiteLayoutTestCase
{
    public function testBirthday(): void
    {
        $form = $this->factory->createNamed('birthday', BirthdayType::class, '2000-02-03', [
            'input' => 'string',
            'widget' => 'choice',
        ]);

        $this->assertWidgetMatchesXpath($form->createView(), [],
            '/div
                [@id="birthday"]
                [@class="flex"]
                [
                    ./select
                        [@name="birthday[month]"]
                        [@id="birthday_month"]
                        [@class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base block w-full px-3 py-2.5 shadow-xs focus:ring-brand focus:border-brand placeholder:text-body rounded-none first-of-type:rounded-s-base first-of-type:border-e-0 last-of-type:rounded-e-base last-of-type:border-s-0"]
                        [
                            ./option
                                [@value="2"]
                                [@selected="selected"]
                        ]
                    /following-sibling::select
                        [@name="birthday[day]"]
                        [@id="birthday_day"]
                        [@class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base block w-full px-3 py-2.5 shadow-xs focus:ring-brand focus:border-brand placeholder:text-body rounded-none first-of-type:rounded-s-base first-of-type:border-e-0 last-of-type:rounded-e-base last-of-type:border-s-0"]
                        [
                            ./option
                                [@value="3"]
                                [@selected="selected"]
                        ]
                    /following-sibling::select
                        [@name="birthday[year]"]
                        [@id="birthday_year"]
                        [@class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base block w-full px-3 py-2.5 shadow-xs focus:ring-brand focus:border-brand placeholder:text-body rounded-none first-of-type:rounded-s-base first-of-type:border-e-0 last-of-type:rounded-e-base last-of-type:border-s-0"]
                        [
                            ./option
                                [@value="2000"]
                                [@selected="selected"]
                        ]
                ]
                [count(./select)=3]
            '
        );
    }

    public function testBirthdaySingleText(): void
    {
        $form = $this->factory->createNamed('birthday', BirthdayType::class, '2000-02-03', [
            'input' => 'string',
            'widget' => 'single_text',
        ]);

        $this->assertWidgetMatchesXpath($form->createView(), [],
            '/input
                [@type="date"]
                [@name="birthday"]
                [@id="birthday"]
                [@class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base block w-full px-3 py-2.5 shadow-xs focus:ring-brand focus:border-brand placeholder:text-body"]
                [@value="2000-02-03"]
                [@required="required"]
            '
        );
    }
}
