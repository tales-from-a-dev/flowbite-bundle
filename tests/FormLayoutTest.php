<?php

declare(strict_types=1);

namespace TalesFromADev\FlowbiteBundle\Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Bridge\Twig\Extension\TranslationExtension;
use Symfony\Bridge\Twig\Form\TwigRendererEngine;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\CurrencyType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\LanguageType;
use Symfony\Component\Form\Extension\Core\Type\LocaleType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\TimezoneType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\WeekType;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormRenderer;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\Test\FormIntegrationTestCase;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use TalesFromADev\FlowbiteBundle\Form\Type\SwitchType;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\RuntimeLoader\RuntimeLoaderInterface;

final class FormLayoutTest extends FormIntegrationTestCase
{
    private FormRenderer $renderer;

    protected function setUp(): void
    {
        parent::setUp();

        $loader = new FilesystemLoader([
            __DIR__.'/../vendor/symfony/twig-bridge/Resources/views/Form',
            __DIR__.'/../templates/form',
        ]);

        $environment = new Environment($loader, ['strict_variables' => true]);
        $environment->addExtension(new TranslationExtension(new StubTranslator()));
        $environment->addExtension(new FormExtension());

        $rendererEngine = new TwigRendererEngine([
            'default.html.twig',
        ], $environment);

        $this->renderer = new FormRenderer($rendererEngine, $this->getMockBuilder(CsrfTokenManagerInterface::class)->getMock());
        $this->registerTwigRuntimeLoader($environment, $this->renderer);
    }

    #[DataProvider('inputProvider')]
    public function testInput(string $classType, mixed $data, string $inputType): void
    {
        $form = $this->factory->createNamed('name', $classType, $data);

        $this->assertWidgetMatchesXpath($form->createView(), [], sprintf(
            '/input
                [@type="%s"]
                [@name="name"]
                [@id="name"]
                [@class="text-gray-900 bg-gray-50 rounded-lg text-sm block w-full p-2.5 border border-gray-300 focus:z-10 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"]
                %s
            ',
            $inputType,
            null !== $data ? '[@value="'.$data.'"]' : '',
        ));
    }

