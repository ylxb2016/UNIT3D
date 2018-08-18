<?php
/**
 * NOTICE OF LICENSE
 *
 * UNIT3D is open-sourced software licensed under the GNU General Public License v3.0
 * The details is bundled with this project in the file LICENSE.txt.
 *
 * @project    UNIT3D
 * @license    https://www.gnu.org/licenses/agpl-3.0.en.html/ GNU Affero General Public License v3.0
 * @author     HDVinnie
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Privilege extends Model
{
    /**
     * The Attributes That Should Be Casted To Native Types
     *
     * @var array
     */
    protected $casts = [
        'active' => 'bool',
    ];

    /**
     * Belongs To Many Roles
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_privileges', 'privilege_id', 'role_id');
    }

    /**
     * Belongs To Many Users
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users() {
        return $this->belongsToMany(User::class, 'user_privileges', 'privilege_id', 'user_id');
    }
}