<?php
/**
 * For database interact with role_master tables
 * PHP version 8.1
 *
 * @category RoleManagement
 * @package  App\Models
 * @author   meet.panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Table information and uuid generation
 *
 * @category RoleManagement
 * @package  App\Models
 * @author   meet.panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 * @link     https://brainvire.com
 */
class RoleMaster extends Model
{
    use HasFactory;

    public $table = 'role_master';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'status',
        'created_by',
        'update_by',
    ];
}
