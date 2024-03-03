<?php

declare(strict_types=1);

namespace TalesFromADev\FlowbiteBundle\Tests\FormLayout;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormError;
use TalesFromADev\FlowbiteBundle\Tests\AbstractFlowbiteLayoutTestCase;

final class TextareaLayoutTest extends AbstractFlowbiteLayoutTestCase
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

    public function testTextareaError(): void
    {
        $form = $this->factory->createNamed('name', TextareaType::class, 'foo');
        $form->addError(new FormError('[trans]Error message[/trans]'));
        $form->submit([]);

        $this->assertWidgetMatchesXpath($form->createView(), [],
            '/textarea
                [@name="name"]
                [@id="name"]
                [@class="rounded-lg text-sm block w-full p-2.5 border bg-red-50 border-red-500 text-red-900 placeholder-red-700 dark:bg-red-100 dark:border-red-500 dark:text-red-500 dark:placeholder-red-500 focus:z-10 focus:ring-red-500 focus:border-red-500 dark:focus:ring-red-500 dark:focus:border-red-500"]
            '
        );
    }
}
