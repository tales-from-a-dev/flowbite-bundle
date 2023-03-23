<?php

declare(strict_types=1);

namespace TalesFromADev\FlowbiteBundle\Tests\FormLayout;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use TalesFromADev\FlowbiteBundle\Tests\FormLayoutTestCase;

final class TextareaLayoutTest extends FormLayoutTestCase
{
    public function testTextarea(): void
    {
        $form = $this->factory->createNamed('name', TextareaType::class, 'foo');

        $this->assertWidgetMatchesXpath($form->createView(), [],
            '/textarea
                [@name="name"]
                [@id="name"]
                [@class="text-gray-900 bg-gray-50 rounded-lg text-sm block w-full p-2.5 border border-gray-300 focus:z-10 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"]
                [.="foo"]
            '
        );
    }
}
