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

class Role extends Model
{
    /**
     * The Attributes That Should Be Casted To Native Types
     *
     * @var array
     */
    protected $casts = [
        'active' => 'bool',
        'level' => 'int',
    ];

    /**
     * Belongs To Many Privileges
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function privileges()
    {
        return $this->belongsToMany(Privilege::class, 'role_privileges', 'role_id', 'privilege_id');
    }

    /**
     * Belongs To Many Users
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_roles', 'role_id', 'user_id');
    }

    /**
     * Relationship To A Single Role Rule
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function rule()
    {
        return $this->hasOne(RoleRule::class);
    }
}