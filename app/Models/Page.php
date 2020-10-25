<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class Page
 * @package App\Models
 *
 * @property integer $id
 * @property string $name
 * @property string $author
 * @property string $page_uid
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Page extends Model
{
    protected $dateFormat = 'Y-m-d H:i:s';
}
