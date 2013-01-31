<?php
/*
* @Author: Nurte
* @package www.nurte.pl Nurte Facebook Like Button
* @copyright Copyright (C) 2010 Nurte All rights reserved.
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
* @Version 3.2.0.0
*/
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.event.plugin');

if(!class_exists('ContentHelperRoute')) require_once (JPATH_SITE . '/components/com_content/helpers/route.php');
	
class plgContentFb_like_button extends JPlugin
{
	function plgContentFb_like_button( &$subject)
	{
		parent::__construct( $subject );
		$this->_plugin = JPluginHelper::getPlugin( 'content', 'fb_like_button' );
		$this->_params = new JParameter( $this->_plugin->params );
	}
	
	function onPrepareContent( &$article, &$params )
	{
		$url_to_like		= $this->_params->get('url_to_like', '');
		$send_button		= $this->_params->get('send_button','1');
		$layout_style		= $this->_params->get('layout_style', 'standard');
		$show_faces		= $this->_params->get('show_faces','1');
		$width			= $this->_params->get('width',300);
		$height			= $this->_params->get('height',23);
		$verb_to_display	= $this->_params->get('verb_to_display','like');
		$font			= $this->_params->get('font','arial');
		$color_scheme		= $this->_params->get('color_scheme','light');

		$catids			= $this->_params->get('catids');
		$artids_array		= explode( ';', trim($this->_params->get('artids')));
		$positions		= $this->_params->get('positions');
		$align 			= $this->_params->get('align','right');
		$frontpage		= $this->_params->get('frontpage',0);
		$sectionview		= $this->_params->get('sectionview',0);
		$categoryview		= $this->_params->get('categoryview',0);
		$this->code_type	= $this->_params->get('code_type',0);

		$view = JRequest::getCmd('view'); 
		if(array_key_exists('catid',get_object_vars($article)))
			$this->catId = $article->catid;				
		else	$this->catId = -1; 

		$this->flag	= false;
		$this->flag2 	= true;
	
		$this->flag = $this->checkCatID($catids, $this->catId);

		if ($view == 'frontpage' && $frontpage == 0) 		{ $this->flag = false; $this->flag2 = false; }
		if ($view == 'section' && $sectionview == 0) 		{ $this->flag = false; $this->flag2 = false; }
		if ($view == 'category' && $categoryview == 0) 		{ $this->flag = false; $this->flag2 = false; }
		if ($this->checkArtID($artids_array, $article->id))	$this->flag = false;
			
		$this->placeholder 	= false;
		$this->placeholder2 	= false;
		$this->showbefore 	= false;
		$this->showtop		= false;
		$this->showbottom	= false;
		$this->showafter	= false;

		if ($this->flag || $this->flag2) {
			if($positions){
				if( is_array( $positions ) ) {        
					foreach($positions as $position) { 
						$this->position($position);
					}
				} else {	
					$this->position($positions);
				}	
			}
		
			if(!$url_to_like){	
				$uri	= &JFactory::getURI();
				if( $view == 'frontpage' || $view == 'section' || $view == 'category' || $view == 'article' )
				{ 
					$path = ContentHelperRoute::getArticleRoute($article->id, $this->catId);
					$app    = JApplication::getInstance('site');
					$router = $app->getRouter();
					$rule = $router->_rules['build'];
					$router->_rules['build'] = Array();
					$route = $router->build($path);
					if($uri->base(true))
						$domain = str_replace($uri->base(true).'/','',$uri->base());
					else	$domain = rtrim($uri->base(),'/'); 

					$pos = strpos($route->toString(), $domain);			
					if($pos === false)	
						$path = $domain.$route->toString();
					else
						$path = $route->toString();
	
					if(!function_exists("strripos")){ 
						function strripos(  $haystack, $needle, $offset = 0  ) {
							$needle = strtolower($needle);
						        $temp_cut = strtolower(strrev(  substr( $haystack, $offset, strlen($haystack)  )  ) ); 
	
							if(   (  $found = strpos( $temp_cut, strrev($needle) )  ) === FALSE   ) return FALSE; 
							$pos = strlen($haystack) - $found - strlen($needle);
							return $pos; 
						}/* endfunction strripos */ 
					}/* endfunction exists strripos */

					if($router->getMode() == JROUTER_MODE_SEF 
					   && strripos($path, '/'.$article->id, 0) === (strlen($path) - strlen('/'.$article->id))){
						$path = $path.'-'.$article->alias;
					}

					$router->_rules['build'] = $rule;
				}else{
					$path 	= $uri->toString();
				}
				$path	= str_replace('&amp;', '&', $path);
				$path	= str_replace('&', '&amp;', $path);
			}else 
				$path = $url_to_like;

			$language	= &JFactory::getLanguage();
			$langtag	= 'en-GB';
        		if ($language) {
				$langtag 	= $language->get('tag');
				$lang_prefix	= strpos($langtag, '-') > 0 ? substr($langtag, 0, strpos($langtag, '-')) : $langtag;
				$path 		= str_replace("%26lang=".$lang_prefix , "", $path);
				$path 		= str_replace("?lang=".$lang_prefix , "", $path);
			}

			$this->fblikehtml = $this->fblike($this->code_type, $path, $send_button, $layout_style, $show_faces, $width, $height, $verb_to_display, $font, $color_scheme, $langtag);
		}

		if ($this->flag2) {
			if($this->placeholder2) {
				$article->text = str_replace('{fblike2}', $this->fblikehtml, $article->text);				

				$regex = '/{fblike2 href="*.*"}/iU';
        	       		preg_match_all( $regex, $article->text, $matches );
 
	 		       	$count = count( $matches[0] );
				for($i = 0; $i < $count; $i++) {
				
					$replace = str_replace("{fblike2 href=\"", "", $matches[0][$i] );
					$replace = str_replace('"}', '', $replace );
					$replace = str_replace('&amp;', '&', $replace);
					$replace = str_replace('&', '&amp;', $replace);
					$replace = $this->fblike($this->code_type, $replace, $send_button, $layout_style, $show_faces, $width, $height, $verb_to_display, $font, $color_scheme, $langtag);
	
					$article->text = str_replace($matches[0][$i], $replace, $article->text);			
				}
			} else	$this->fblike_replace($article->text, 'fblike2');
		} else	$this->fblike_replace($article->text, 'fblike2');

		if ($this->flag) {
			if($this->placeholder) {
				$article->text = str_replace('{fblike}', $this->fblikehtml, $article->text);				

				$regex = '/{fblike href="*.*"}/iU';
        	       		preg_match_all( $regex, $article->text, $matches );
 
	 		       	$count = count( $matches[0] );
				for($i = 0; $i < $count; $i++) {
				
					$replace = str_replace("{fblike href=\"", "", $matches[0][$i] );
					$replace = str_replace('"}', '', $replace );
					$replace = str_replace('&amp;', '&', $replace);
					$replace = str_replace('&', '&amp;', $replace);
					$replace = $this->fblike($this->code_type, $replace, $send_button, $layout_style, $show_faces, $width, $height, $verb_to_display, $font, $color_scheme, $langtag);
	
					$article->text = str_replace($matches[0][$i], $replace, $article->text);			
				}
			} else	$this->fblike_replace($article->text, 'fblike');
				
			if ($this->catId != -1){
				$this->fblikehtml = "<p style=\"text-align: ".$align.";\">".$this->fblikehtml."</p>";
				if($this->showtop) 	$article->text = $this->fblikehtml.$article->text; 					
				if($this->showbottom)	$article->text = $article->text.$this->fblikehtml; 					
			}

		} else	$this->fblike_replace($article->text, 'fblike');

	}

