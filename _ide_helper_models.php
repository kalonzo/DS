<?php
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * Class Address
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $street_number
 * @property string|null $street
 * @property string|null $address_additional
 * @property string|null $po_box
 * @property int|null $postal_code
 * @property string|null $city
 * @property string|null $country
 * @property float|null $latitude
 * @property float|null $longitude
 * @property string|null $label
 * @property string|null $firstname
 * @property string|null $lastname
 * @property int $id_location_index
 * @property int|null $id_object_related
 * @property int|null $type_object_related
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereAddressAdditional($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereIdLocationIndex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereIdObjectRelated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address wherePoBox($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereStreetNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereTypeObjectRelated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereUpdatedAt($value)
 */
	class Address extends \Eloquent {}
}

namespace App\Models{
/**
 * Class BankingInfo
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $label
 * @property string|null $iban
 * @property string|null $bic
 * @property string|null $swift
 * @property string|null $bank_name
 * @property int|null $id_address_bank
 * @property string|null $account_owner_lastname
 * @property string|null $account_owner_firstname
 * @property int $id_establishment
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BankingInfo whereAccountOwnerFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BankingInfo whereAccountOwnerLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BankingInfo whereBankName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BankingInfo whereBic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BankingInfo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BankingInfo whereIban($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BankingInfo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BankingInfo whereIdAddressBank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BankingInfo whereIdEstablishment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BankingInfo whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BankingInfo whereSwift($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BankingInfo whereUpdatedAt($value)
 */
	class BankingInfo extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Bill
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $title
 * @property string|null $name
 * @property string|null $prename
 * @property string|null $company_name
 * @property string|null $pro_phone
 * @property string|null $end_date
 * @property string|null $start_date
 * @property string|null $phone_number
 * @property string|null $email
 * @property int|null $id_condition
 * @property int $id_user
 * @property int $id_cart
 * @property int $id_contract
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bill whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bill whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bill whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bill whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bill whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bill whereIdCart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bill whereIdCondition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bill whereIdContract($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bill whereIdUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bill whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bill wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bill wherePrename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bill whereProPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bill whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bill whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bill whereUpdatedAt($value)
 */
	class Bill extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Booking
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int|null $status
 * @property string|null $lastname
 * @property string|null $firstname
 * @property string|null $email
 * @property string|null $phone_number
 * @property string|null $datetime_reservation
 * @property string|null $comment
 * @property int|null $nb_adults
 * @property int|null $nb_children
 * @property float|null $latitude
 * @property float|null $longitude
 * @property int $id_user
 * @property int $id_establishment
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booking whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booking whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booking whereDatetimeReservation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booking whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booking whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booking whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booking whereIdEstablishment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booking whereIdUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booking whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booking whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booking whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booking whereNbAdults($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booking whereNbChildren($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booking wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booking whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booking whereUpdatedAt($value)
 */
	class Booking extends \Eloquent {}
}

namespace App\Models{
/**
 * Class BusinessCategory
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $name
 * @property int|null $type
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BusinessCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BusinessCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BusinessCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BusinessCategory whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BusinessCategory whereUpdatedAt($value)
 */
	class BusinessCategory extends \Eloquent {}
}

namespace App\Models{
/**
 * Class BusinessType
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int $id_media
 * @property string|null $label
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BusinessType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BusinessType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BusinessType whereIdMedia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BusinessType whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BusinessType whereUpdatedAt($value)
 */
	class BusinessType extends \Eloquent {}
}

namespace App\Models{
/**
 * Class BuyableItem
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $designation
 * @property int|null $status
 * @property int|null $type
 * @property float|null $unit_price_HT
 * @property float|null $unit_price_TTC
 * @property float|null $vat_rate
 * @property float|null $price_HT
 * @property float|null $price_TTC
 * @property float|null $discount_amount
 * @property float|null $discount_percent
 * @property float|null $net_price
 * @property int|null $id_object
 * @property int|null $type_object
 * @property string|null $description
 * @property string|null $start_date
 * @property string|null $end_date
 * @property int|null $id_business_type
 * @property int|null $id_geographical_zone
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyableItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyableItem whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyableItem whereDesignation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyableItem whereDiscountAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyableItem whereDiscountPercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyableItem whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyableItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyableItem whereIdBusinessType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyableItem whereIdGeographicalZone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyableItem whereIdObject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyableItem whereNetPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyableItem wherePriceHT($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyableItem wherePriceTTC($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyableItem whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyableItem whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyableItem whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyableItem whereTypeObject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyableItem whereUnitPriceHT($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyableItem whereUnitPriceTTC($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyableItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyableItem whereVatRate($value)
 */
	class BuyableItem extends \Eloquent {}
}

namespace App\Models{
/**
 * Class CallNumber
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $label
 * @property int|null $type
 * @property int|null $main
 * @property int|null $prefix
 * @property string|null $number
 * @property int $id_establishment
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CallNumber whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CallNumber whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CallNumber whereIdEstablishment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CallNumber whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CallNumber whereMain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CallNumber whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CallNumber wherePrefix($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CallNumber whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CallNumber whereUpdatedAt($value)
 */
	class CallNumber extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Cart
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int|null $status
 * @property float|null $price_HT
 * @property float|null $price_TTC
 * @property float|null $vat_amount
 * @property float|null $discount_amount
 * @property float|null $discount_percent
 * @property float|null $shipping_amount
 * @property float|null $total_price
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereDiscountAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereDiscountPercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart wherePriceHT($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart wherePriceTTC($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereShippingAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereTotalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereVatAmount($value)
 */
	class Cart extends \Eloquent {}
}

namespace App\Models{
/**
 * Class CartLine
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $designation
 * @property int|null $qty
 * @property float|null $unit_price_HT
 * @property float|null $unit_price_TTC
 * @property float|null $vat_rate
 * @property float|null $price_HT
 * @property float|null $price_TTC
 * @property float|null $discount_amount
 * @property float|null $discount_percent
 * @property float|null $net_price
 * @property int $id_cart
 * @property int $id_buyable_item
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CartLine whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CartLine whereDesignation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CartLine whereDiscountAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CartLine whereDiscountPercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CartLine whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CartLine whereIdBuyableItem($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CartLine whereIdCart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CartLine whereNetPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CartLine wherePriceHT($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CartLine wherePriceTTC($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CartLine whereQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CartLine whereUnitPriceHT($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CartLine whereUnitPriceTTC($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CartLine whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CartLine whereVatRate($value)
 */
	class CartLine extends \Eloquent {}
}

namespace App\Models{
/**
 * Class ChatMessage
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int|null $status
 * @property string|null $message
 * @property int $id_user_sender
 * @property int $id_user_receiver
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChatMessage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChatMessage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChatMessage whereIdUserReceiver($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChatMessage whereIdUserSender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChatMessage whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChatMessage whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChatMessage whereUpdatedAt($value)
 */
	class ChatMessage extends \Eloquent {}
}

namespace App\Models{
/**
 * Class ChatRequest
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $message
 * @property int|null $status
 * @property int $id_user_sender
 * @property int|null $id_service_target
 * @property int|null $id_user_target
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChatRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChatRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChatRequest whereIdServiceTarget($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChatRequest whereIdUserSender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChatRequest whereIdUserTarget($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChatRequest whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChatRequest whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChatRequest whereUpdatedAt($value)
 */
	class ChatRequest extends \Eloquent {}
}

namespace App\Models{
/**
 * Class ClosePeriod
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $label
 * @property string|null $start date
 * @property string|null $end_date
 * @property int $id_establishment
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ClosePeriod whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ClosePeriod whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ClosePeriod whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ClosePeriod whereIdEstablishment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ClosePeriod whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ClosePeriod whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ClosePeriod whereUpdatedAt($value)
 */
	class ClosePeriod extends \Eloquent {}
}

namespace App\Models{
/**
 * Class CommercialStanding
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int|null $status
 * @property string|null $postal_code
 * @property int|null $site_section
 * @property string|null $start_date
 * @property string|null $end_date
 * @property int|null $position
 * @property int $id_establishment
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CommercialStanding whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CommercialStanding whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CommercialStanding whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CommercialStanding whereIdEstablishment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CommercialStanding wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CommercialStanding wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CommercialStanding whereSiteSection($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CommercialStanding whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CommercialStanding whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CommercialStanding whereUpdatedAt($value)
 */
	class CommercialStanding extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Company
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int $id_logo
 * @property string|null $name
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company whereIdLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company whereUpdatedAt($value)
 */
	class Company extends \Eloquent {}
}

namespace App\Models{
/**
 * Class ComputingSkill
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $name
 * @property int|null $position
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ComputingSkill whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ComputingSkill whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ComputingSkill whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ComputingSkill wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ComputingSkill whereUpdatedAt($value)
 */
	class ComputingSkill extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Contract
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $number
 * @property string|null $start_date
 * @property string|null $end_date
 * @property int $id_user_in_charge
 * @property int $id_establishment_customer
 * @property int $id_user_customer
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contract whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contract whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contract whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contract whereIdEstablishmentCustomer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contract whereIdUserCustomer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contract whereIdUserInCharge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contract whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contract whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contract whereUpdatedAt($value)
 */
	class Contract extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Country
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $iso
 * @property string|null $label
 * @property int $id_currency
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereIdCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereIso($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereUpdatedAt($value)
 */
	class Country extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Cron
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int|null $type
 * @property int|null $status
 * @property int|null $frequency
 * @property string|null $start_time
 * @property int|null $max_duration
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cron whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cron whereFrequency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cron whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cron whereMaxDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cron whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cron whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cron whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cron whereUpdatedAt($value)
 */
	class Cron extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Currency
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $symbol
 * @property string|null $short_label
 * @property string|null $label
 * @property float|null $rate
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Currency whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Currency whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Currency whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Currency whereRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Currency whereShortLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Currency whereSymbol($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Currency whereUpdatedAt($value)
 */
	class Currency extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Cv
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int|null $status
 * @property int|null $civil_status
 * @property string|null $target_job
 * @property int $id_user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cv whereCivilStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cv whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cv whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cv whereIdUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cv whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cv whereTargetJob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cv whereUpdatedAt($value)
 */
	class Cv extends \Eloquent {}
}

namespace App\Models{
/**
 * Class CvLang
 *
 * @property int $id_cv_lang
 * @property string|null $label
 * @property string|null $niveau
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CvLang whereIdCvLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CvLang whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CvLang whereNiveau($value)
 */
	class CvLang extends \Eloquent {}
}

namespace App\Models{
/**
 * Class CvMedia
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int|null $type
 * @property string|null $filename
 * @property string|null $extension
 * @property float|null $size
 * @property int|null $width
 * @property int|null $height
 * @property string|null $local_path
 * @property int|null $position
 * @property int $id_cv
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CvMedia whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CvMedia whereExtension($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CvMedia whereFilename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CvMedia whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CvMedia whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CvMedia whereIdCv($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CvMedia whereLocalPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CvMedia wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CvMedia whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CvMedia whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CvMedia whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CvMedia whereWidth($value)
 */
	class CvMedia extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Dish
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $name
 * @property string|null $description
 * @property int|null $status
 * @property float|null $price
 * @property string|null $currency
 * @property string|null $start_date
 * @property string|null $end_date
 * @property int|null $position
 * @property int $id_establishment
 * @property int|null $id_photo
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dish whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dish whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dish whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dish whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dish whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dish whereIdEstablishment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dish whereIdPhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dish whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dish wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dish wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dish whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dish whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dish whereUpdatedAt($value)
 */
	class Dish extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Employee
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $lastname
 * @property string|null $firstname
 * @property int|null $status
 * @property int|null $id_photo
 * @property string|null $position
 * @property int $id_establishment
 * @property int|null $id_job_type
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Employee whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Employee whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Employee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Employee whereIdEstablishment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Employee whereIdJobType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Employee whereIdPhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Employee whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Employee wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Employee whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Employee whereUpdatedAt($value)
 */
	class Employee extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Establishment
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int|null $status
 * @property string|null $name
 * @property string|null $profile_condition
 * @property string|null $email
 * @property int $id_address
 * @property float|null $DS_ranking
 * @property int $id_logo
 * @property float|null $star
 * @property int|null $nb_last_week_visits
 * @property int|null $accept_voucher
 * @property string|null $site_url
 * @property string|null $description
 * @property float|null $average_price_min
 * @property float|null $average_price_max
 * @property int|null $id_banking_info
 * @property int $id_user_owner
 * @property int $id_business_type
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Establishment whereAcceptVoucher($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Establishment whereAveragePriceMax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Establishment whereAveragePriceMin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Establishment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Establishment whereDSRanking($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Establishment whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Establishment whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Establishment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Establishment whereIdAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Establishment whereIdBankingInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Establishment whereIdBusinessType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Establishment whereIdLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Establishment whereIdUserOwner($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Establishment whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Establishment whereNbLastWeekVisits($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Establishment whereProfileCondition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Establishment whereSiteUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Establishment whereStar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Establishment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Establishment whereUpdatedAt($value)
 */
	class Establishment extends \Eloquent {}
}

namespace App\Models{
/**
 * Class EstablishmentBusinessCategory
 *
 * @property int $id
 * @property int $id_establishment
 * @property int $id_business_category
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EstablishmentBusinessCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EstablishmentBusinessCategory whereIdBusinessCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EstablishmentBusinessCategory whereIdEstablishment($value)
 */
	class EstablishmentBusinessCategory extends \Eloquent {}
}

namespace App\Models{
/**
 * Class EstablishmentHistory
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int|null $year
 * @property string|null $title
 * @property string|null $content
 * @property int|null $id_photo
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EstablishmentHistory whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EstablishmentHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EstablishmentHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EstablishmentHistory whereIdPhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EstablishmentHistory whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EstablishmentHistory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EstablishmentHistory whereYear($value)
 */
	class EstablishmentHistory extends \Eloquent {}
}

namespace App\Models{
/**
 * Class EstablishmentMedia
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int|null $type
 * @property string|null $filename
 * @property string|null $extension
 * @property float|null $size
 * @property int|null $width
 * @property int|null $height
 * @property string|null $local_path
 * @property int|null $position
 * @property int|null $id_gallery
 * @property int|null $id_draft_media
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EstablishmentMedia whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EstablishmentMedia whereExtension($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EstablishmentMedia whereFilename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EstablishmentMedia whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EstablishmentMedia whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EstablishmentMedia whereIdDraftMedia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EstablishmentMedia whereIdGallery($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EstablishmentMedia whereLocalPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EstablishmentMedia wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EstablishmentMedia whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EstablishmentMedia whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EstablishmentMedia whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EstablishmentMedia whereWidth($value)
 */
	class EstablishmentMedia extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Event
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $label
 * @property int|null $status
 * @property string|null $description
 * @property string|null $start_date
 * @property string|null $end_date
 * @property int $id_establishment
 * @property int $id_event_type
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereIdEstablishment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereIdEventType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereUpdatedAt($value)
 */
	class Event extends \Eloquent {}
}

namespace App\Models{
/**
 * Class EventType
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $label
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventType whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventType whereUpdatedAt($value)
 */
	class EventType extends \Eloquent {}
}

namespace App\Models{
/**
 * Class FeedFlow
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int|null $type
 * @property int|null $status
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FeedFlow whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FeedFlow whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FeedFlow whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FeedFlow whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FeedFlow whereUpdatedAt($value)
 */
	class FeedFlow extends \Eloquent {}
}

namespace App\Models{
/**
 * Class FeedFlowTarget
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int $id_feed_flow
 * @property int|null $id_user
 * @property int|null $id_service
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FeedFlowTarget whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FeedFlowTarget whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FeedFlowTarget whereIdFeedFlow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FeedFlowTarget whereIdService($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FeedFlowTarget whereIdUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FeedFlowTarget whereUpdatedAt($value)
 */
	class FeedFlowTarget extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Gallery
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int|null $status
 * @property string|null $name
 * @property int|null $type
 * @property int $id_establishment
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Gallery whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Gallery whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Gallery whereIdEstablishment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Gallery whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Gallery whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Gallery whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Gallery whereUpdatedAt($value)
 */
	class Gallery extends \Eloquent {}
}

namespace App\Models{
/**
 * Class GeographicalZone
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $label
 * @property int $id_country
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GeographicalZone whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GeographicalZone whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GeographicalZone whereIdCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GeographicalZone whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GeographicalZone whereUpdatedAt($value)
 */
	class GeographicalZone extends \Eloquent {}
}

namespace App\Models{
/**
 * Class GeographicalZonesCoordinateBorder
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property float|null $latitude
 * @property float|null $longitude
 * @property int $id_geographical_zone
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GeographicalZonesCoordinateBorder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GeographicalZonesCoordinateBorder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GeographicalZonesCoordinateBorder whereIdGeographicalZone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GeographicalZonesCoordinateBorder whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GeographicalZonesCoordinateBorder whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GeographicalZonesCoordinateBorder whereUpdatedAt($value)
 */
	class GeographicalZonesCoordinateBorder extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Hobby
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $label
 * @property int $id_cv
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hobby whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hobby whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hobby whereIdCv($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hobby whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hobby whereUpdatedAt($value)
 */
	class Hobby extends \Eloquent {}
}

namespace App\Models{
/**
 * Class InboxEmail
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int|null $status
 * @property string|null $subject
 * @property string|null $content
 * @property mixed|null $conversation_identifier
 * @property int $id_user_sender
 * @property int $id_user_recipient
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InboxEmail whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InboxEmail whereConversationIdentifier($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InboxEmail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InboxEmail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InboxEmail whereIdUserRecipient($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InboxEmail whereIdUserSender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InboxEmail whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InboxEmail whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InboxEmail whereUpdatedAt($value)
 */
	class InboxEmail extends \Eloquent {}
}

namespace App\Models{
/**
 * Class JobReference
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $lastname
 * @property string|null $firstname
 * @property string|null $company
 * @property string|null $phone_prefix
 * @property string|null $phone_number
 * @property int|null $position
 * @property int $cv_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobReference whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobReference whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobReference whereCvId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobReference whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobReference whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobReference whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobReference wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobReference wherePhonePrefix($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobReference wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobReference whereUpdatedAt($value)
 */
	class JobReference extends \Eloquent {}
}

namespace App\Models{
/**
 * Class JobType
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $name
 * @property int $id_business_type
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobType whereIdBusinessType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobType whereUpdatedAt($value)
 */
	class JobType extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Language
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $name
 * @property int|null $position
 * @property int|null $translation_available
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Language whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Language whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Language whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Language wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Language whereTranslationAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Language whereUpdatedAt($value)
 */
	class Language extends \Eloquent {}
}

namespace App\Models{
/**
 * Class LinkCvComputingSkill
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int $id_computing_skill
 * @property int $id_cv
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LinkCvComputingSkill whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LinkCvComputingSkill whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LinkCvComputingSkill whereIdComputingSkill($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LinkCvComputingSkill whereIdCv($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LinkCvComputingSkill whereUpdatedAt($value)
 */
	class LinkCvComputingSkill extends \Eloquent {}
}

namespace App\Models{
/**
 * Class LinkCvLanguage
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int $id_cv
 * @property int $id_language
 * @property int|null $level
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LinkCvLanguage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LinkCvLanguage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LinkCvLanguage whereIdCv($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LinkCvLanguage whereIdLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LinkCvLanguage whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LinkCvLanguage whereUpdatedAt($value)
 */
	class LinkCvLanguage extends \Eloquent {}
}

namespace App\Models{
/**
 * Class LinkServiceRole
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int $id_role
 * @property int|null $id_service
 * @property int|null $id_user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LinkServiceRole whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LinkServiceRole whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LinkServiceRole whereIdRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LinkServiceRole whereIdService($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LinkServiceRole whereIdUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LinkServiceRole whereUpdatedAt($value)
 */
	class LinkServiceRole extends \Eloquent {}
}

namespace App\Models{
/**
 * Class LinkServiceUser
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int $id_service
 * @property int $id_user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LinkServiceUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LinkServiceUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LinkServiceUser whereIdService($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LinkServiceUser whereIdUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LinkServiceUser whereUpdatedAt($value)
 */
	class LinkServiceUser extends \Eloquent {}
}

namespace App\Models{
/**
 * Class LinkUserInChargeOfEstablishment
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int $id_user
 * @property int $id_establishment
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LinkUserInChargeOfEstablishment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LinkUserInChargeOfEstablishment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LinkUserInChargeOfEstablishment whereIdEstablishment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LinkUserInChargeOfEstablishment whereIdUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LinkUserInChargeOfEstablishment whereUpdatedAt($value)
 */
	class LinkUserInChargeOfEstablishment extends \Eloquent {}
}

namespace App\Models{
/**
 * Class LocationIndex
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $postal_code
 * @property string|null $city
 * @property float|null $latitude
 * @property float|null $longitude
 * @property int $id_country
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LocationIndex whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LocationIndex whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LocationIndex whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LocationIndex whereIdCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LocationIndex whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LocationIndex whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LocationIndex wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LocationIndex whereUpdatedAt($value)
 */
	class LocationIndex extends \Eloquent {}
}

namespace App\Models{
/**
 * Class LoggedAction
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int|null $action
 * @property int|null $type_object_related
 * @property int|null $id_object_related
 * @property int $id_user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LoggedAction whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LoggedAction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LoggedAction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LoggedAction whereIdObjectRelated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LoggedAction whereIdUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LoggedAction whereTypeObjectRelated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LoggedAction whereUpdatedAt($value)
 */
	class LoggedAction extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Menu
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $name
 * @property int|null $status
 * @property int|null $is_daily_menu
 * @property string|null $start_date
 * @property string|null $end_date
 * @property int|null $position
 * @property int $id_establishment
 * @property int $id_file
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menu whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menu whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menu whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menu whereIdEstablishment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menu whereIdFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menu whereIsDailyMenu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menu whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menu wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menu whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menu whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menu whereUpdatedAt($value)
 */
	class Menu extends \Eloquent {}
}

namespace App\Models{
/**
 * Description of Model
 *
 * @author Nico
 */
	class Model extends \Eloquent {}
}

namespace App\Models{
/**
 * Class OpeningHour
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int|null $day
 * @property string|null $start_time
 * @property string|null $end_time
 * @property string|null $start_date
 * @property string|null $end_date
 * @property int $id_establishment
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OpeningHour whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OpeningHour whereDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OpeningHour whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OpeningHour whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OpeningHour whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OpeningHour whereIdEstablishment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OpeningHour whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OpeningHour whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OpeningHour whereUpdatedAt($value)
 */
	class OpeningHour extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Payment
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int|null $status
 * @property float|null $amount
 * @property int $id_user
 * @property int $id_payment_method
 * @property int $id_bill
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereIdBill($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereIdPaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereIdUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereUpdatedAt($value)
 */
	class Payment extends \Eloquent {}
}

namespace App\Models{
/**
 * Class PaymentMethod
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $name
 * @property int|null $status
 * @property int|null $id_logo
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentMethod whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentMethod whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentMethod whereIdLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentMethod whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentMethod whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentMethod whereUpdatedAt($value)
 */
	class PaymentMethod extends \Eloquent {}
}

namespace App\Models{
/**
 * Class ProfessionalExperience
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string $company_name
 * @property string|null $job
 * @property string|null $start_date
 * @property string $end_date
 * @property int $id_cv
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProfessionalExperience whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProfessionalExperience whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProfessionalExperience whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProfessionalExperience whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProfessionalExperience whereIdCv($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProfessionalExperience whereJob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProfessionalExperience whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProfessionalExperience whereUpdatedAt($value)
 */
	class ProfessionalExperience extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Promotion
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $name
 * @property int|null $status
 * @property string|null $description
 * @property string|null $start_date
 * @property string|null $end_date
 * @property int $id_establishment
 * @property int $id_promotion_type
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Promotion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Promotion whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Promotion whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Promotion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Promotion whereIdEstablishment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Promotion whereIdPromotionType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Promotion whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Promotion whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Promotion whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Promotion whereUpdatedAt($value)
 */
	class Promotion extends \Eloquent {}
}

namespace App\Models{
/**
 * Class PromotionType
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $name
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PromotionType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PromotionType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PromotionType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PromotionType whereUpdatedAt($value)
 */
	class PromotionType extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Restaurant
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int|null $status
 * @property string|null $name
 * @property string|null $profile_condition
 * @property string|null $email
 * @property int $id_address
 * @property float|null $DS_ranking
 * @property int $id_logo
 * @property float|null $star
 * @property int|null $nb_last_week_visits
 * @property int|null $accept_voucher
 * @property string|null $site_url
 * @property string|null $description
 * @property float|null $average_price_min
 * @property float|null $average_price_max
 * @property int|null $id_banking_info
 * @property int $id_user_owner
 * @property int $id_business_type
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Restaurant whereAcceptVoucher($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Restaurant whereAveragePriceMax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Restaurant whereAveragePriceMin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Restaurant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Restaurant whereDSRanking($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Restaurant whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Restaurant whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Restaurant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Restaurant whereIdAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Restaurant whereIdBankingInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Restaurant whereIdBusinessType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Restaurant whereIdLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Restaurant whereIdUserOwner($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Restaurant whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Restaurant whereNbLastWeekVisits($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Restaurant whereProfileCondition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Restaurant whereSiteUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Restaurant whereStar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Restaurant whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Restaurant whereUpdatedAt($value)
 */
	class Restaurant extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Role
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string $role
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereUpdatedAt($value)
 */
	class Role extends \Eloquent {}
}

namespace App\Models{
/**
 * Class RoleAction
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int|null $action
 * @property int $id_role
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoleAction whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoleAction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoleAction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoleAction whereIdRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoleAction whereUpdatedAt($value)
 */
	class RoleAction extends \Eloquent {}
}

namespace App\Models{
/**
 * Class SchoolExperience
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $name
 * @property string|null $start_date
 * @property string|null $end_date
 * @property int $id_cv
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SchoolExperience whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SchoolExperience whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SchoolExperience whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SchoolExperience whereIdCv($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SchoolExperience whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SchoolExperience whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SchoolExperience whereUpdatedAt($value)
 */
	class SchoolExperience extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Service
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string $service
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Service whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Service whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Service whereService($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Service whereUpdatedAt($value)
 */
	class Service extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Skill
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $label
 * @property int $id_cv
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Skill whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Skill whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Skill whereIdCv($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Skill whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Skill whereUpdatedAt($value)
 */
	class Skill extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Subscription
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property float|null $priceTTC
 * @property string|null $start_date
 * @property string|null $end_date
 * @property string|null $close_date
 * @property int $id_establishment
 * @property int $id_user
 * @property int $id_bill
 * @property int $id_buyable_item
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription whereCloseDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription whereIdBill($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription whereIdBuyableItem($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription whereIdEstablishment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription whereIdUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription wherePriceTTC($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription whereUpdatedAt($value)
 */
	class Subscription extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Translation
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $content
 * @property int $id_language
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Translation whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Translation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Translation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Translation whereIdLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Translation whereUpdatedAt($value)
 */
	class Translation extends \Eloquent {}
}

namespace App\Models{
/**
 * Class User
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int|null $status
 * @property int|null $type
 * @property int|null $gender
 * @property string $name
 * @property string|null $lastname
 * @property string|null $firstname
 * @property string|null $email
 * @property string|null $password
 * @property string|null $remember_token
 * @property int|null $is_connected
 * @property int $id_address
 * @property int $id_inbox
 * @property float|null $longitude
 * @property float|null $latitude
 * @property int|null $id_photo
 * @property int $company_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereIdAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereIdInbox($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereIdPhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereIsConnected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * Class UserFavouriteEstablishment
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int $id_user
 * @property int $id_establishment
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserFavouriteEstablishment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserFavouriteEstablishment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserFavouriteEstablishment whereIdEstablishment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserFavouriteEstablishment whereIdUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserFavouriteEstablishment whereUpdatedAt($value)
 */
	class UserFavouriteEstablishment extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Voucher
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int|null $status
 * @property float|null $priceTTC
 * @property string|null $end_date
 * @property int $id_establishment
 * @property int $id_buyable_item
 * @property int $id_bill
 * @property int $id_user
 * @property int $id_currency
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher whereIdBill($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher whereIdBuyableItem($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher whereIdCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher whereIdEstablishment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher whereIdUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher wherePriceTTC($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher whereUpdatedAt($value)
 */
	class Voucher extends \Eloquent {}
}

namespace App{
/**
 * App\User
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int|null $status
 * @property int|null $type
 * @property int|null $gender
 * @property string $name
 * @property string|null $lastname
 * @property string|null $firstname
 * @property string|null $email
 * @property string|null $password
 * @property string|null $remember_token
 * @property int|null $is_connected
 * @property int $id_address
 * @property int $id_inbox
 * @property float|null $longitude
 * @property float|null $latitude
 * @property int|null $id_photo
 * @property int $company_id
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereIdAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereIdInbox($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereIdPhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereIsConnected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

