<?php
namespace chobie;

class VersionSorter
{
	private static function scan_state_get($c)
	{
		$c = (string)$c;
		if (ctype_digit($c)) {
			return 0;
		} else if (ctype_alpha($c)) {
			return 1;
		} else {
			return 2;
		}
	}

	private static function parse_version_word($vsi)
	{
		$start = $end = $size =0;
		$max = strlen($vsi);
		$res = array();
		while($start < $max) {
			$current_state = self::scan_state_get($vsi[$start]);
			if ($current_state == 2) {
				$start++;
				$end = $start;
				continue;
			}
				
			do {
				$end++;
				$next_char = @$vsi[$end];
				$next_state = self::scan_state_get($next_char);
			} while($current_state == $next_state);
			$size = $end - $start;
			$res[] = substr($vsi,$start,$size);
				
			$start = $end;
		}
		return $res;
	}

	public static function compare_by_version($a, $b)
	{
		return strcmp($a,$b);
	}


	public static function sort($array)
	{
		$widest = 0;
		$result = array();
		foreach($array as $item) {
			$vsi = self::parse_version_word($item);
			foreach($vsi as $it) {
				$tmp = strlen($it);
				if($widest < $tmp) {
					$widest = $tmp;
				}
			}
			$result[$item] =$vsi;
		}

		$normalized = array();
		foreach($result as $key => $item) {
			foreach($item as $b) {
				$length = strlen($b);
				if(ctype_digit((string)$b[0])) {
					for($i=0;$i<$widest - $length;$i++) {
						@$normalized[$key] .= ' ';
					}
				}
				@$normalized[$key] .= $b;
				if(ctype_alpha((string)$b[0])) {
					for($i=0;$i<$widest - $length;$i++) {
						@$normalized[$key] .= ' ';
					}
				}

			}
		}
		asort($normalized);
		return array_keys($normalized);
	}

	public static function rsort($array)
	{
		$widest = 0;
		$result = array();
		foreach($array as $item) {
			$vsi = self::parse_version_word($item);
			foreach($vsi as $it) {
				$tmp = strlen($it);
				if($widest < $tmp) {
					$widest = $tmp;
				}
			}
			$result[$item] =$vsi;
		}

		$normalized = array();
		foreach($result as $key => $item) {
			foreach($item as $b) {
				$length = strlen($b);
				if(ctype_digit((string)$b[0])) {
					for($i=0;$i<$widest - $length;$i++) {
						@$normalized[$key] .= ' ';
					}
				}
				@$normalized[$key] .= $b;
				if(ctype_alpha((string)$b[0])) {
					for($i=0;$i<$widest - $length;$i++) {
						@$normalized[$key] .= ' ';
					}
				}

			}
		}
		arsort($normalized);
		return array_keys($normalized);
	}
}
