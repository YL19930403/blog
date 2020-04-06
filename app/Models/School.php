<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;//这个trait一定要引用的

class School extends Model
{
    use Searchable;
    protected $table = 'schools';
    protected $fillable = ['name', 'about'];

    //把type理解成一个数据表。我们现在要做的就是把我们所有的要全文搜索的字段都存入到es中的一个叫'_doc'的表中
    public function searchableAs()
    {
        return '_doc';
    }

    // 定义有那些字段需要搜索
    public function toSearchableArray()
    {
        return [
            'school_name' => $this->name,
            'school_about' => $this->about,
            'school_created_at' => $this->created_at,
            'school_updated_at' => $this->updated_at,
            'school_code' => $this->code,
            'school_medium' => $this->medium,
            'school_theme' => $this->theme,
            'school_established' => $this->established,
        ];
    }


}
