<?php

    /**
     * Add all stream data from the Twitch.tv JSON API.
     * 
     * @param int $limit - maximum number of streams sorted by number of viewers descending
     */
	function getTwitchStreams( $limit ) {
		//https://github.com/justintv/Twitch-API/blob/master/v3_resources/streams.md
		$url = 'https://api.twitch.tv/kraken/streams?limit=' . $limit; 
		$json = file_get_contents($url);

		if (!$json) {
			return false;
		}

		$data = json_decode($json)->streams;
		$streams = array();
		
		if($data != null) {
			foreach ($data as $key => $stream) {
				$streams[$key]["title"] = $stream->channel->status;
				$streams[$key]["streamer"] = $stream->channel->display_name;
				$streams[$key]["viewers"] = $stream->viewers;
				$streams[$key]["game"] = $stream->game;
				$streams[$key]["url"] = $stream->channel->url;
			}
		}
		return $streams;
	}

	/*
	// Alternative
	function getTwitchStreams() {
		$url = 'http://api.justin.tv/api/stream/list.json?category=gaming';
		
		$json = file_get_contents($url);

		if (!$json) {
			return false;
		}

		$data = json_decode($json);
		$streams = array();
		
		if($data != null) {
			foreach ($data as $key => $stream) {
				$streams[$key]["title"] = $stream->title;
				$streams[$key]["streamer"] = strtoupper( $stream->channel->title );
				$streams[$key]["viewers"] = $stream->channel_count;
				$streams[$key]["game"] = $stream->channel->meta_game;
				$streams[$key]["url"] = $stream->channel->channel_url;
			}
		}
		return $streams;
	}*/


    /**
     * Search streams and add channel stream data from the Twitch.tv JSON API.
     * 
     * @param String $q - stream or game name or a part of it
     * @param int $limit
     */
	function searchStream( $q, $limit ) {
		//https://github.com/justintv/Twitch-API/blob/master/v3_resources/search.md
		$url = 'https://api.twitch.tv/kraken/search/streams?q=' . $q . '&limit=' . $limit; 
		$json = file_get_contents($url);

		if (!$json) {
			return false;
		}

		$data = json_decode($json)->streams;
		$streams = array();
		
		if($data != null) {
			foreach ($data as $key => $stream) {
				$streams[$key]["title"] = $stream->channel->status;
				$streams[$key]["streamer"] = $stream->channel->display_name;
				$streams[$key]["viewers"] = $stream->viewers;
				$streams[$key]["game"] = $stream->game;
				$streams[$key]["url"] = $stream->channel->url;
			}
		}
		return $streams;
	}

    /**
     * Search games and add games data from the Twitch.tv JSON API.
     * 
     * @param String $q - game name or a part of it
     * @param int $limit
     */
	function searchGame( $q, $limit ) {
		//https://github.com/justintv/Twitch-API/blob/master/v3_resources/search.md
		$url = 'https://api.twitch.tv/kraken/search/games?q=' . $q . '&type=suggest&live=true&limit=' . $limit; 
		$json = file_get_contents($url);

		if (!$json) {
			return false;
		}

		$data = json_decode($json)->games;
		$games = array();
		
		if($data != null) {
			foreach ($data as $key => $game) {
				$games[$key]["name"] = $game->name;
				$games[$key]["popularity"] = $game->popularity;
			}
		}
		return $games;
	}

    /**
     * Search games and return game list.
     * 
     */
	function getTwitchGames() {
		//https://github.com/justintv/Twitch-API/blob/master/v3_resources/games.md
		$url = 'https://api.twitch.tv/kraken/games/top?limit=100'; 
		$json = file_get_contents($url);

		if (!$json) {
			return false;
		}

		$data = json_decode($json)->top;
		$games = array();
		
		if($data != null) {
			foreach ($data as $key => $game) {
				$games[$key]["name"] = $game->game->name;
			}
		}
		return $games;
	}
	
    /**
     * functions checks if cover already exists
     * 
     * @param String $game - game name
     */
	function checkCover ( $game ) {

		$game = urlencode( $game );
		$file = 'images/'.$game.'.png';

		if( file_exists( $file)) {
	    	return $file;
		}
		elseif ( downloadCover ( $game ) ) {  
			return $file; 
		}
		else {
			return 'icon.png';
		}
	}

    /**
     * functions checks if cover already exists (twcover only)
     * 
     * @param String $game - game name
     */
	function checkingCovers ( $game ) {

		$game = urlencode( $game );
		$file = 'images/'.$game.'.png';

		if( !file_exists( $file)) {
	    	return downloadCover ( $game );
		}
	}

    /**
     * functions downloads cover from twitch.tv
     * 
     * @param String $game - game name
     */
	function downloadCover ( $game ) {

		$ok = false;
		$url = "http://static-cdn.jtvnw.net/ttv-boxart/" . $game . "-92x128.jpg";
		
		if( urlExists( $url ) ) {
			$temp = "images/". $game .".jpg";
			file_put_contents( $temp, fopen( $url , 'r'));
			$ok = resizeImageAndConvertToPNG( $game );
		 	unlink($temp);
		}

	 	return $ok;
	}

    /**
     * functions checks if url exists
     * 
     * @param String $game - game name
     */
	function urlExists($file) {
		$file_headers = @get_headers($file);
		if($file_headers[0] == 'HTTP/1.1 404 Not Found') {
		    return false;
		}
		else {
		    return true;
		}
	}

    /**
     * functions prepares head data for resizing
     * 
     * @param String $game - game name
     */
	function resizeImageAndConvertToPNG ( $game ) {
		$filepath_old = "images/". $game .".jpg";
		$filepath_converted = "images/".$game.".png";

		$dst = imageCanvasResize($filepath_old, 0, 18, 0, 18);
		imagepng($dst, $filepath_converted);

		return true; 
	 } 

    /**
     * functions resizes the game cover and converts it to png
     * 
     * @param String $game - game name
	 *
	 * image_canvas_resize 0.0 (2010-08-22) found at:	
	 * http://php-resource.de/forum/projekthilfe/100115-image-vergroessern-aber-nicht-skalieren.html
     */
	function imageCanvasResize(
			$src_img, /// rsrc(image) image resource | str(uri:path) path to an image file
			$top = 0, /// int(0...) upper padding in pixels
			$left = 0, /// int(0...) left padding in pixels
			$bottom = 0, /// int(0...) lower padding in pixels
			$right = 0 /// int(0...) right padding in pixels
			) 
	{
		if (!is_resource($src_img)) {
			if (!is_string($src_img) || !is_file($src_img)) {
				// neither a path nor an image resource given
				return FALSE;
			}
			// detect image file type
			if (!preg_match(
				// the "." is only there to make the recognised pattern 7 bytes long
				'/\A(?:\xff\xd8\xff|GIF8[79]a|\x89PNG\x0d\x0a.)/s',
				file_get_contents($src_img, 0, NULL, 0, 7),
				$hits
				)) {
				// unknown image format
				return FALSE;
			}
			static $loaders = array (
				3 => 'imagecreatefromjpeg',
				6 => 'imagecreatefromgif',
				7 => 'imagecreatefrompng',
			);
			if (!isset($loaders[strlen($hits[0])])) {
				return FALSE; // could not detect image file type
			}

			$loaderfunc = $loaders[strlen($hits[0])];
			// load image to resource
			if (!is_resource($src_img = $loaderfunc($src_img))) {
				return FALSE; // could not load image from file
			}
		}

		// 24 bit RGB or 8 bit palette?
		$true_colour = imageistruecolor($src_img);

		// sanitize dimensions
		$top = $top < 0 ? 0 : (int) $top;
		$left = $left < 0 ? 0 : (int) $left;
		$bottom = $bottom < 0 ? 0 : (int) $bottom;
		$right = $right < 0 ? 0 : (int) $right;

		// calculate dimensions for the destination bitmap
		$dst_width = imagesx($src_img) + $left + $right;
		$dst_height = imagesy($src_img) + $top + $bottom;

		// build the destination bitmap
		if (!is_resource(
			$dst_img = $true_colour
			? imagecreatetruecolor($dst_width, $dst_height)
			: imagecreate($dst_width, $dst_height)
			)) {
			return FALSE;
		}

		// sanitize background colour argument
		$black = imagecolorallocate($dst_img, 0, 0, 0);
		$bg_colour = imagecolortransparent($dst_img, $black);

		// fill with background colour
		if (!imagefilledrectangle(
			$dst_img,
			0, 0, $dst_width - 1, $dst_height - 1,
			$bg_colour
			)) {
			return FALSE;
		}

		// copy the source bitmap into the destination bitmap
		if (!imagecopy(
			$dst_img, $src_img,
			$left, $top, // dst_x, dst_y
			0, 0, // src_x, src_y
			imagesx($src_img), imagesy($src_img) // src_w, src_h
			)) {
			return FALSE;
		}
		return $dst_img;
	}

?>