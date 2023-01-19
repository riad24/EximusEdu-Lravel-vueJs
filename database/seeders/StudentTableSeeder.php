<?php

namespace Database\Seeders;


use App\Enums\Status;
use App\Models\Student;
use App\Models\StudentField;
use Illuminate\Database\Seeder;

class StudentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $student = Student::create([
            'class_name'       => 'One',
            'name'              => 'John Doe',
            'email'             => 'student@example.com',
            'phone'             => '0125488555',
            'institute_id'      => 1,
            'status'            => Status::ACTIVE,
        ]);

        $studentField = StudentField::create([
            'field_name'       => 'blood_group',
            'field_value'      => 'o+',
            'student_id'       => $student->id,
            'field_id'         => 1,
            'institute_id'     => 1,
        ]);
    }
}
