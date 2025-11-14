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
                [@class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base block w-full px-3 py-2.5 shadow-xs focus:ring-brand focus:border-brand placeholder:text-body"]
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
                [@class="border text-sm rounded-base block w-full px-3 py-2.5 shadow-xs bg-danger-soft border-danger-subtle text-fg-danger-strong focus:ring-danger focus:border-danger placeholder:text-fg-danger-strong"]
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
                [@class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base block w-full px-3 py-2.5 shadow-xs focus:ring-brand focus:border-brand placeholder:text-body disabled:text-fg-disabled disabled:cursor-not-allowed"]
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
                    [@class="flex items-center"]
                    [
                        ./input
                            [@type="checkbox"]
                            [@name="name[]"]
                            [@id="name_0"]
                            [@class="size-4 border border-default-medium rounded-xs bg-neutral-secondary-medium focus:ring-2 focus:ring-brand-soft"]
                            [@value="foo"]
                        /following-sibling::label
                            [@class="select-none ms-2 text-sm font-medium text-heading"]
                            [.="[trans]Foo[/trans]"]
                    ]
                    /following-sibling::div
                    [@class="flex items-center"]
                    [
                        ./input
                            [@type="checkbox"]
                            [@name="name[]"]
                            [@id="name_1"]
                            [@class="size-4 border border-default-medium rounded-xs bg-neutral-secondary-medium focus:ring-2 focus:ring-brand-soft"]
                            [@value="bar"]
                        /following-sibling::label
                            [@class="select-none ms-2 text-sm font-medium text-heading"]
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
                    [@class="flex items-center"]
                    [
                        ./input
                            [@type="checkbox"]
                            [@name="name[]"]
                            [@id="name_0"]
                            [@class="size-4 border border-default-medium rounded-xs bg-neutral-secondary-medium focus:ring-2 focus:ring-brand-soft"]
                            [@value="foo"]
                        /following-sibling::label
                            [@class="select-none ms-2 text-sm font-medium text-heading"]
                            [.="[trans]Foo[/trans]"]
                    ]
                    /following-sibling::div
                    [@class="flex items-center"]
                    [
                        ./input
                            [@type="checkbox"]
                            [@name="name[]"]
                            [@id="name_1"]
                            [@class="size-4 border border-default-medium rounded-xs bg-neutral-secondary-medium focus:ring-2 focus:ring-brand-soft"]
                            [@value="bar"]
                        /following-sibling::label
                            [@class="select-none ms-2 text-sm font-medium text-heading"]
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
                    [@class="flex items-center"]
                    [
                        ./input
                            [@type="radio"]
                            [@name="name"]
                            [@id="name_0"]
                            [@class="size-4 text-neutral-primary bg-neutral-secondary-medium rounded-full border border-default appearance-none checked:border-brand focus:ring-2 focus:outline-none focus:ring-brand-subtle"]
                            [@value="foo"]
                        /following-sibling::label
                            [@class="select-none ms-2 text-sm font-medium text-heading"]
                            [.="[trans]Foo[/trans]"]
                    ]
                    /following-sibling::div
                    [@class="flex items-center"]
                    [
                        ./input
                            [@type="radio"]
                            [@name="name"]
                            [@id="name_1"]
                            [@class="size-4 text-neutral-primary bg-neutral-secondary-medium rounded-full border border-default appearance-none checked:border-brand focus:ring-2 focus:outline-none focus:ring-brand-subtle"]
                            [@value="bar"]
                        /following-sibling::label
                            [@class="select-none ms-2 text-sm font-medium text-heading"]
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
                    [@class="flex items-center"]
                    [
                        ./input
                            [@type="radio"]
                            [@name="name"]
                            [@id="name_0"]
                            [@class="size-4 text-neutral-primary bg-neutral-secondary-medium rounded-full border border-default appearance-none checked:border-brand focus:ring-2 focus:outline-none focus:ring-brand-subtle"]
                            [@value="foo"]
                        /following-sibling::label
                            [@class="select-none ms-2 text-sm font-medium text-heading"]
                            [.="[trans]Foo[/trans]"]
                    ]
                    /following-sibling::div
                    [@class="flex items-center"]
                    [
                        ./input
                            [@type="radio"]
                            [@name="name"]
                            [@id="name_1"]
                            [@class="size-4 text-neutral-primary bg-neutral-secondary-medium rounded-full border border-default appearance-none checked:border-brand focus:ring-2 focus:outline-none focus:ring-brand-subtle"]
                            [@value="bar"]
                        /following-sibling::label
                            [@class="select-none ms-2 text-sm font-medium text-heading"]
                            [.="[trans]Bar[/trans]"]
                    ]
                ]
            '
        );
    }
}
