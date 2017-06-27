<?php
/**
 * @ide         PhpStorm.
 * @author:     Panex
 * @datetime:   2017-06-27
 * @version:    0.1
 * @function:   输出日志到指定目录
 */

/**
 * Class log
 * 使用方法：
 * 1. 初始化配置：log::init($config); //只需要一次初始化；若需要改变配置，再次调用即可
 * 2. 记录日志： log::record($message);
 */
class log{
	private static $log_file = '';
	private static $debug = false;
	private static $initial = false;

	private function __construct(){
	}

	private function __clone(){
	}

	/**
	 * @param array $config
	 * $config = array(
			'log' => true, //是否输出日志
	 * 		'log_file' => 'logdir/log.txt' //日志文件路径
	 * );
	 */
	public static function init($config = array()){
		self::$debug = $config['log'];
		self::$log_file = $config['log_file'];
		if(empty(self::$log_file)){
			self::$initial = false;
			return;
		}
		$path = pathinfo(self::$log_file);
		if(!is_dir($path['dirname'])){
			mkdir($path['dirname']);
		}
		if(!file_exists(self::$log_file)){
			$handle = fopen(self::$log_file, 'w');
			fclose($handle);
		}
		self::$initial = true;
	}

	public static function record($message = ''){
		if(!self::$initial || !self::$debug){
			return false;
		}

		$time = explode(' ', microtime());
		$time = date('Y-m-d H:i:s', $time[1]).substr(ltrim($time[0],'0'), 0 ,4);
		$message = str_replace("\n", "\n".str_repeat(' ', 24).'| ', $message);
		$log_str = "{$time} | {$message}\n";
		file_put_contents(self::$log_file, $log_str, FILE_APPEND);

		return true;
	}
}