<?php

declare(strict_types=1);

namespace TalesFromADev\FlowbiteBundle\Tests\FormLayout;

use Symfony\Component\Form\Extension\Core\Type\PercentType;
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
                        [@class="rounded-none rounded-l-lg text-gray-900 bg-gray-50 rounded-lg text-sm block w-full p-2.5 border border-gray-300 focus:z-10 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"]
                        [@value="50"]
                    /following-sibling::span
                        [@class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-gray-300 dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600 border-l-0 rounded-r-md"]
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
                [@class="text-gray-900 bg-gray-50 rounded-lg text-sm block w-full p-2.5 border border-gray-300 focus:z-10 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"]
                [@value="50"]
            '
        );
    }
}
