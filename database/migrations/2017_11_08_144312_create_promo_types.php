<?php

use App\Models\PromotionType;
use Illuminate\Database\Migrations\Migration;

class CreatePromoTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        PromotionType::create([
                'id' => PromotionType::TYPE_DISCOUNT_PERCENT,
                'name' => PromotionType::getLabelFromType(PromotionType::TYPE_DISCOUNT_PERCENT)
            ]);
        PromotionType::create([
                'id' => PromotionType::TYPE_DISCOUNT_AMOUNT,
                'name' => PromotionType::getLabelFromType(PromotionType::TYPE_DISCOUNT_AMOUNT)
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        PromotionType::whereIn('id', [PromotionType::TYPE_DISCOUNT_PERCENT, PromotionType::TYPE_DISCOUNT_AMOUNT])->delete();
    }
}
