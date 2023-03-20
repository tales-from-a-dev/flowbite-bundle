# Custom Form Types

This bundle provide the following custom form types:

## SwitchType

The `SwitchType` type has the same behavior as the `CheckboxType` type and allows to display a checkbox as a [toggle switch](https://flowbite.com/docs/components/forms/#toggle-switch):

```php
namespace App\Form;

use TalesFromADev\FlowbiteBundle\Form\Type\SwitchType

class TemplateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('switch', SwitchType::class)
        ;
    }
}
```
