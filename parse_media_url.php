<?php

/*
 * Media parser implementations
 * 
 *		Add each type of media parser implementation at below section
 */

interface MediaUrlParser {
	public function getName();
	public function getAliasFrom();
	public function getUrl($id);
	public function getThumbUrl($id);
	public function isIdValid($id);
	public function checkUrlFromParsedUrl($parsed_url);
	public function getIdFromParsedUrl($parsed_url);
}

class YoutubeMediaUrlParser implements MediaUrlParser {
	public function getName() {
		return 'youtube';
	}
	
	public function getAliasFrom() {
		return false;
	}

	public function getUrl($id) {
		return '//www.youtube.com/watch?v=' . $id;
	}
	
	public function getThumbUrl($id) {
		return '//i.ytimg.com/vi/' . $id . '/0.jpg';
	}
	
	public function isIdValid($id) {
		return preg_match('/^[0-9a-zA-Z\-_]+$/', $id);
	}
	
	public function checkUrlFromParsedUrl($parsed_url) {
		return strpos($parsed_url['host'], $this->getName()) !== false;
	}

	public function getIdFromParsedUrl($parsed_url) {
		
		if (isset($parsed_url['query'])) {
			$parsed_query = parse_url_query($parsed_url['query']);
			if ($parsed_query !== false) {
				if (isset($parsed_query['v'])) {
					return $parsed_query['v'];
				}
			}
		}
		if (isset($parsed_url['fragment'])) {
			$parsed_query = parse_url_query(substr($parsed_url['fragment'], 1)); // remove ! after #
			if ($parsed_query !== false) {
				if (isset($parsed_query['v'])) {
					return $parsed_query['v'];
				}
			}
		}
		if (isset($parsed_url['path'])) {
			$path_ary = explode('/', $parsed_url['path']);
			if ($path_ary[1] != 'user') {
				return array_shift(explode('&', $path_ary[2]));
			}
		}
		return false;
	}
}

class YoutubeAliasMediaUrlParser implements MediaUrlParser {
	public function getName() {
		return 'youtu.be';
	}
	
	public function getAliasFrom() {
		return 'youtube';
	}

	public function getUrl($id) {
		return '//youtu.be/' . $id;
	}
	
	public function getThumbUrl($id) {
		return '//i.ytimg.com/vi/' . $id . '/0.jpg';
	}
	
	public function isIdValid($id) {
		return preg_match('/^[0-9a-zA-Z\-_]+$/', $id);
	}
	
	public function checkUrlFromParsedUrl($parsed_url) {
		return strpos($parsed_url['host'], $this->getName()) !== false;
	}

	public function getIdFromParsedUrl($parsed_url) {
		
		if (isset($parsed_url['path'])) {
			$path_ary = explode('/', $parsed_url['path']);
			return $path_ary[1];
		}
		return false;
	}
}

class VimeoMediaUrlParser implements MediaUrlParser {
	public function getName() {
		return 'vimeo';
	}
	
	public function getAliasFrom() {
		return false;
	}

	public function getUrl($id) {
		return '//vimeo.com/' . $id;
	}
	
	public function getThumbUrl($id) {
		return false;
	}
	
	public function isIdValid($id) {
		return preg_match('/^[0-9]+$/', $id);
	}
	
	public function checkUrlFromParsedUrl($parsed_url) {
		return strpos($parsed_url['host'], $this->getName()) !== false;
	}

	public function getIdFromParsedUrl($parsed_url) {
		
		if (isset($parsed_url['query'])) {
			$parsed_query = parse_url_query($parsed_url['query']);
			if ($parsed_query !== false) {
				if (isset($parsed_query['clip_vid'])) {
					return $parsed_query['clip_vid'];
				}
			}
		}
		if (isset($parsed_url['path'])) {
			$path_ary = explode('/', $parsed_url['path']);
			return array_pop($path_ary);
		}
		return false;
	}
}

