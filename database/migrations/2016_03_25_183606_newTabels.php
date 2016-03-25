<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NewTabels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('societies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('registration_no')->unique();
            $table->text('address');
            $table->date('year_of_registration');
            $table->string('project_by');
            $table->string('subscription_charges');
            $table->date('subscription_start_date');
            $table->date('subscription_end_date');
            $table->tinyInteger('status');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('society_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('society_id')->unsigned();
            $table->foreign('society_id')->references('id')->on('societies')->onUpdate('cascade')->onDelete('cascade');
            $table->string('parameter_details');//for ex: {wings:2, flat:50, shop:15}
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('society_account_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('society_id')->unsigned();
            $table->foreign('society_id')->references('id')->on('societies')->onUpdate('cascade')->onDelete('cascade');
            $table->string('bank_name');
            $table->string('account_name');
            $table->string('account_no');
            $table->text('address');
            $table->string('micr_code');
            $table->string('ifsc_code');
            $table->string('account_type');
            $table->string('authority_signatory');//for ex: secretary,treasure
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('society_assets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('society_id')->unsigned();
            $table->foreign('society_id')->references('id')->on('societies')->onUpdate('cascade')->onDelete('cascade');
            $table->string('name');//came from society_details tabel and column parameter_details Key
            $table->string('number');//201
            $table->string('description');
            $table->string('type');
            $table->double('area',15,2);
            $table->string('table_type',15,2);//wing,flat
            $table->integer('parent_id')->unsigned();
            $table->foreign('parent_id')->references('id')->on('society_assets')->onUpdate('cascade')->onDelete('cascade');
            $table->softDeletes();
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
        Schema::drop('society_account_details');
        Schema::drop('society_details');
        Schema::drop('society_assets');
        Schema::drop('societies');
    }
}
