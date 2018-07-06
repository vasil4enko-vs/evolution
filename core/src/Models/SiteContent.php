<?php namespace EvolutionCMS\Models;

use Illuminate\Database\Eloquent;
use EvolutionCMS\Traits;

/**
 * @property int $id
 * @property string $type
 * @property string $contentType
 * @property string $pagetitle
 * @property string $longtitle
 * @property string $description
 * @property string $alias
 * @property string $link_attributes
 * @property int $published
 * @property int $pub_date
 * @property int $unpub_date
 * @property int $parent
 * @property int $isfolder
 * @property string $introtext
 * @property string $content
 * @property bool $richtext
 * @property int $template
 * @property int $menuindex
 * @property int $searchable
 * @property int $cacheable
 * @property int $createdby
 * @property int $createdon
 * @property int $editedby
 * @property int $editedon
 * @property int $deleted
 * @property string $deletedon
 * @property int $deletedby
 * @property int $publishedon
 * @property int $publishedby
 * @property string $menutitle
 * @property bool $donthit
 * @property bool $privateweb
 * @property bool $privatemgr
 * @property bool $content_dispo
 * @property bool $hidemenu
 * @property int $alias_visible
 *
 * Virtual
 * @property-read \Carbon\Carbon $pub_at
 * @property-read \Carbon\Carbon $unPub_at
 * @property-read \Carbon\Carbon $created_at
 * @property-read \Carbon\Carbon $updated_at
 * @property-read \Carbon\Carbon $deleted_at
 * @property-read bool $isAlreadyEdit
 * @property-read null|array $alreadyEditInfo
 */
class SiteContent extends Eloquent\Model
{
    use Traits\Models\SoftDeletes,
        Traits\Models\ManagerActions,
        Traits\Models\TimeMutator;

    protected $table = 'site_content';

    const CREATED_AT = 'createdon';
    const UPDATED_AT = 'editedon';
    const DELETED_AT = 'deletedon';
	protected $dateFormat = 'U';

	protected $casts = [
		'published' => 'int',
		'pub_date' => 'int',
		'unpub_date' => 'int',
		'parent' => 'int',
		'isfolder' => 'int',
		'richtext' => 'bool',
		'template' => 'int',
		'menuindex' => 'int',
		'searchable' => 'int',
		'cacheable' => 'int',
		'createdby' => 'int',
		'createdon' => 'int',
		'editedby' => 'int',
		'editedon' => 'int',
		'deleted' => 'int',
		'deletedby' => 'int',
		'publishedon' => 'int',
		'publishedby' => 'int',
		'donthit' => 'bool',
		'privateweb' => 'bool',
		'privatemgr' => 'bool',
		'content_dispo' => 'bool',
		'hidemenu' => 'bool',
		'alias_visible' => 'int'
	];

	protected $fillable = [
		'type',
		'contentType',
		'pagetitle',
		'longtitle',
		'description',
		'alias',
		'link_attributes',
		'published',
		'pub_date',
		'unpub_date',
		'parent',
		'isfolder',
		'introtext',
		'content',
		'richtext',
		'template',
		'menuindex',
		'searchable',
		'cacheable',
		'createdby',
		'editedby',
		'deleted',
		'deletedby',
		'publishedon',
		'publishedby',
		'menutitle',
		'donthit',
		'privateweb',
		'privatemgr',
		'content_dispo',
		'hidemenu',
		'alias_visible'
	];

    protected $managerActionsMap = [
        'id' => [
            'actions.info'  => 3
        ]
    ];

    public function getNodeNameAttribute()
    {
        $key = evolutionCMS()->getConfig('resource_tree_node_name', 'pagetitle');
        if (mb_strtolower($key) === 'nodename') {
            $key = 'pagetitle';
        }

        return  $this->getAttributeValue($key);
    }


    public function getCreatedAtAttribute()
    {
        return $this->convertTimestamp($this->createdon);
    }

    public function getUpdatedAtAttribute()
    {
        return $this->convertTimestamp($this->editedon);
    }

    public function getDeletedAtAttribute()
    {
        return $this->convertTimestamp($this->deletedon);
    }

    public function getPubAtAttribute()
    {
        return $this->convertTimestamp($this->pub_date);
    }

    public function getUnPubAtAttribute()
    {
        return $this->convertTimestamp($this->unpub_date);
    }

    public static function getLockedElements()
    {
        return evolutionCMS()->getLockedElements(7);
    }

    public function getIsAlreadyEditAttribute()
    {
        return array_key_exists($this->getKey(), self::getLockedElements());
    }

    public function getAlreadyEditInfoAttribute() :? array
    {
        return $this->isAlreadyEdit ? self::getLockedElements()[$this->getKey()] : null;
    }
}
