<?php

use Illuminate\Support\Facades\Config;
define('_MPDF_SYSTEM_TTFONTS', Config::get('pdf.custom_font_path'));
$this->fontdata = array_merge($this->fontdata, Config::get('pdf.custom_font_data'));
