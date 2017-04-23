<?php

class Youtube {


	private $length_id = 11;
	private $youtube_link;


	function __construct($youtube_link = null) {
		$this->set($youtube_link);
	}

	
	public function set($youtube_link) {
		$this->youtube_link = $youtube_link;
	}


	public function valid() {
		return 
			strpos($this->get_part("host"), "youtu.be") !== false ||
			strpos($this->get_part("host"), "youtube.com") !== false ||
			strpos($this->get_part("host"), "youtube-nocookie.com") !== false;
	}


	private function parse() {
		return parse_url($this->youtube_link);
	}


	private function detect_url($url) {
		return strpos($this->get_host(), $url) !== false;
	}


	public function is_embed() {
		return $this->valid() &&
			strpos($this->get_part("path"), "embed") !== false;
	}
	
	
	private function is_short_format() {
		$re = "/\/(e|v)\/[a-zA-Z0-9_-]{11}$/";
		return preg_match($re ,$this->youtube_link);
	}


	private function get_part($part) {
		if (array_key_exists ($part, $this->parse())) {
			return $this->parse()[$part];
		}
		return null;
	}


	public function get_host() {
		return $this->parse()["host"];
	}


	public function get_id() {
		if ($this->valid()) {
			if ($this->detect_url("youtu.be")) {
				return str_replace("/", "", $this->get_part("path"));
			} else if ($this->detect_url("youtube.com") || $this->detect_url("youtube-nocookie.com")) {
				if ($this->is_embed() || $this->is_short_format()) {
					return substr($this->get_part("path"), -$this->length_id);
				} else {
					parse_str($this->get_part("query"), $query);
					return (isset($query["v"]) ? $query["v"] : null);
				}
			}
		}
		return null;
	}


	public function get_time() {
		if ($this->valid()) {
			parse_str($this->get_part("query"), $query);
			parse_str($this->get_part("fragment"), $fragment);
			if (isset($query["t"])) {
				return str_replace("s", "", $query["t"]);
			} else if (isset($fragment["t"])){
				return str_replace("s", "", $fragment["t"]);
			}
		}
		return null;
	}


	public function get_list() {
		if ($this->valid()) {
			parse_str($this->get_part("query"), $query);
			if (isset($query["list"])) {
				return $query["list"];
			}
		}
		return null;
	}


	function __toString() {
		return $this->youtube_link;
	}

}

?>
