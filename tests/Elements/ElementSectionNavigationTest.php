<?php

namespace Dynamic\Elements\Section\Tests;

use DNADesign\Elemental\Models\ElementalArea;
use Dynamic\Base\Test\TestBlogPost;
use Dynamic\Elements\Section\Elements\ElementSectionNavigation;
use Dynamic\Elements\Section\Test\TestPage;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Dev\Debug;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\ORM\FieldType\DBField;

/**
 * Class ElementSectionNavigationTest.
 */
class ElementSectionNavigationTest extends SapphireTest
{
    /**
     * @var string
     */
    protected static $fixture_file = '../fixtures.yml';

    /**
     * Tests getSectionNavigation().
     */
    public function testGetSectionNavigation()
    {
        $nav = $this->objFromFixture(ElementSectionNavigation::class, "one");
        $this->assertFalse($nav->getSectionNavigation());
    }

    /**
     *
     */
    public function testGetSummary()
    {
        $object = $this->objFromFixture(ElementSectionNavigation::class, "one");
        $expected = DBField::create_field('HTMLText', '<p>Section Navigation</p>')->Summary(20);
        $this->assertEquals($object->getSummary(), $expected);
    }

    /**
     *
     */
    public function testGetType()
    {
        $object = $this->objFromFixture(ElementSectionNavigation::class, "one");
        $this->assertEquals($object->getType(), 'Section Navigation');
    }
}
