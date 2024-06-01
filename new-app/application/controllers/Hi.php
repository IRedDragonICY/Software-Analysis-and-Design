<?php

class Hi extends CI_Controller
{


	public function index()
	{
		function angka_pembulatan($angka, $digit, $minimal)
		{
			$digitvalue = substr($angka, - ($digit));
			$bulat = 0;
			$nolnol = "";
			for ($i = 1; $i <= $digit; $i++) {
				$nolnol .= "0";
			}
			if ($digitvalue < $minimal && $digit != $nolnol) {
				$x1 = $minimal - $digitvalue;
				$bulat = $angka + $x1;
			} else {
				$bulat = $angka;
			}
			return $bulat;
		}

		function pembulatan($uang)
		{
			$ratusan = substr($uang, -3);
			if ($ratusan < 500) {
				$akhir = $uang -  $ratusan;
			} else if ($ratusan = 500) {
				$akhir = $uang;
			} else {
				$akhir = $uang + (1000 - $ratusan);
			}

			return $akhir;
		}

		function ketiga($uang)
		{
			$ratusan = substr($uang, 3);
			if ($ratusan < 500) {
				$akhir = $uang + (500 - $ratusan);
			} else if ($ratusan = 500) {
				$akhir = $uang + (500 - $ratusan);
			} else {
				$akhir = $uang + (1000 - $ratusan);
			}

			return $akhir;
		}

		$harga = 222500;

		$bulat = angka_pembulatan($harga, 2, 100);
		$fix = pembulatan($bulat);
		$fixnya = ketiga($bulat);

		echo number_format($harga) . '<br/>';
		echo number_format($bulat) . '<br/>';
		echo number_format($fixnya) . '<br/>';
	}
}
