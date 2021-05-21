<?php

declare(strict_types=1);

namespace Tests;

use GildedRose\GildedRose;
use GildedRose\Item;
use PHPUnit\Framework\TestCase;

class GildedRoseTest extends TestCase
{
    private $specialProducts = [
        'Aged Brie',
        'Backstage passes to a TAFKAL80ETC concert',
        'Sulfuras, Hand of Ragnaros',
        'Conjured',
    ];


    public function productProvider(): array
    {
        return [
            ['Aged Brie'],
            ['Backstage passes to a TAFKAL80ETC concert'],
            ['Sulfuras, Hand of Ragnaros'],
            ['Conjured'],
            ['Kobold Candles']
        ];
    }

    /**
     * @dataProvider productProvider
     */

    //Проверка имен
    public function testName($name): void
    {
        $items = [new Item($name, rand(0,30), rand(-3, 90))];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();

        foreach ($gildedRose->items as $item) {
            $this->assertNotEquals('Kobold Candles', $item->name, "You No Take Candle!");
        }
    }

    //Проверка качества
    public function testQuality()
    {
        $count = 3;
        for ($i = 0; $i<=$count; $i++) {
            $items[$i] = new Item($this->specialProducts[rand(0, 3)], rand(0,30), rand(-3, 90));
        }
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        foreach ($gildedRose->items as $item) {
            $this->assertFalse($item->quality > 50 && $item->name !== 'Sulfuras, Hand of Ragnaros' || $item->quality < 0);
            $this->assertFalse($item->quality < 0);
        }
    }

    //Проверка Sulfuras, Hand of Ragnaros
    public function testSulfuras() {
        $count = rand(1, 100);
        for ($i = 0; $i<=$count; $i++) {
            $items[$i] = new Item($this->specialProducts[rand(0, 3)], rand(0,30), rand(-3, 90));
        }
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();

        foreach ($gildedRose->items as $item) {
            if ($item->name == 'Sulfuras, Hand of Ragnaros') {
                $this->assertFalse($item->quality !==80 || $item->sell_in !== NULL);
            }
        }
    }

}
