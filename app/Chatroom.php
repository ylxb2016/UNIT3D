<?php
/**
 * NOTICE OF LICENSE
 *
 * UNIT3D is open-sourced software licensed under the GNU General Public License v3.0
 * The details is bundled with this project in the file LICENSE.txt.
 *
 * @project    UNIT3D
 * @license    https://www.gnu.org/licenses/agpl-3.0.en.html/ GNU Affero General Public License v3.0
 * @author     Poppabear
 */

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Chatroom extends Model
{
    use Notifiable;

    protected $guarded = ['id'];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}