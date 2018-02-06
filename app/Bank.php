<?php
/**
 * NOTICE OF LICENSE
 *
 * UNIT3D is open-sourced software licensed under the GNU General Public License v3.0
 * The details is bundled with this project in the file LICENSE.txt.
 *
 * @project    UNIT3D
 * @license    https://choosealicense.com/licenses/gpl-3.0/  GNU General Public License v3.0
 * @author     HDVinnie
 */

namespace App;

use App\Bet;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $table = 'banks';

    public static function bankBalance(){
    	return Bank::first();
    }

    public static function updateBankBalance($value){
    	$bankData = Bank::first();
    	$bankData->value = $bankData->value + $value;
    	$bankData->save();
    }
}
