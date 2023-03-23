<?php

declare(strict_types=1);

namespace TalesFromADev\FlowbiteBundle\Tests\FormLayout;

use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use TalesFromADev\FlowbiteBundle\Tests\FormLayoutTestCase;

final class MoneyLayoutTest extends FormLayoutTestCase
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
                        [@class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-gray-300 dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600 border-r-0 rounded-l-md"]
                    /following-sibling::input
                        [@type="text"]
                        [@name="name"]
                        [@id="name"]
                        [@class="rounded-none rounded-r-lg text-gray-900 bg-gray-50 rounded-lg text-sm block w-full p-2.5 border border-gray-300 focus:z-10 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"]
                        [@value="1234.56"]
                ]
            '
        );
    }
}
