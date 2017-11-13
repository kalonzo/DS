<?php

use App\Models\PaymentMethod;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePaymentMethodsConfig extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(PaymentMethod::TABLENAME, function(Blueprint $table)
        {
            $table->integer('method_config')->nullable();
        });
        Schema::table(App\Models\Payment::TABLENAME, function(Blueprint $table)
        {
            $table->integer('method_config')->nullable();
        });
        PaymentMethod::create([
            'id' => PaymentMethod::METHOD_CB_AMEX,
            'name' => 'CB American Express',
            'status' => PaymentMethod::STATUS_ACTIVE,
            'method_config' => PaymentMethod::METHOD_CONFIG_IFRAME
        ]);
        PaymentMethod::create([
            'id' => PaymentMethod::METHOD_CB_PAYPAL,
            'name' => 'CB via Paypal',
            'status' => PaymentMethod::STATUS_DISABLED,
            'method_config' => PaymentMethod::METHOD_CONFIG_OFFSITE
        ]);
        $iframeMethods = PaymentMethod::whereIn('id',[PaymentMethod::METHOD_CB_MASTERCARD, PaymentMethod::METHOD_CB_VISA])->get();
        foreach($iframeMethods as $iframeMethod){
            $iframeMethod->setMethodConfig(PaymentMethod::METHOD_CONFIG_IFRAME)->save();
        }
        PaymentMethod::where('id', '=', PaymentMethod::METHOD_CB_POSTFINANCE)->first()->setMethodConfig(PaymentMethod::METHOD_CONFIG_OFFSITE)->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(PaymentMethod::TABLENAME, function(Blueprint $table)
        {
            $table->dropColumn('method_config');
        });
    }
}
