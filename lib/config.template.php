<?php
class Config {
  public static $base = 'https://chat.indieweb.org/';
  public static $logpath = './data/freenode/';

  public static $dbhost = '127.0.0.1';
  public static $dbname = 'logs';
  public static $dbuser = 'root';
  public static $dbpass = '';

  public static $secret = '';

  public static $slack_token = 'xoxp-...';
  public static $slack_hook = 'https://hooks.slack.com/services/XXX/XXX/XXX';

  public static function supported_channels() {
    return ['indieweb','dev','social','microformats','bridgy','known'];
  }

  public static function related_channels($channel) {
    switch($channel) {
      case '#social':
        return ['social'];
      default:
        return ['indieweb','dev','microformats','bridgy','known'];
    }
  }

  public static function base_url_for_channel($channel) {
    if($channel == '#indiewebcamp' || $channel == '#indieweb')
      return Config::$base;
    else
      return Config::$base . trim($channel,'#') . '/';
  }

  public static function irc_channel_for_slug($slug, $ts=false) {
    if($ts && $ts < 1467691260000000 && $slug == 'indieweb')
      return '#indiewebcamp';

  	switch($slug) {
  	  case 'indieweb':
  	  case '':
  	    return '#indieweb';
  	  case 'dev':
  	    return '#indieweb-dev';
  	  case 'known':
  	    return '#knownchat';
  	  default:
  	    return '#'.$slug;
  	}
  }

  public static function logo_for_channel($channel) {
    switch($channel) {
      case '#indieweb':
      case '#dev':
        return 'indieweb.png';
      case '#bridgy':
        return 'bridgy.png';
      case '#known':
        return 'known.png';
      case '#microformats':
        return 'microformats.png';
      case '#social':
        return 'w3c.png';
      default:
        return false;
    }
  }

  public static function logpath_for_channel($channel) {
    switch($channel) {
      case '#indieweb':
        return 'freenode/#indieweb';
      case '#indieweb-chat':
        return 'freenode/#indieweb-chat';
      case '#dev':
        return '#dev';
      case '#bridgy':
        return 'freenode/#bridgy';
      case '#known':
        return 'freenode/#knownchat';
      case '#microformats':
        return 'freenode/#microformats';
      case '#social':
        return 'w3c/#social';
      default:
        return false;
    }
  }

  public static function slack_channel_for_irc_channel($channel) {
    switch($channel) {
      case '#indieweb':
        return '#indieweb';
      case '#indieweb-dev':
        return '#dev';
      case '#bridgy':
        return '#bridgy';
      case '#knownchat':
        return '#known';
      case '#indieweb-chat':
        return '#chat';
      case '#microformats':
        return '#microformats';
      default:
        return false;
    }
  }

  public static function slack_message_replacements($msg) {
    $msg = preg_replace(array('/\x03\d{1,2}/','/\x03/'), '', $msg);
    $msg = preg_replace(
      array('/(\s)(\/[^ >]+)/i','/\[\[([^\]]+)\]\]/'), 
      array('$1<https://indieweb.org$2|$2>','[[<https://indieweb.org/$1|$1>]]'), $msg);

    // Convert mentions of slack usernames "[aaronpk]" to slack format "@aaronpk"
    $msg = preg_replace('/\[([a-zA-Z0-9_-]+)\]/', '@$1', $msg);
    // Except a few
    $msg = preg_replace('/^@(mention|bridgy|indienews|indieweb)/', '[$1]', $msg);

    return $msg;
  }
  
  public static function wiki_base($channel) {
    switch($channel) {
      case '#indieweb':
      case '#indiewebcamp':
      case '#indieweb-dev':
        return 'https://indieweb.org/';
      case '#microformats':
        return 'http://microformats.org/wiki/';
      default:
        return false;
    }
  }

}