	function position($param){
		if($param == 'placeholder')	$this->placeholder 	= true;	
		if($param == 'placeholder2')	$this->placeholder2 	= true;	
		if($param == 'before') 		$this->showbefore 	= true;
		if($param == 'top') 		$this->showtop		= true;
		if($param == 'bottom') 		$this->showbottom	= true;
		if($param == 'after') 		$this->showafter	= true;
	} 

	function checkCatID(&$catids, &$catId){
		if ($catids){     
			if( is_array( $catids ) ) {        
				foreach($catids as $catid) { 
					if( $catid == $catId ) return true;
				}
			} else {	
				if( $catids == $catId ) return true;
			}	
		}
		if ($catId == -1) return true;
	}	

	function checkArtID(&$artids, &$artId){
		if ($artids){     
			if( is_array( $artids ) ) {        
				foreach($artids as $artid) { 
					if( $artid == $artId ) return true;
				}
			} else {	
				if( $artids == $artId ) return true;
			}	
		}
	}	

	function onBeforeDisplayContent(&$article, &$params){
		$result = '';
		if ($this->flag || $this->flag2) {
			if($this->code_type==0){ 
				if ($this->catId == -1) 
					$article->text = "<div id=\"fb-root\"></div>".$article->text;
				else	$result = "<div id=\"fb-root\"></div>";
			}
			$this->setImage($article, $params);
		}
		if ($this->flag) {
			if ($this->catId != -1 && $this->showbefore) $result .= $this->fblikehtml;
		}

		return $result; 
	}

	
	function onAfterDisplayContent(&$article, &$params){
		if ($this->catId != -1 && $this->flag && $this->showafter)	return $this->fblikehtml;
	}

