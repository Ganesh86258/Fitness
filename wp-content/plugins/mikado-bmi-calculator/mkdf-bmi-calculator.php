<?php
/*
Plugin Name: Mikado BMI Calculator
Description: Plugin that adds BMI calculator functionality to our theme
Author: Mikado Themes
Version: 1.0
*/

include_once 'load.php';

use MikadoBmiCalculator\Lib;

Lib\ShortcodeLoader::getInstance()->load();