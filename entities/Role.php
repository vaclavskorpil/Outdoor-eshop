<?php


namespace entities;


abstract class Role
{
    const user = "user";
    const admin = "admin";
    const values = array(1 => self::user, 2 => self::admin);
}