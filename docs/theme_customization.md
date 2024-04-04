# Theme customization

## Overriding CSS classes

All used CSS classes are contained in [Twig blocks](https://github.com/talesfromadev/flowbite-bundle/blob/main/templates/form/default.twig#L244) 
which allows to customize the theme very easily.

Create a new theme in your `templates` directory and make it use the bundle `default` theme: 

```php
# templates/form/layout.html.twig

{% use '@TalesFromADevFlowbite/form/default.html.twig' %}
```

Now, just override the desire block with any Tailwind CSS class you want:

```php
# templates/form/layout.html.twig

{% use '@TalesFromADevFlowbite/form/default.html.twig' %}

{% block class_submit -%}
    # use any Tailwind CSS class you want ...
{%- endblock class_submit %}
```

Finally, don't forget to update your `twig` configuration to use your newly created template:

```yaml
# config/packages/twig.yaml

twig:
    # ...
    form_themes:
        - 'form/layout.html.twig'
```

## Class block list

Here is a list of all available class block:

* Label
  * class_label
  * class_input_radio_label
  * class_input_switch_label
  * class_input_switch_label_container
* Input
  * class_input_text
  * class_input_range
  * class_input_file
  * class_input_radio
  * class_input_checkbox
  * class_input_switch
* Select
  * class_select
* Textarea
  * class_textarea
* Button / Submit
  * class_button
  * class_submit
* Various
  * class_time_separator
  * class_addon
  * class_widget_addon_prepend
  * class_widget_addon_append
  * class_addon_prepend
  * class_addon_append
  * class_help_text
* Error
  * class_label_error
  * class_input_radio_label_error
  * class_input_switch_label_error
  * class_input_error
  * class_text_error
* Disabled
  * class_input_disabled 
