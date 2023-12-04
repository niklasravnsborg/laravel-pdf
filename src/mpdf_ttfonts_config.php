<?php

define('_MPDF_SYSTEM_TTFONTS', config('pdf.custom_font_path'));
$this->fontdata = array_merge($this->fontdata, config('pdf.custom_font_data'));
