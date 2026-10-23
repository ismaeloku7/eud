<?php

namespace App\Pages;

enum FieldType: string
{
    case Text = 'text';
    case Textarea = 'textarea';
    case Rich = 'rich';
    case Image = 'image';
    case File = 'file';
    case Color = 'color';
    case Number = 'number';
    case Url = 'url';
    case Resources = 'resources';
    case Repeater = 'repeater';
}
