<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//format rupiah
function format_rp($rp)
{
    return number_format($rp, 0, ',', '.' );
  }
