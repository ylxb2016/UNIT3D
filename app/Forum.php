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

class Forum extends Model
{

    protected $guarded = ['id'];

    public function topics()
    {
        return $this->hasMany(ForumTopic::class);
    }

    public function permissions()
    {
        return $this->hasMany(ForumPermission::class);
    }

    public function category()
    {
        return $this->belongsTo(ForumCategory::class);
    }

    public function posts()
    {
        return $this->hasManyThrough(ForumPost::class, ForumTopic::class);
    }
}
