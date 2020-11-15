<?php

namespace entities;
class OrderedProduct
{
    private int $id;
    private int $id_product;
    private string $name;
    private float $price;
    private int $amount;
    private float $tax;
    private int $id_order;
}