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
        Schema::create('stu_parents', function (Blueprint $table) {
            $table->id();
            $table->string("father_name");
            $table->string("father_contact");
            $table->string("father_contact_2")->nullable();
            $table->string("father_whatsapp")->nullable();
            $table->string("father_email")->nullable();
            $table->string("father_qualification");
            $table->string("father_occupation");
            $table->string("father_annual_income");
            $table->string("father_photo")->nullable();

            $table->string("mother_name");
            $table->string("mother_contact")->nullable();
            $table->string("mother_contact_2")->nullable();
            $table->string("mother_whatsapp")->nullable();
            $table->string("mother_email")->nullable();
            $table->string("mother_qualification");
            $table->string("mother_occupation");
            $table->string("mother_annual_income")->nullable();
            $table->string("mother_photo")->nullable();

            $table->bigInteger("created_by");
            $table->bigInteger("updated_by")->nullable();
            $table->bigInteger("deleted_by")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stu_parents');
    }
};
