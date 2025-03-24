<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FieldType;

class FieldTypeSeeder extends Seeder
{
    public function run(): void
    {
        $fieldTypes = [
            'TextInput',
            'Select',
            'Checkbox',
            'Toggle',
            'CheckboxList',
            'Radio',
            'DateTimePicker',
            'FileUpload',
            'RichEditor',
            'MarkdownEditor',
            // 'Repeater',
            // 'Builder',
            'Tags',
            'TextArea',
            // 'KeyValue',
            'ColorPicker',
            'ToggleButtons',
            'Hidden',
            'Relationship'
        ];

        foreach ($fieldTypes as $fieldType) {
            FieldType::firstOrCreate([
                'name' => $fieldType,
                'label' => $this->addSpace($fieldType),
                'description' => $this->addSpace($fieldType) . ' field type.',
            ]);
        }
    }

    private function addSpace($string)
    {
        $result = preg_replace('/([a-z])([A-Z])/', '$1 $2', $string);
        return $result;
    }
}
