<?php

declare(strict_types=1);

namespace TalesFromADev\FlowbiteBundle\Tests\FormLayout;

use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use TalesFromADev\FlowbiteBundle\Tests\FormLayoutTestCase;

final class BirthdayLayoutTest extends FormLayoutTestCase
{
    public function testBirthDay(): void
    {
        $form = $this->factory->createNamed('birthday', BirthdayType::class, '2000-02-03', [
            'input' => 'string',
        ]);

        $this->assertWidgetMatchesXpath($form->createView(), [],
            '/div
                [@id="birthday"]
                [@class="flex"]
                [
                    ./select
                        [@name="birthday[month]"]
                        [@id="birthday_month"]
                        [@class="text-gray-900 bg-gray-50 rounded-lg text-sm block w-full p-2.5 border border-gray-300 focus:z-10 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500 rounded-none rounded-l-lg"]
                        [
                            ./option
                                [@value="2"]
                                [@selected="selected"]
                        ]
                    /following-sibling::select
                        [@name="birthday[day]"]
                        [@id="birthday_day"]
                        [@class="text-gray-900 bg-gray-50 rounded-lg text-sm block w-full p-2.5 border border-gray-300 focus:z-10 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500 rounded-none"]
                        [
                            ./option
                                [@value="3"]
                                [@selected="selected"]
                        ]
                    /following-sibling::select
                        [@name="birthday[year]"]
                        [@id="birthday_year"]
                        [@class="text-gray-900 bg-gray-50 rounded-lg text-sm block w-full p-2.5 border border-gray-300 focus:z-10 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500 rounded-none rounded-r-lg"]
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

    public function testBirthDaySingleText(): void
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
                [@class="text-gray-900 bg-gray-50 rounded-lg text-sm block w-full p-2.5 border border-gray-300 focus:z-10 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"]
                [@value="2000-02-03"]
                [@required="required"]
            '
        );
    }
}
