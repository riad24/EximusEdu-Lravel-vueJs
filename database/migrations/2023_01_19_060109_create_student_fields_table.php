<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_fields', function (Blueprint $table) {
            $table->id();
            $table->string('field_name');
            $table->string('field_value')->nullable();
            $table->foreignId('field_id')->constrained();
            $table->foreignId('student_id')->constrained();
            $table->foreignId('institute_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_fields');
    }
};
