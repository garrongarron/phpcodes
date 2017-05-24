<?php
namespace Parser;
use Viewer\Viewer;
class Parser
{
	static private $collector = [];
	static private $view;
	static public function make($view, $vars = array()){
		self::run($view, $vars = array());

		$names = array_keys(self::$collector);
// 		[2,1,0]
		for ($i = 0; $i < count($names); $i++) {
			$current = self::$collector[$names[$i]];
			if(isset($current['parent'])){
				$origin = explode("\n",self::$collector[$current['parent']]['origin']);
				foreach ($origin as $line){
					self::getYield($line, $current);
				}
			}
		}
// 		[0,1,2]
		for ($i = count($names); $i > 0; $i--) {
			$current = self::$collector[$names[$i-1]];
			if(isset($current['parent'])){
				foreach ($current['section']['stop'] as $key => $section){
					if(isset(self::$collector[$current['parent']]['section']['show'][$key])){
						$search = implode("\n", self::$collector[$current['parent']]['section']['show'][$key]);
						$replace = implode("\n", $section);
						$replace = str_replace('@parent', $search, $replace);
						self::$collector[$names[$i-1]]['section']['stop'][$key] = explode("\n", $replace);
					}
					if(isset(self::$collector[$current['parent']]['section']['stop'][$key])){
						$search = implode("\n", self::$collector[$current['parent']]['section']['stop'][$key]);
						$replace = implode("\n", $section);
						$replace = str_replace('@parent', $search, $replace);
						self::$collector[$names[$i-1]]['section']['stop'][$key] = explode("\n", $replace);
					}
				}
			}
		}
		
// 		[2,1,0]
		for ($i = 0; $i < count($names); $i++) {
			$current = self::$collector[$names[$i]];
			if(isset($current['parent'])){
				foreach ($current['section']['stop'] as $key => $section){
					self::$collector[$current['parent']]['section-new'][$key] = $section;
					if(isset(self::$collector[$current['parent']]['section']['show'][$key])){
						$search = implode("\n", self::$collector[$current['parent']]['section']['show'][$key]);
						$replace = implode("\n", $section);
						$subject = self::$collector[$current['parent']]['origin'];
						$string = str_replace($search, $replace, $subject);
						self::$collector[$current['parent']]['origin']= $string;
						
						self::$collector[$current['parent']]['section']['show'][$key] =
						self::$collector[$current['parent']]['section-new'][$key];
					}
					if(isset(self::$collector[$current['parent']]['section']['stop'][$key])){
						$search = implode("\n", self::$collector[$current['parent']]['section']['stop'][$key]);
						$replace = implode("\n", $section);
						$subject = self::$collector[$current['parent']]['origin'];
						$string = str_replace($search, $replace, $subject);
						self::$collector[$current['parent']]['origin']= $string;
						
						self::$collector[$current['parent']]['section']['stop'][$key] =
						self::$collector[$current['parent']]['section-new'][$key];
					}
					
					$origin = explode("\n",self::$collector[$current['parent']]['origin']);
					$out = [];
					foreach ($origin as $line){
						$conditions = array(
								strpos($line, '@section')>-1,
								strpos($line, '@stop')>-1,
								strpos($line, '@show')>-1
						);
						if(in_array(true, $conditions)){
							continue;
						}
						$out[] = $line;
					}
					self::$collector[$current['parent']]['origin'] = implode("\n",$out);
				}
			}
		}
		return self::getYield2($names[count($names)-1]);
	}
	
	static private function getYield($line, $current){
		if(strpos($line, '@yield(')>-1){
			$section = self::getBetwing($line, '@yield(', ')');
			$section = trim(trim($section), "''");
			if(isset($current['section']['stop'][$section])){
				$start = strpos($line, '@yield(');
				$end = strpos($line, ')');
				$search = substr($line, $start, $end-$start+1);
				$replace = implode("\n", $current['section']['stop'][$section]);
				if(isset(self::$collector[$current['parent']]['section']['stop'])){
					$stop = self::$collector[$current['parent']]['section']['stop'];
					foreach ($stop as $k => $section){
						foreach ($section as $k0 => $data){
							if($data == $line){
								self::$collector[$current['parent']]
								['section']['stop'][$k][$k0] = $replace;
							}
						}
					}
				}					
			}
		}
	}
	
