<?php

class FGTA_Otomation
{
	function GetNumberOfProcess($current, $total, $digitlen)
	{
		return "[".str_pad($current, $digitlen, ' ', STR_PAD_LEFT). "] of [" . str_pad($total, $digitlen, ' ', STR_PAD_LEFT) . "]";
	}
	
}
