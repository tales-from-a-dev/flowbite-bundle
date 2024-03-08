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
                        [@class="text-gray-900 bg-gray-50 text-sm block w-full p-2.5 border border-gray-300 focus:z-10 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500 rounded-none rounded-l-lg"]
                        [
                            ./option
                                [@value="2"]
                                [@selected="selected"]
                        ]
                    /following-sibling::select
                        [@name="date[day]"]
                        [@id="date_day"]
                        [@class="text-gray-900 bg-gray-50 text-sm block w-full p-2.5 border border-gray-300 focus:z-10 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500 rounded-none"]
                        [
                            ./option
                                [@value="3"]
                                [@selected="selected"]
                        ]
                    /following-sibling::select
                        [@name="date[year]"]
                        [@id="date_year"]
                        [@class="text-gray-900 bg-gray-50 text-sm block w-full p-2.5 border border-gray-300 focus:z-10 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500 rounded-none rounded-r-lg"]
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
                [@class="text-gray-900 bg-gray-50 rounded-lg text-sm block w-full p-2.5 border border-gray-300 focus:z-10 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"]
                [@value="'.date('Y').'-02-03"]
                [@required="required"]
            '
        );
    }
}