	static private function getYield2($string){
		$str = explode("\n", self::$collector[$string]['origin']);
		$s = $str;
		foreach ($str as $line){
			
			if(strpos($line, '@yield(')>-1){
				$section = self::getBetwing($line, '@yield(', ')');
				$section = trim(trim($section), "''");
				$start = strpos($line, '@yield(');
				$end = strpos($line, ')');
				$search = substr($line, $start, $end-$start+1);
				if(isset(self::$collector[$string]['section-new'])&&
					isset(self::$collector[$string]['section-new'][$section])){
					$replace = implode("\n", self::$collector[$string]['section-new'][$section]);
					$str = str_replace($search, $replace, $str);
				}
			}
		}
		return implode("\n", $str);
	}
	
	static private function run($view, $vars = array()){
		self::$view = $view;
		$str = Viewer::show($view, $vars);
		self::$collector[$view]['origin'] = $str;
		
		$template = self::parser($str);
		if(isset($template['parent'])){
			self::run($template['parent']);
		}
		return self::$collector;
	}
	
	static public function getBetwing($string, $start, $end){
		if(strpos($string, $start)>-1){
			$begin = strpos($string, $start)+strlen($start);
			$str = substr($string, $begin,  strpos($string, $end)-$begin);
			return trim(trim($str), "''");
		}
		return '';
	}
	
	static public function parser($str){
		self::setSecction($str);
		$vars = [];
		$strTmp1 = Parser::getBetwing($str, '@extend(', ')');
		$padre = trim(trim($strTmp1), "''");
		if(!empty($padre)){
			$vars['parent'] = $padre;
			self::$collector[self::$view]['parent'] = $padre;
		}
		return $vars;
	}
	
	static private function setSecction($str){
		$flag = false;
		$name = false;
		$lastSection = '';
		foreach (explode("\n", $str) as $line){
			$sectionName = self::getSectionName($line);
			if($sectionName!==false){
				$name = $sectionName;
				self::$collector[self::$view]['section']['tmp'][$name] = [];
				$flag = true;
				$lastSection = $line;
				continue;
			}
			if(self::isSectionClosing($line)== '@show'){
				$str = str_replace($line."\n", '', $str);
				$flag = false;
				$sectionName = false;
				self::$collector[self::$view]['section']['show'][$name] = 
				self::$collector[self::$view]['section']['tmp'][$name];
				unset(self::$collector[self::$view]['section']['tmp'][$name]); 
				$str = str_replace($lastSection."\n", '', $str);
				continue;
			}

			if($flag){
				array_push( self::$collector[self::$view]['section']['tmp'][$name], $line);
			}
		}
		unset(self::$collector[self::$view]['section']['tmp']);
		self::setSecctionStop($str);
	}
	
	static private function setSecctionStop($str){
		$flag = false;
		$name = false;
		foreach (explode("\n", $str) as $line){
			$sectionName = self::getSectionName($line);
			if($sectionName!==false){
				$name = $sectionName;
				self::$collector[self::$view]['section']['stop'][$name] = [];
				$flag = true;
				continue;
			}
			if(self::isSectionClosing($line)== '@stop'){
				$flag = false;
				$sectionName = false;
				continue;
			}
			if($flag){
				array_push( self::$collector[self::$view]['section']['stop'][$name], $line);
			}
		}
	}
	
	
	static private function getSectionName($line){
		$strTmp1 = Parser::getBetwing($line, '@section(', ')');
		$padre = trim(trim($strTmp1), "''");
		if(!empty($padre))
			return $padre;
		else
			return false;
	}
	
	static private function isSectionClosing($line){
		if(strpos($line, '@stop')>-1){
			return '@stop';
		}
		if(strpos($line, '@show')>-1 ){
			return '@show';
		}
		return false;
	}
	
}