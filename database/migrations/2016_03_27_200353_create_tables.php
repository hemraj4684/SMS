<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    
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
            $table->string('name');//came from society_details table and column parameter_details Key
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

        Schema::create('members', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('mobile_no');
            $table->string('email');
            $table->date('dob');
            $table->integer('parent_id')->unsigned();
            $table->foreign('parent_id')->references('id')->on('members')->onUpdate('cascade')->onDelete('cascade');
            $table->string('pan_no');
            $table->string('blood_group');
            $table->string('password');
            $table->boolean('is_active');
            $table->string('relation_or_type');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('members_society_assets', function (Blueprint $table) {
            $table->integer('society_asset_id')->unsigned();
            $table->foreign('society_asset_id')->references('id')->on('society_assets')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('member_id')->unsigned();
            $table->foreign('member_id')->references('id')->on('members')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('member_devices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('member_id')->unsigned();
            $table->foreign('member_id')->references('id')->on('members')->onUpdate('cascade')->onDelete('cascade');
            $table->string('unique_id');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('maintenance', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('society_id')->unsigned();
            $table->foreign('society_id')->references('id')->on('societies')->onUpdate('cascade')->onDelete('cascade');
            $table->string('head');
            //expected value{["head1":{"name":"sinking fund", "formula":"perSqft * 20"}]}
            $table->date('start_date');
            $table->date('end_date');
            $table->softDeletes();
            $table->timestamps();
        });
        
        Schema::create('maintenance_head', function (Blueprint $table) {
            $table->increments('id');
            $table->string('head_name');
            $table->string('formula');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('society_id')->unsigned();
            $table->foreign('society_id')->references('id')->on('societies')->onUpdate('cascade')->onDelete('cascade');
            $table->softDeletes();
        });

        Schema::create('member_maintenance', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('member_id')->unsigned();
            $table->foreign('member_id')->references('id')->on('members')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('maintenance_head_id')->unsigned();
            $table->foreign('maintenance_head_id')->references('id')->on('maintenance_head')->onUpdate('cascade')->onDelete('cascade');
            $table->double('amount',15,2);
            $table->integer('month');
            $table->integer('year');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('vendors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('contact_no');
            $table->string('email');
            $table->string('type_of_work');
            $table->string('contact_person');
            $table->string('contact_person_mobile_no');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('expenses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('vendor_id')->unsigned();
            $table->foreign('vendor_id')->references('id')->on('vendors')->onUpdate('cascade')->onDelete('cascade');
            $table->string('type_of_work');
            $table->string('work_discription');
            $table->date('start_date');
            $table->date('end_date');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description');
            $table->integer('society_id')->unsigned();
            $table->foreign('society_id')->references('id')->on('societies')->onUpdate('cascade')->onDelete('cascade');
            $table->date('dob');
            $table->integer('resposible_person')->unsigned();
            $table->foreign('resposible_person')->references('id')->on('members')->onUpdate('cascade')->onDelete('cascade');
            $table->double('expected_expenditure',15,2);
            $table->date('start_date');
            $table->date('end_date');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('event_income', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('event_id')->unsigned();
            $table->foreign('event_id')->references('id')->on('events')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('member_id')->unsigned();
            $table->foreign('member_id')->references('id')->on('members')->onUpdate('cascade')->onDelete('cascade');
            $table->double('amount',15,2);
            $table->date('date');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('event_expenses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('event_id')->unsigned();
            $table->foreign('event_id')->references('id')->on('events')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('spend_by')->unsigned();
            $table->foreign('spend_by')->references('id')->on('members')->onUpdate('cascade')->onDelete('cascade');
            $table->string('title');
            $table->string('description');
            $table->double('amount',15,2);
            $table->date('date');
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
        Schema::drop('societies');
        Schema::drop('society_account_details');
        Schema::drop('society_details');
        Schema::drop('society_assets');
        Schema::drop('members');
        Schema::drop('members_society_assets');
        Schema::drop('members_devices');
        Schema::drop('maintenance');
        Schema::drop('maintenance_head');
        Schema::drop('member_maintenance');
        Schema::drop('vendors');
        Schema::drop('expenses');
        Schema::drop('events');
        Schema::drop('event_expenses');
        Schema::drop('event_income');
    }
}
