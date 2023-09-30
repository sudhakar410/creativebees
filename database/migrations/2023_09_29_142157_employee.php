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
            Schema::create('employee', function (Blueprint $table) {
            $table->id(); // Auto-incremental primary key
            $table->string('employee_id')->unique(); // Unique employee identifier
            $table->string('firstname');
            $table->string('lastname');
            $table->date('date_of_birth');
            $table->string('education_qualification');
            $table->text('address');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('photo')->nullable(); // Assuming photo is a file path, make it nullable
            $table->text('resume')->nullable(); // Assuming resume is a file path, make it nullable
            $table->timestamps(); // Created at and updated at timestamps
        });    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::dropIfExists('employee');
    }
};