	function fblike($code_type, $path, $send_button, $layout_style, $show_faces, $width, $height, $verb_to_display, $font, $color_scheme, $langtag)
	{
		$result = '';
		$uri	= &JFactory::getURI();
		$scheme = $uri->getScheme();

		if($code_type==1)
		{
			$result = $this->iframe($scheme, $path, $layout_style, $show_faces, $width, $height, $verb_to_display, $font, $color_scheme);
		}else{
			$result = $this->xfbml($scheme, $path, $send_button, $layout_style, $show_faces, $width, $verb_to_display, $font, $color_scheme, str_replace("-","_",$langtag));
		}
		return $result;
	}	

	function fblike_replace(&$article_text, $fbstr){
		$article_text = str_replace("{".$fbstr."}", '', $article_text);

		$regex = '/{'.$fbstr.' href="*.*"}/iU';
 		preg_match_all( $regex, $article_text, $matches );
 
	       	$count = count( $matches[0] );
		for($i = 0; $i < $count; $i++) {
			$article_text = str_replace($matches[0][$i], '', $article_text);			
		}
	}

	function xfbml($scheme, $path, $send_button, $layout_style, $show_faces, $width, $verb_to_display, $font, $color_scheme, $language)
	{
		$send_button = $send_button == 1 ? 'true':'false';		
		$show_faces  = $show_faces == 1 ? 'true':'false';

		$xfbml = '<script src="'.$scheme.'://connect.facebook.net/'.$language.'/all.js#xfbml=1"></script>'
			.'<fb:like href="'.$path.'" send="'.$send_button.'" layout="'.$layout_style.'" show_faces="'.$show_faces.'" width="'.$width.'"'
			.' action="'.$verb_to_display.'" font="'.$font.'" colorscheme="'.$color_scheme.'"></fb:like>';

		return $xfbml;
	}

	function iframe($scheme, $path, $layout_style, $show_faces, $width, $height, $verb_to_display, $font, $color_scheme)
	{
		$show_faces  = $show_faces == 1 ? 'true':'false';
		$path =	str_replace('&', '%26', $path);

		$iframe = "<iframe src=\"".$scheme."://www.facebook.com/plugins/like.php?href=".$path
			 ."&amp;layout=".$layout_style."&amp;show_faces=".$show_faces."&amp;width=".$width
			 ."&amp;action=".$verb_to_display."&amp;font=".$font."&amp;colorscheme=".$color_scheme
			 ."&amp;height=".$height."\" scrolling=\"no\" frameborder=\"0\" style=\"border:none;overflow:hidden;width:"
			 .$width."px;height:".$height."px;\" allowTransparency=\"true\"></iframe>";

		return $iframe;
	}

	function setImage(&$article, &$params){
		$doc = &JFactory::getDocument();
		if( !$this->existOgImage($doc) )
		{	
			$view = JRequest::getVar('view'); 
			$src = '';
			$image_all = $this->_params->get('image_all',0);


			if( $view == 'frontpage' || $view == 'section' || $view == 'category' || $image_all)
			{ 
				$src = $this->_params->get('image_src','');

			}elseif($article->text != ''){

				$previous = libxml_use_internal_errors(true);
				$dom = DOMDocument::loadHTML($article->text);
				libxml_clear_errors();
				libxml_use_internal_errors($previous);
				
				$nodes = $dom->getElementsByTagName('img');

				if($nodes->length > 0){
					$src = $nodes->item(0);
					$src = $src->getAttribute('src');
					if($src) {
						$base = JURI::base();

						if(strpos($src,$base) !== 0) {	
							$base	= rtrim($base,'/');
							$src	= ltrim($src,'/');
							$src	= $base.'/'.$src;
						}
					}
				}

				if($src == ''){
					$src = $this->_params->get('image_src','');
				}
			}

			if($src != ''){
				$tag = trim('<meta property="og:image" content="'.$src.'" />' ); 
				$doc->addCustomTag($tag);
			}
		}		
	}

	function existOgImage($doc){
		if($doc->_custom){
			if( is_array($doc->_custom) ){
				foreach($doc->_custom as $custom) { 
					if(stripos($custom, 'meta property="og:image" content="')) return true;
				}	
			} else return false;
		} else return false;
		return false;
	}
}