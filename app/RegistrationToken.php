<?php

namespace App;

use App\Models\User;
use App\Utilities\DbQueryTools;
use App\Utilities\UuidTools;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Kitano\Aktiv8me\ActivatesUsers;

/**
 * App\RegistrationToken
 *
 * @property int $id
 * @property int $user_id
 * @property string $token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read User $user
 * @method static \Illuminate\Database\Query\Builder|\App\RegistrationToken whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\RegistrationToken whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\RegistrationToken whereToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\RegistrationToken whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\RegistrationToken whereUserId($value)
 * @mixin \Eloquent
 */
class RegistrationToken extends Model
{
    use ActivatesUsers;

    /** @var array */
    protected $fillable = ['user_id', 'token'];

    /**
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'token';
    }

    /**
     * Relationship
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
//        return $this->belongsTo(Models\User::class);
    }

    /**
     * Creates a token for a given user
     *
     * @param User $user
     *
     * @return static|User
     */
    public static function createFor(User $user)
    {
        return static::create([
            'user_id' => $user->getId(),
            'token' => ActivatesUsers::generateToken(),
        ]);
    }

    /**
     * Deletes all tokens for a given user
     *
     * @param int $id  User ID
     *
     * @return bool|null
     * @throws Exception
     */
    public static function deleteCode($id)
    {
        return static::whereRaw(DbQueryTools::genSqlForWhereRawUuidConstraint('user_id', UuidTools::getUuid($id)))->delete();
    }

    /**
     * Finds tokens for a given user
     *
     * @param $userId
     *
     * @return Collection|static[]
     */
    public static function findCodes($userId)
    {
        return static::whereRaw(DbQueryTools::genSqlForWhereRawUuidConstraint('user_id', $userId))->get();
    }

    /**
     * Finds a specific Token
     *
     * @param $code
     *
     * @return Model|null|static
     */
    public static function findToken($code)
    {
        return static::where('token', $code)->first();
    }

    /**
     * @param $email
     *
     * @return RegistrationToken|User
     */
    public static function makeToken($email)
    {
        return static::createFor(User::findByEmail($email));
    }

    /**
     * Updates a token for a given user
     *
     * @param User $user
     *
     * @return RegistrationToken|null|static
     */
    public static function updateFor(User $user)
    {
        $user_token = static::whereRaw(DbQueryTools::genSqlForWhereRawUuidConstraint('user_id', $user->getUuid()))->first();
        $user_token->token = ActivatesUsers::generateToken();
        $user_token->save();

        return $user_token;
    }
}
