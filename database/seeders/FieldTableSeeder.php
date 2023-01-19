<?php

namespace Database\Seeders;

use App\Enums\FieldName;
use App\Enums\FieldType;
use App\Enums\Status;
use App\Models\Field;
use App\Models\Student;
use App\Models\StudentField;
use Illuminate\Database\Seeder;

class FieldTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $fields = Field::create([
            'title'            => 'Blood Group',
            'slug'             => 'blood_group',
            'field_type'       => FieldName::INPUT,
            'type'             => FieldType::TEXT,
            'status'           => Status::ACTIVE,
            'institute_id'     => 1,
        ]);
    }
}
