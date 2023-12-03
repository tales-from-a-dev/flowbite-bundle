<?php

declare(strict_types=1);

namespace TalesFromADev\FlowbiteBundle\Tests\FormLayout;

use Symfony\Component\Form\Extension\Core\Type\TimeType;
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
                    [@class="text-gray-900 bg-gray-50 rounded-lg text-sm block w-full p-2.5 border border-gray-300 focus:z-10 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500 rounded-none rounded-l-lg"]
                    [not(@size)]
                    [
                        ./option
                        [@value="4"]
                        [@selected="selected"]
                    ]
                    [count(./option)>23]
                /following-sibling::span
                    [@class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-x-0 border-gray-300 dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600"]
                /following-sibling::select
                    [@name="name[minute]"]
                    [@id="name_minute"]
                    [@class="text-gray-900 bg-gray-50 rounded-lg text-sm block w-full p-2.5 border border-gray-300 focus:z-10 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500 rounded-none rounded-r-lg"]
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
                    [@class="text-gray-900 bg-gray-50 rounded-lg text-sm block w-full p-2.5 border border-gray-300 focus:z-10 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500 rounded-none rounded-l-lg"]
                    [not(@size)]
                    [
                        ./option
                            [@value="4"]
                            [@selected="selected"]

                    ]
                    [count(./option)>23]
                /following-sibling::span
                    [@class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-x-0 border-gray-300 dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600"]
                /following-sibling::select
                    [@name="name[minute]"]
                    [@id="name_minute"]
                    [@class="text-gray-900 bg-gray-50 rounded-lg text-sm block w-full p-2.5 border border-gray-300 focus:z-10 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500 rounded-none"]
                    [not(@size)]
                    [
                        ./option
                            [@value="5"]
                            [@selected="selected"]
                    ]
                    [count(./option)>59]
                /following-sibling::span
                    [@class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-x-0 border-gray-300 dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600"]
                /following-sibling::select
                    [@name="name[second]"]
                    [@id="name_second"]
                    [@class="text-gray-900 bg-gray-50 rounded-lg text-sm block w-full p-2.5 border border-gray-300 focus:z-10 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500 rounded-none rounded-r-lg"]
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
                    [@class="text-gray-900 bg-gray-50 rounded-lg text-sm block w-full p-2.5 border border-gray-300 focus:z-10 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500 rounded-none rounded-l-lg"]
                    [@value="04"]
                    [@required="required"]
                /following-sibling::span
                    [@class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-x-0 border-gray-300 dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600"]
                /following-sibling::input
                    [@name="name[minute]"]
                    [@id="name_minute"]
                    [@class="text-gray-900 bg-gray-50 rounded-lg text-sm block w-full p-2.5 border border-gray-300 focus:z-10 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500 rounded-none rounded-r-lg"]
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
            [@class="text-gray-900 bg-gray-50 rounded-lg text-sm block w-full p-2.5 border border-gray-300 focus:z-10 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"]
            [@value="04:05"]
            [@required="required"]
            [not(@size)]'
        );
    }
}