class FacebookMediaUrlParser implements MediaUrlParser {
	public function getName() {
		return 'facebook';
	}
	
	public function getAliasFrom() {
		return false;
	}

	public function getUrl($id) {
		return '//www.facebook.com/video/video.php?v=' . $id;
	}
	
	public function getThumbUrl($id) {
		return '//graph.facebook.com/' . $id . '/picture';
	}
	
	public function isIdValid($id) {
		return preg_match('/^[0-9]+$/', $id);
	}
	
	public function checkUrlFromParsedUrl($parsed_url) {
		return strpos($parsed_url['host'], $this->getName()) !== false;
	}

	public function getIdFromParsedUrl($parsed_url) {
		
		if (isset($parsed_url['query'])) {
			$parsed_query = parse_url_query($parsed_url['query']);
			if ($parsed_query !== false) {
				if (isset($parsed_query['v'])) {
					return $parsed_query['v'];
				}
			}
		}
		if (isset($parsed_url['fragment'])) {
			$parsed_query = parse_url_query(substr($parsed_url['fragment'], 1)); // remove ! after #
			if ($parsed_query !== false) {
				if (isset($parsed_query['v'])) {
					return $parsed_query['v'];
				}
			}
		}
		if (isset($parsed_url['path'])) {
			$path_ary = explode('/', $parsed_url['path']);
			for ($i = 0 ; $i < count($path_ary) ; ++$i) {
				if ($path_ary[$i] == 'v') {
					return $path_ary[$i + 1];
				}
			}
		}
		return false;
	}
}

class PinkbikeMediaUrlParser implements MediaUrlParser {
	public function getName() {
		return 'pinkbike';
	}
	
	public function getAliasFrom() {
		return false;
	}

	public function getUrl($id) {
		return 'http://www.pinkbike.com/video/' . $id;
	}
	
	public function getThumbUrl($id) {
		return false;
	}
	
	public function isIdValid($id) {
		return preg_match('/^[0-9]+$/', $id);
	}
	
	public function checkUrlFromParsedUrl($parsed_url) {
		return strpos($parsed_url['host'], $this->getName()) !== false;
	}

	public function getIdFromParsedUrl($parsed_url) {
		
		if (isset($parsed_url['path'])) {
			$path_ary = explode('/', $parsed_url['path']);
			for ($i = 0 ; $i < count($path_ary) ; ++$i) {
				if ($path_ary[$i] == 'video') {
					return $path_ary[$i + 1];
				}
			}
		}
		return false;
	}
}

class YoukuMediaUrlParser implements MediaUrlParser {
	public function getName() {
		return 'youku';
	}
	
	public function getAliasFrom() {
		return false;
	}

	public function getUrl($id) {
		return 'http://v.youku.com/v_show/id_' . $id . '.html';
	}
	
	public function getThumbUrl($id) {
		return 'http://events.youku.com/global/api/video-thumb.php?vid=' . $id;
	}
	
	public function isIdValid($id) {
		return preg_match('/^[A-Za-z0-9=_]+$/', $id);
	}
	
	public function checkUrlFromParsedUrl($parsed_url) {
		return strpos($parsed_url['host'], $this->getName()) !== false;
	}

	public function getIdFromParsedUrl($parsed_url) {
		
		if (isset($parsed_url['path'])) {
			if (strpos($parsed_url['host'], 'player') === 0) {
				$path_ary = explode('/', $parsed_url['path']);
				return array_pop($path_ary);
			}
			$reg = false;
			if (preg_match('/id_([^\.]+).html/', $parsed_url['path'], $reg) &&
					$reg !== false) {
				return $reg[1];
			}
		}
		return false;
	}
}

class DailymotionMediaUrlParser implements MediaUrlParser {
	public function getName() {
		return 'dailymotion';
	}
	
	public function getAliasFrom() {
		return false;
	}

	public function getUrl($id) {
		return '//www.dailymotion.com/video/' . $id;
	}
	
	public function getThumbUrl($id) {
		return false;
	}
	
