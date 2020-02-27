<?php

namespace Dynamic\Elements\Section\Elements;

use DNADesign\Elemental\Models\BaseElement;
use DNADesign\Elemental\Models\ElementalArea;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\ORM\FieldType\DBHTMLText;

/**
 * Class ElementSectionNavigation.
 */
class ElementSectionNavigation extends BaseElement
{
    /**
     * @var string
     */
    private static $icon = 'font-icon-menu';

    /**
     * @var string
     */
    private static $singular_name = 'Section Navigation Element';

    /**
     * @var string
     */
    private static $plural_name = 'Section Navigation Elements';

    /**
     * @var string
     */
    private static $table_name = 'ElementSectionNavigation';

    /**
     * @return null|\Page
     * @throws \SilverStripe\ORM\ValidationException
     */
    public function getPage()
    {
        $area = $this->Parent();
        $page = parent::getPage();

        if ($area instanceof ElementalArea && $area->exists()) {
            if (
                $area->getOwnerPage() instanceof \DNADesign\ElementalList\Model\ElementList &&
                $area->getOwnerPage()->exists()
            ) {
                $page = $area->getOwnerPage()->getPage();
            } else {
                $page = $area->getOwnerPage();
            }
        }

        $this->extend('updatePage', $page);
        return $page;
    }

    /**
     * @return bool|\SilverStripe\ORM\SS_List
     */
    public function getSectionNavigation()
    {
        $children = false;
        if ($page = $this->getPage()) {
            if ($page->Children()->Count() > 0) {
                $children = $page->Children();
            } elseif ($page->Parent()) {
                $children = $page->Parent()->Children();
            }
        }

        $this->extend('updateChildren', $children);
        return $children;
    }

    /**
     * @return DBHTMLText
     */
    public function getSummary()
    {
        if ($this->getPage()) {
            return DBField::create_field(
                'HTMLText',
                'Navigation for ' . $this->getPage()->Title
            )->Summary(20);
        }
        return DBField::create_field('HTMLText', '<p>Section Navigation</p>')->Summary(20);
    }

    /**
     * @return array
     */
    protected function provideBlockSchema()
    {
        $blockSchema = parent::provideBlockSchema();
        $blockSchema['content'] = $this->getSummary();
        return $blockSchema;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Section Navigation');
    }
}
