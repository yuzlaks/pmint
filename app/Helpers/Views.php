<?php

/*
|--------------------------------------------------------------------------
| Function view
|--------------------------------------------------------------------------
|
| Di file ini semua keperluan view akan dihandle, mulai dari 
| include view, parsing variable ke view dll.
|
*/

function view($target, $data = null)
{
	Template::view($target, $data);
}

class Template
{

	static $blocks = array();
	static $cache_path = 'app/Cache/';
	static $cache_enabled = FALSE;

	static function view($file, $data = null)
	{
		$cached_file = self::cache('resources/views/'.$file.'.php');		

		if(!empty($data)){
            foreach ($data as $key => $value) {
				
				${$key} = $value;

            }
		}

		// extract($data, EXTR_SKIP);

		require $cached_file;
	}

	static function cache($file)
	{
		if (!file_exists(self::$cache_path)) {
			mkdir(self::$cache_path, 0744);
		}
		$cached_file = self::$cache_path . str_replace(array('/', '.html'), array('_', ''), $file);
		if (!self::$cache_enabled || !file_exists($cached_file) || filemtime($cached_file) < filemtime($file)) {
			$code = self::includeFiles($file);
			$code = self::compileCode($code);
			file_put_contents($cached_file, '<?php class_exists(\'' . __CLASS__ . '\') or exit; ?>' . PHP_EOL . $code);
		}
		return $cached_file;
	}

	static function clearCache()
	{
		foreach (glob(self::$cache_path . '*') as $file) {
			unlink($file);
		}
	}

	static function compileCode($code)
	{
		$code = self::compileBlock($code);
		$code = self::compileYield($code);
		$code = self::compileEscapedEchos($code);
		$code = self::compileEchos($code);

		/**Foreach */
		$code = self::compileForeach($code);
		$code = self::compileEndForeach($code);

		/**If */
		$code = self::compileIf($code);
		$code = self::compileElse($code);
		$code = self::compileElseIf($code);
		$code = self::compileEndif($code);
		
		/**Object */
		// $code = self::compileForcedObject($code);
		// $code = self::compileRemoveSymbol($code);

		/** Docs code highlight */
		$code = self::codehighlight($code);

		$code = self::compilePHP($code);
		return $code;
	}

	static function includeFiles($file)
	{

		if (strHas($file, 'layouts')) { 
			$file = "resources/$file.php";
		}

		$code = file_get_contents($file);


		preg_match_all('/!! ?(extends|include) ?\'?(.*?)\'? ?!!/i', $code, $matches, PREG_SET_ORDER);

		foreach ($matches as $value) {
			$code = str_replace($value[0], self::includeFiles($value[2]), $code);
		}
		$code = preg_replace('/!! ?(extends|include) ?\'?(.*?)\'? ?!!/i', '', $code);

		return $code;
	}

	static function compilePHP($code)
	{
		return preg_replace('~\!!\s*(.+?)\s*\!!~is', '<?php $1 ?>', $code);
	}

	static function compileEchos($code)
	{
		return preg_replace('~\{{\s*(.+?)\s*\}}~is', '<?php echo htmlentities($1, ENT_QUOTES, \'UTF-8\') ?>', $code);
	}

	static function codehighlight($code)
	{
		return preg_replace('~\!! code \s*(.+?)\s*\ : \s*(.+?)\s*\!!~is', '<pre><code class="language-$1">$2</code></pre>', $code);
	}

	/**Foreach */
	static function compileForeach($code)
	{
		return preg_replace('/!! ?(foreach) ?\'?(.*?)\'? ?!!/i', '<?php $1$2: ?>', $code);
	}

	static function compileEndForeach($code)
	{
		return preg_replace('/!! ?(endforeach) ?!!/i', '<?php endforeach; ?>', $code);
	}
	
	/**If */
	static function compileIf($code)
	{
		return preg_replace('/!! ?(if) ?\'?(.*?)\'? ?!!/i', '<?php $1$2: ?>', $code);
	}

	static function compileElse($code)
	{
		return preg_replace('/!! ?(else) ?!!/i', '<?php else: ?>', $code);
	}

	static function compileElseIf($code)
	{
		return preg_replace('/!! ?(elseif)\'?(.*?)\'? ?!!/i', '<?php $1$2: ?>', $code);
	}

	static function compileEndIf($code)
	{
		return preg_replace('/!! ?(endif) ?!!/i', '<?php $1; ?>', $code);
	}
	
	/**Forced Object */
	static function compileForcedObject($code)
	{
		return preg_replace('/-> ?(.*?)\'?(.*?)\'? /', "['$2']", $code);
	}

	static function compileRemoveSymbol($code)
	{
		return str_replace(")']","'])",$code);
	}
	

	static function compileEscapedEchos($code)
	{
		return preg_replace('~\{%{\s*(.+?)\s*\%}}~is', '<?php echo htmlentities($1, ENT_QUOTES, \'UTF-8\') ?>', $code);
	}

	static function compileBlock($code)
	{
		preg_match_all('/!! ?block ?(.*?) ?!!(.*?)!! ?endblock ?!!/is', $code, $matches, PREG_SET_ORDER);
		foreach ($matches as $value) {
			if (!array_key_exists($value[1], self::$blocks)) self::$blocks[$value[1]] = '';
			if (strpos($value[2], '@parent') === false) {
				self::$blocks[$value[1]] = $value[2];
			} else {
				self::$blocks[$value[1]] = str_replace('@parent', self::$blocks[$value[1]], $value[2]);
			}
			$code = str_replace($value[0], '', $code);
		}
		return $code;
	}

	static function compileYield($code)
	{
		foreach (self::$blocks as $block => $value) {
			$code = preg_replace('/!! ?yield ?' . $block . ' ?!!/', $value, $code);
		}
		$code = preg_replace('/!! ?yield ?(.*?) ?!!/i', '', $code);
		return $code;
	}
}