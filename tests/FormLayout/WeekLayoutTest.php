<?php

declare(strict_types=1);

namespace TalesFromADev\FlowbiteBundle\Tests\FormLayout;

use Symfony\Component\Form\Extension\Core\Type\WeekType;
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
                [@class="text-gray-900 bg-gray-50 rounded-lg text-sm block w-full p-2.5 border border-gray-300 focus:z-10 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"]
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
                        [@class="text-gray-900 bg-gray-50 rounded-lg text-sm block w-full p-2.5 border border-gray-300 focus:z-10 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"]
                        [
                            ./option
                                [@value="'.$data['year'].'"]
                                [@selected="selected"]
                        ]
                    /following-sibling::select
                        [@id="name_week"]
                        [@name="name[week]"]
                        [@class="text-gray-900 bg-gray-50 rounded-lg text-sm block w-full p-2.5 border border-gray-300 focus:z-10 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"]
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
                        [@class="text-gray-900 bg-gray-50 rounded-lg text-sm block w-full p-2.5 border border-gray-300 focus:z-10 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"]
                        [@value="2000"]
                    /following-sibling::input
                        [@type="number"]
                        [@id="name_week"]
                        [@name="name[week]"]
                        [@class="text-gray-900 bg-gray-50 rounded-lg text-sm block w-full p-2.5 border border-gray-300 focus:z-10 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"]
                        [@value="1"]
                ]
                [count(./input)=2]
            '
        );
    }
}
