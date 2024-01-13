<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('fname');
            $table->string('lname');
            $table->string('name');
            $table->string('father_name');
            $table->string('mother_name');
            $table->date('dob');
            $table->enum('gender', ['male', 'female','other']);
            $table->string('reading_class', 15);
            $table->string('group', 20)->nullable();;
            $table->string('email')->unique();
            $table->string('phone', 20);
            $table->text('address');
            $table->text('photo');
            $table->boolean('confirmation');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        // Set the auto-increment start value to 1000
        DB::update("ALTER TABLE students AUTO_INCREMENT = 1000;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
