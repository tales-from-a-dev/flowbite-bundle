<?php

declare(strict_types=1);

namespace TalesFromADev\FlowbiteBundle\Tests\FormLayout;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormError;
use TalesFromADev\FlowbiteBundle\Tests\AbstractFlowbiteLayoutTestCase;

final class ChoiceLayoutTest extends AbstractFlowbiteLayoutTestCase
{
    public function testChoice(): void
    {
        $form = $this->factory->createNamed('name', ChoiceType::class, 'foo', [
            'choices' => ['Foo' => 'foo', 'Bar' => 'bar'],
            'multiple' => false,
            'expanded' => false,
        ]);

        $this->assertWidgetMatchesXpath($form->createView(), [],
            '/select
                [@name="name"]
                [@id="name"]
                [@class="text-gray-900 bg-gray-50 rounded-lg text-sm block w-full p-2.5 border border-gray-300 focus:z-10 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"]
                [count(./option)=2]
            '
        );
    }

    public function testChoiceError(): void
    {
        $form = $this->factory->createNamed('name', ChoiceType::class, 'foo', [
            'choices' => ['Foo' => 'foo', 'Bar' => 'bar'],
            'multiple' => false,
            'expanded' => false,
        ]);
        $form->addError(new FormError('[trans]Error message[/trans]'));
        $form->submit([]);

        $this->assertWidgetMatchesXpath($form->createView(), [],
            '/select
                [@name="name"]
                [@id="name"]
                [@class="rounded-lg text-sm block w-full p-2.5 border bg-red-50 border-red-500 text-red-900 placeholder-red-700 dark:bg-red-100 dark:border-red-500 dark:text-red-500 dark:placeholder-red-500 focus:z-10 focus:ring-red-500 focus:border-red-500 dark:focus:ring-red-500 dark:focus:border-red-500"]
                [count(./option)=2]
            '
        );
    }

    public function testChoiceDisabled(): void
    {
        $form = $this->factory->createNamed('name', ChoiceType::class, 'foo', [
            'choices' => ['Foo' => 'foo', 'Bar' => 'bar'],
            'multiple' => false,
            'expanded' => false,
            'disabled' => true,
        ]);

        $this->assertWidgetMatchesXpath($form->createView(), [],
            '/select
                [@name="name"]
                [@id="name"]
                [@disabled="disabled"]
                [@class="text-gray-900 bg-gray-50 rounded-lg text-sm block w-full p-2.5 border border-gray-300 focus:z-10 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500 disabled:bg-gray-100 disabled:border-gray-300 disabled:cursor-not-allowed dark:disabled:text-gray-400"]
                [count(./option)=2]
            '
        );
    }

    public function testChoiceCheckbox(): void
    {
        $form = $this->factory->createNamed('name', ChoiceType::class, ['foo'], [
            'choices' => ['Foo' => 'foo', 'Bar' => 'bar'],
            'multiple' => true,
            'expanded' => true,
        ]);

        $this->assertWidgetMatchesXpath($form->createView(), [],
            '/div
                [@id="name"]
                [
                    ./div
                    [@class="flex items-center mr-4"]
                    [
                        ./input
                            [@type="checkbox"]
                            [@name="name[]"]
                            [@id="name_0"]
                            [@class="rounded w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"]
                            [@value="foo"]
                        /following-sibling::label
                            [@class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300"]
                            [.="[trans]Foo[/trans]"]
                    ]
                    /following-sibling::div
                    [@class="flex items-center mr-4"]
                    [
                        ./input
                            [@type="checkbox"]
                            [@name="name[]"]
                            [@id="name_1"]
                            [@class="rounded w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"]
                            [@value="bar"]
                        /following-sibling::label
                            [@class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300"]
                            [.="[trans]Bar[/trans]"]
                    ]
                ]
            '
        );
    }

    public function testChoiceCheckboxInline(): void
    {
        $form = $this->factory->createNamed('name', ChoiceType::class, ['foo'], [
            'choices' => ['Foo' => 'foo', 'Bar' => 'bar'],
            'multiple' => true,
            'expanded' => true,
            'attr' => [
                'class' => 'flex',
            ],
        ]);

        $this->assertWidgetMatchesXpath($form->createView(), [],
            '/div
                [@id="name"]
                [@class="flex"]
                [
                    ./div
                    [@class="flex items-center mr-4"]
                    [
                        ./input
                            [@type="checkbox"]
                            [@name="name[]"]
                            [@id="name_0"]
                            [@class="rounded w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"]
                            [@value="foo"]
                        /following-sibling::label
                            [@class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300"]
                            [.="[trans]Foo[/trans]"]
                    ]
                    /following-sibling::div
                    [@class="flex items-center mr-4"]
                    [
                        ./input
                            [@type="checkbox"]
                            [@name="name[]"]
                            [@id="name_1"]
                            [@class="rounded w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"]
                            [@value="bar"]
                        /following-sibling::label
                            [@class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300"]
                            [.="[trans]Bar[/trans]"]
                    ]
                ]
            '
        );
    }

    public function testChoiceRadio(): void
    {
        $form = $this->factory->createNamed('name', ChoiceType::class, null, [
            'choices' => ['Foo' => 'foo', 'Bar' => 'bar'],
            'multiple' => false,
            'expanded' => true,
        ]);

        $this->assertWidgetMatchesXpath($form->createView(), [],
            '/div
                [@id="name"]
                [
                    ./div
                    [@class="flex items-center mr-4"]
                    [
                        ./input
                            [@type="radio"]
                            [@name="name"]
                            [@id="name_0"]
                            [@class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"]
                            [@value="foo"]
                        /following-sibling::label
                            [@class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300"]
                            [.="[trans]Foo[/trans]"]
                    ]
                    /following-sibling::div
                    [@class="flex items-center mr-4"]
                    [
                        ./input
                            [@type="radio"]
                            [@name="name"]
                            [@id="name_1"]
                            [@class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"]
                            [@value="bar"]
                        /following-sibling::label
                            [@class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300"]
                            [.="[trans]Bar[/trans]"]
                    ]
                ]
            '
        );
    }

    public function testChoiceRadioInline(): void
    {
        $form = $this->factory->createNamed('name', ChoiceType::class, null, [
            'choices' => ['Foo' => 'foo', 'Bar' => 'bar'],
            'multiple' => false,
            'expanded' => true,
            'attr' => [
                'class' => 'flex',
            ],
        ]);

        $this->assertWidgetMatchesXpath($form->createView(), [],
            '/div
                [@id="name"]
                [@class="flex"]
                [
                    ./div
                    [@class="flex items-center mr-4"]
                    [
                        ./input
                            [@type="radio"]
                            [@name="name"]
                            [@id="name_0"]
                            [@class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"]
                            [@value="foo"]
                        /following-sibling::label
                            [@class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300"]
                            [.="[trans]Foo[/trans]"]
                    ]
                    /following-sibling::div
                    [@class="flex items-center mr-4"]
                    [
                        ./input
                            [@type="radio"]
                            [@name="name"]
                            [@id="name_1"]
                            [@class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"]
                            [@value="bar"]
                        /following-sibling::label
                            [@class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300"]
                            [.="[trans]Bar[/trans]"]
                    ]
                ]
            '
        );
    }
}
