<?php

declare(strict_types=1);

namespace Tests;

use GildedRose\GildedRose;
use GildedRose\Item;
use PHPUnit\Framework\TestCase;

//class GildedRoseTest extends TestCase
class GildedRoseTest extends TestCase
{
    public function testFoo(): void
    {

        $items = [ 0 => new Item('Conjured', 0, 10)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
//        var_dump($items);
        $this->assertNotSame('fixme', $items[0]->name);
        var_dump($gildedRose);
    }
}
