<?php

declare(strict_types=1);

namespace GildedRose;


final class GildedRose
{
    private $items;

    //Массив необычных товаров. Ключ - название товара, значение - название функции ведущей просчет.
    private $specialProducts = [
        'Aged Brie' => 'brieUpdate',
        'Backstage passes to a TAFKAL80ETC concert' => 'passUpdate',
        'Sulfuras, Hand of Ragnaros' => 'sulfarusUpdate',
        'Conjured' => 'conjuredUpdate'
    ];


    public function __construct(array $items)
    {
        $this->items = $items;
    }

    public function updateQuality(): void
    {
        foreach ($this->items as $item) {
            $item->sell_in -= 1;
            if (array_key_exists($item->name, $this->specialProducts)) {
                //Вызов функции соответсвующей названию товара
                call_user_func(__NAMESPACE__ . '\GildedRose::' . $this->specialProducts[$item->name], $item);
            } else {
                $this->usualUpdate($item);
            }
        }
    }

    public function conjuredUpdate(Item $item): void {
        $this->usualUpdate($item);
        $this->usualUpdate($item);
    }

    public function passUpdate(Item $item): void {
        $item->quality += 1;
        if ($item->sell_in < 11) {
            $item->quality += 1;
        }
        if ($item->sell_in < 6) {
            $item->quality += 1;
        }

        if ($item->sell_in < 0 ) {
            $item->quality = 0;
        }
        $this->qualityValidation($item);
    }

    public function sulfarusUpdate(Item $item): void {
        $item->quality = 80;
        $item->sell_in = NULL;
    }
    public function brieUpdate(Item $item): void {
        //допустим, при поступлении Aged Brie его sell_in = 0
        $item->quality = abs($item->sell_in) * 1.2;
        $this->qualityValidation($item);
    }

    //просчет для обычных товаров
    public function usualUpdate(Item $item): void {
        if ($item->quality > 0 ) {
            if ($item->sell_in > 0 ) {
                $item->quality -= 1;
            } else {
                $item->quality -=2;
            }
            $this->qualityValidation($item);
        }
    }

    //проверка значения качества
    public function qualityValidation(Item $item): void {
        if ($item->quality < 0) {
            $item->quality = 0;
        }
        if ($item->quality > 50) {
            $item->quality = 50;
        }
    }
}