	public function isIdValid($id) {
		return preg_match('/^[0-9a-zA-Z]+$/', $id);
	}
	
	public function checkUrlFromParsedUrl($parsed_url) {
		return strpos($parsed_url['host'], $this->getName()) !== false;
	}

	public function getIdFromParsedUrl($parsed_url) {
		
		if (isset($parsed_url['path'])) {
			$path_ary = explode('/', $parsed_url['path']);
			for ($i = 0 ; $i < count($path_ary) ; ++$i) {
				$r = false;
				if ($path_ary[$i] == 'video' &&
						preg_match('/^([^_]+)(_(.*))?/', $path_ary[$i + 1], $r) &&
							$r !== false) {
					return $r[1];
				}
			}
		}
		return false;
	}
}

/*
 * Store all implemented url parsers in to global variables
 */

abstract class MediaUrlParserManager {
	
	private static $_parser_objects_array = false;
	
	public static function initAllParserObjects() {

		if (Self::$_parser_objects_array === false) {
			
			Self::$_parser_objects_array = array();

			foreach (get_declared_classes() as $class_name) {
				if (in_array(MediaUrlParser::Class, class_implements($class_name))) {
					$parser = new $class_name();
					Self::$_parser_objects_array[$parser->getName()] = $parser;
				}
			}
		}
	}
	
	public static function getParser($name) {
		
		if (empty($name) || !array_key_exists($name, Self::$_parser_objects_array)) {
			return false;
		}
		return Self::$_parser_objects_array[$name];
	}
	
	public static function getRealParser($name) {

		if (empty($name) || !array_key_exists($name, Self::$_parser_objects_array)) {
			return false;
		}
		
		$parser = Self::$_parser_objects_array[$name];
		while ($parser->getAliasFrom() !== false) {
			$parser = Self::$_parser_objects_array[$parser->getAliasFrom()];
		}
		return $parser;
	}
	
	public static function getParserFromParsedUrl($parsed_url) {
		
		$media_parser = false;
		foreach (Self::$_parser_objects_array as $host => $parser) {
			if ($parser->checkUrlFromParsedUrl($parsed_url)) {
				$media_parser = $parser;
				break;
			}
		}
		return $media_parser;
	}
}

MediaUrlParserManager::initAllParserObjects();

/*
 * Media info builder
 */

class MediaInfoBuilder {

	/*
	 * public helper functions
	 */
	public static function createInline($service, $id) {
		return (new Self())->setService($service)->setId($id)->create();
	}
	
	public static function createByUrl($url, $parsed_url = false)
	{
		if ($parsed_url === false) {
			$parsed_url = parse_url($url);
		}
		if ($parsed_url === false) {
			return false;
		}

		$media_parser = MediaUrlParserManager::getParserFromParsedUrl($parsed_url);
		if ($media_parser === false) {
			return false;
		}
		
		$id = $media_parser->getIdFromParsedUrl($parsed_url);
		if ($id === false) {
			return false;
		}
		
		$real_parser = MediaUrlParserManager::getRealParser($media_parser->getName());
		
		return (new Self())->setService($real_parser->getName())->setId($id)->create();
	}
	
	/*
	 * private variables
	 */
	private $_service = false;
	private $_id = false;
	
	/*
	 * public functions
	 */
	public function setService($service) {
		$this->_service = $service;
		return $this;
	}
	public function setId($id) {
		$this->_id = $id;
		return $this;
	}
	public function create() {
		$media_parser = MediaUrlParserManager::getParser($this->_service);
		
		if ($media_parser === false ||
				!$media_parser->isIdValid($this->_id)) {
			return false;
		}
		
		return array(
			'service' => $this->_service,
			'id' => $this->_id,
			'url' => $media_parser->getUrl($this->_id),
			'thumb' => $media_parser->getThumbUrl($this->_id)
		);
	}	
}

/* 
 * php function
 */

function parse_media_url($url) {
	return MediaInfoBuilder::createByUrl($url);
}