    public function testRange(): void
    {
        $form = $this->factory->createNamed('name', RangeType::class, 10);

        $this->assertWidgetMatchesXpath($form->createView(), [],
            '/input
                [@type="range"]
                [@name="name"]
                [@id="name"]
                [@class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700"]
                [@value="10"]
            '
        );
    }

    public function testFile(): void
    {
        $form = $this->factory->createNamed('name', FileType::class);

        $this->assertWidgetMatchesXpath($form->createView(), [],
            '/input
                [@type="file"]
                [@name="name"]
                [@id="name"]
                [@class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"]
            '
        );
    }

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

    public function testRadio(): void
    {
        $form = $this->factory->createNamed('name', RadioType::class, false);

        $this->assertWidgetMatchesXpath($form->createView(), [],
            '/div
                [@class="flex items-center mr-4"]
                [
                    ./input
                        [@type="radio"]
                        [@name="name"]
                        [@id="name"]
                        [@class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"]
                        [@value="1"]
                    /following-sibling::label
                        [@class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300"]
                        [.="[trans]Name[/trans]"]
                ]
            '
        );
    }

    public function testCheckbox(): void
    {
        $form = $this->factory->createNamed('name', CheckboxType::class, false);

        $this->assertWidgetMatchesXpath($form->createView(), [],
            '/div
                [@class="flex items-center mr-4"]
                [
                    ./input
                        [@type="checkbox"]
                        [@name="name"]
                        [@id="name"]
                        [@class="rounded w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"]
                        [@value="1"]
                    /following-sibling::label
                        [@class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300"]
                        [.="[trans]Name[/trans]"]
                ]
            '
        );
    }

    public function testSwitch(): void
    {
        $form = $this->factory->createNamed('name', SwitchType::class, false);

        $this->assertWidgetMatchesXpath($form->createView(), [],
            '/label
                [@class="relative inline-flex items-center cursor-pointer"]
                [@for="name"]
                [
                    ./input
                        [@type="checkbox"]
                        [@name="name"]
                        [@id="name"]
                        [@class="sr-only peer"]
                        [@value="1"]
                    /following-sibling::div
                        [@class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-2 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 dark:bg-gray-700 dark:border-gray-600 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[\'\'] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"]
                    /following-sibling::span
                        [@class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300"]
                        [.="[trans]Name[/trans]"]
                ]
            '
        );
    }

    #[DataProvider('selectProvider')]
    public function testSelect(string $classType): void
    {
        $form = $this->factory->createNamed('name', $classType, 'foo', [
            'multiple' => false,
            'expanded' => false,
        ]);

        $this->assertWidgetMatchesXpath($form->createView(), [],
            '/select
                [@name="name"]
                [@id="name"]
                [@class="text-gray-900 bg-gray-50 rounded-lg text-sm block w-full p-2.5 border border-gray-300 focus:z-10 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"]
            '
        );
    }

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

    public function testTime(): void
    {
        $form = $this->factory->createNamed('name', TimeType::class, '04:05:06', [
            'input' => 'string',
            'with_seconds' => false,
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

    public function testDate(): void
    {
        $form = $this->factory->createNamed('date', DateType::class, date('Y').'-02-03', [
            'input' => 'string',
        ]);

        $this->assertWidgetMatchesXpath($form->createView(), [],
            '/div
                [@id="date"]
                [@class="flex"]
                [
                    ./select
                        [@name="date[month]"]
                        [@id="date_month"]
                        [@class="text-gray-900 bg-gray-50 rounded-lg text-sm block w-full p-2.5 border border-gray-300 focus:z-10 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500 rounded-none rounded-l-lg"]
                        [
                            ./option
                                [@value="2"]
                                [@selected="selected"]
                        ]
                    /following-sibling::select
                        [@name="date[day]"]
                        [@id="date_day"]
                        [@class="text-gray-900 bg-gray-50 rounded-lg text-sm block w-full p-2.5 border border-gray-300 focus:z-10 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500 rounded-none"]
                        [
                            ./option
                                [@value="3"]
                                [@selected="selected"]
                        ]
                    /following-sibling::select
                        [@name="date[year]"]
                        [@id="date_year"]
                        [@class="text-gray-900 bg-gray-50 rounded-lg text-sm block w-full p-2.5 border border-gray-300 focus:z-10 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500 rounded-none rounded-r-lg"]
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

    public function testButton(): void
    {
        $form = $this->factory->createNamed('name', ButtonType::class);

        $this->assertWidgetMatchesXpath($form->createView(), [],
            '/button
            [@type="button"]
            [@name="name"]
            [@class="text-gray-900 bg-white font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 border border-gray-200 hover:text-blue-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:bg-gray-800 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-gray-700"]
            [
                .="[trans]Name[/trans]"
            ]'
        );
    }

    public function testSubmit(): void
    {
        $form = $this->factory->createNamed('name', SubmitType::class);

        $this->assertWidgetMatchesXpath($form->createView(), [],
            '/button
            [@type="submit"]
            [@name="name"]
            [@class="text-white bg-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"]
            [
                .="[trans]Name[/trans]"
            ]'
        );
    }

    public function testReset(): void
    {
        $form = $this->factory->createNamed('name', ResetType::class);

        $this->assertWidgetMatchesXpath($form->createView(), [],
            '/button
            [@type="reset"]
            [@name="name"]
            [@class="text-gray-900 bg-white font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 border border-gray-200 hover:text-blue-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:bg-gray-800 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-gray-700"]
            [
                .="[trans]Name[/trans]"
            ]'
        );
    }

    public function testLabel(): void
    {
        $form = $this->factory->createNamed('name', TextType::class);
        $html = $this->renderLabel($form->createView());

        $this->assertMatchesXpath($html,
            '/label
                [@for="name"]
                [@class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"]
                [.="[trans]Name[/trans]"]
            '
        );
    }

    public function testLabelWithAttrClass(): void
    {
        $form = $this->factory->createNamed('name', TextType::class, null, [
            'label_attr' => [
                'class' => 'my&class',
            ],
        ]);
        $html = $this->renderLabel($form->createView());

        $this->assertMatchesXpath($html,
            '/label
                [@for="name"]
                [@class="block mb-2 text-sm font-medium text-gray-900 dark:text-white my&class"]
                [.="[trans]Name[/trans]"]
            '
        );
    }

    public function testHelp(): void
    {
        $form = $this->factory->createNamed('name', TextType::class, null, [
            'help' => 'Help text test!',
        ]);
        $html = $this->renderHelp($form->createView());

        $this->assertMatchesXpath($html,
            '/p
                [@id="name_help"]
                [@class="mt-2 text-sm text-gray-500 dark:text-gray-400"]
                [.="[trans]Help text test![/trans]"]
            '
        );
    }

    public function testHelpWithAttrClass(): void
    {
        $form = $this->factory->createNamed('name', TextType::class, null, [
            'help' => 'Help text test!',
            'help_attr' => [
                'class' => 'my&class',
            ],
        ]);
        $html = $this->renderHelp($form->createView());

        $this->assertMatchesXpath($html,
            '/p
                [@id="name_help"]
                [@class="mt-2 text-sm text-gray-500 dark:text-gray-400 my&class"]
                [.="[trans]Help text test![/trans]"]
            '
        );
    }

    public function testErrorText(): void
    {
        $form = $this->factory->createNamed('name', TextType::class);
        $form->addError(new FormError('[trans]Error message[/trans]'));
        $html = $this->renderErrors($form->createView());

        $this->assertMatchesXpath($html,
            '/p
                [@class="mt-2 text-sm text-red-600 dark:text-red-500"]
                [.="[trans]Error message[/trans]"]
            '
        );
    }

    public function testErrorLabel(): void
    {
        $form = $this->factory->createNamed('name', TextType::class);
        $form->addError(new FormError('[trans]Error message[/trans]'));
        $form->submit([]);
        $html = $this->renderLabel($form->createView());

        $this->assertMatchesXpath($html,
            '/label
                [@for="name"]
                [@class="block mb-2 text-sm font-medium text-red-600 dark:text-red-500"]
                [.="[trans]Name[/trans]"]
            '
        );
    }

    public function testErrorCheckboxLabel(): void
    {
        $form = $this->factory->createNamed('name', CheckboxType::class);
        $form->addError(new FormError('[trans]Error message[/trans]'));
        $form->submit([]);

        $this->assertWidgetMatchesXpath($form->createView(), [],
            '/div
                [
                    ./label
                        [@for="name"]
                        [@class="ml-2 text-sm font-medium text-red-600 dark:text-red-500"]
                        [.="[trans]Name[/trans]"]
                ]
            '
        );
    }

    #[DataProvider('inputProvider')]
    public function testErrorInput(string $classType, mixed $data, string $inputType): void
    {
        $form = $this->factory->createNamed('name', $classType, $data);
        $form->addError(new FormError('[trans]Error message[/trans]'));
        $form->submit([]);

        $this->assertWidgetMatchesXpath($form->createView(), [], sprintf(
            '/input
                [@type="%s"]
                [@name="name"]
                [@id="name"]
                [@class="text-gray-900 bg-gray-50 rounded-lg text-sm block w-full p-2.5 border border-gray-300 focus:z-10 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500 text-red-900 bg-red-50 border-red-500 placeholder-red-700 dark:bg-red-100 dark:border-red-400 dark:text-red-900 focus:z-10 focus:ring-red-500 focus:border-red-500 dark:focus:ring-red-500 dark:focus:border-red-500"]
            ',
            $inputType,
        ));
    }

    #[DataProvider('selectProvider')]
    public function testErrorSelect(string $classType): void
    {
        $form = $this->factory->createNamed('name', $classType);
        $form->addError(new FormError('[trans]Error message[/trans]'));
        $form->submit([]);

        $this->assertWidgetMatchesXpath($form->createView(), [],
            '/select
                [@name="name"]
                [@id="name"]
                [@class="text-gray-900 bg-gray-50 rounded-lg text-sm block w-full p-2.5 border border-gray-300 focus:z-10 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500 text-red-900 bg-red-50 border-red-500 placeholder-red-700 dark:bg-red-100 dark:border-red-400 dark:text-red-900 focus:z-10 focus:ring-red-500 focus:border-red-500 dark:focus:ring-red-500 dark:focus:border-red-500"]
            '
        );
    }

    public static function inputProvider(): \Generator
    {
        yield TextType::class => [TextType::class, 'foo', 'text'];
        yield EmailType::class => [EmailType::class, 'foo@example.com', 'email'];
        yield IntegerType::class => [IntegerType::class, 123456, 'number'];
        yield NumberType::class => [NumberType::class, 1234.56, 'text'];
        yield PasswordType::class => [PasswordType::class, null, 'password'];
        yield SearchType::class => [SearchType::class, '1', 'search'];
        yield UrlType::class => [UrlType::class, 'https://example.com', 'text'];
        yield TelType::class => [TelType::class, '0123456789', 'tel'];
        yield ColorType::class => [ColorType::class, '#ffffff', 'color'];
    }

    public static function selectProvider(): \Generator
    {
        yield CountryType::class => [CountryType::class];
        yield LanguageType::class => [LanguageType::class];
        yield LocaleType::class => [LocaleType::class];
        yield TimezoneType::class => [TimezoneType::class];
        yield CurrencyType::class => [CurrencyType::class];
    }

    protected function renderForm(FormView $view, array $vars = []): string
    {
        return $this->renderer->renderBlock($view, 'form', $vars);
    }

    protected function renderLabel(FormView $view, $label = null, array $vars = []): string
    {
        if (null !== $label) {
            $vars += ['label' => $label];
        }

        return $this->renderer->searchAndRenderBlock($view, 'label', $vars);
    }

    protected function renderHelp(FormView $view): string
    {
        return $this->renderer->searchAndRenderBlock($view, 'help');
    }

    protected function renderErrors(FormView $view): string
    {
        return $this->renderer->searchAndRenderBlock($view, 'errors');
    }

    protected function renderWidget(FormView $view, array $vars = []): string
    {
        return $this->renderer->searchAndRenderBlock($view, 'widget', $vars);
    }

    protected function renderRow(FormView $view, array $vars = []): string
    {
        return $this->renderer->searchAndRenderBlock($view, 'row', $vars);
    }

    protected function renderRest(FormView $view, array $vars = []): string
    {
        return $this->renderer->searchAndRenderBlock($view, 'rest', $vars);
    }

    protected function renderStart(FormView $view, array $vars = []): string
    {
        return $this->renderer->renderBlock($view, 'form_start', $vars);
    }

    protected function renderEnd(FormView $view, array $vars = []): string
    {
        return $this->renderer->renderBlock($view, 'form_end', $vars);
    }

    protected function setTheme(FormView $view, array $themes, $useDefaultThemes = true): void
    {
        $this->renderer->setTheme($view, $themes, $useDefaultThemes);
    }

    private function registerTwigRuntimeLoader(Environment $environment, FormRenderer $renderer): void
    {
        $loader = $this->createMock(RuntimeLoaderInterface::class);
        $loader->expects($this->any())->method('load')->willReturnMap([
            [FormRenderer::class, $renderer],
        ]);
        $environment->addRuntimeLoader($loader);
    }

    private function assertMatchesXpath(string $html, string $expression, int $count = 1): void
    {
        $dom = new \DOMDocument('UTF-8');
        try {
            // Wrap in <root> node so we can load HTML with multiple tags at
            // the top level
            $dom->loadXML('<root>'.$html.'</root>');
        } catch (\Exception $e) {
            $this->fail(sprintf(
                "Failed loading HTML:\n\n%s\n\nError: %s",
                $html,
                $e->getMessage()
            ));
        }
        $xpath = new \DOMXPath($dom);
        $nodeList = $xpath->evaluate('/root'.$expression);

        if ($nodeList->length != $count) {
            $dom->formatOutput = true;
            $this->fail(sprintf(
                "Failed asserting that \n\n%s\n\nmatches exactly %s. Matches %s in \n\n%s",
                $expression,
                1 == $count ? 'once' : $count.' times',
                1 == $nodeList->length ? 'once' : $nodeList->length.' times',
                // strip away <root> and </root>
                substr($dom->saveHTML(), 6, -8)
            ));
        } else {
            $this->addToAssertionCount(1);
        }
    }

    private function assertWidgetMatchesXpath(FormView $view, array $vars, $xpath): void
    {
        $this->assertMatchesXpath($this->renderWidget($view, array_merge([], $vars)), $xpath);
    }
}
