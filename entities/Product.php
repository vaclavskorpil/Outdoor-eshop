<?php

namespace entities;
use entities\Category;

class Product
{
    private int $id;
    private Category $kategorie;
    private float $cena;
    private string $nazev;
    private string $popis;
    private string $obrazek;
    private float  $dph;
    private array $hodnotyVlastnosti;
}