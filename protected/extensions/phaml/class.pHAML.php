<?php
/**
 * A port (sortof) of the HAML system to PHP, for Ruby: http://haml.hamptoncatlin.com
 * Latest Documentation: http://i.cloudi.us/phaml/documentation or
 * phaml.sourceforge.net  Comments are encouraged, send to davmor@sourceforge.net
 * 
 * Copyright (c) 2007, David Moring & Applied Autonomics LLC
 * 
 * Version 0.9 Prerelease
 * 
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:
 * 
 *     * Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.
 *     * Neither the name of the <ORGANIZATION> nor the names of its contributors may be used to endorse or promote products derived from this software without specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR
 * CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL,
 * EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO,
 * PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR
 * PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF
 * LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
 * NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */
class Phaml{
    var $_tabsize=4; //_tabsize for tabs
    var $_allowPHP=true;
    var $_values =  array();
    var $_templates =  array();
    var $_function_path =  array();
    var $_script_path =  '.';
    var $_base_path =  '.';
    var $_filter = array();
    var $_modifiers = array();
    var $_current_func = array();
    var $_id_notes = array();

    //empty constructor
    public function __construct($content=false){
    
    }

    function renderPHP($content){
        ob_start();
        eval('?>'.$content);
        return ob_get_clean();
    }
    
    /**
     * Adds a template for recursive processing
     *
     * @param unknown_type $key key to replace
     * @param unknown_type $template pHAML template
     * @param unknown_type $isStream is a PHP stream
     */
    function addTemplate($key, $template, $isStream=false){
        $this->_templates[$key]['content'] = $template;
        $this->_templates[$key]['isStream'] = $isStream;
    }


    /**
     * Adds a variable to replace
     *
     * @param unknown_type $key
     * @param unknown_type $value
     */
    function assign($key, $value=null){
        if(is_array($key)){
            $this->_values = array_merge($this->_values,$key);
        }else{
            $this->_values[$key]=$value;
        }
    }

    /**
     * Clears template variables
     *
     */
    function clearVars(){
        $this->_values[$key]=array();
    }

    /**
	 * Renders the pHAML code as HTML
	 *
	 * @param unknown_type $content
	 * @return unknown
	 */
    function render($content, $is_stream=false){
        if($is_stream){
            $content = (file_exists($content))? file_get_contents($content):false;
        }
        if(empty($content)) return $content;
        //check to see if we got an array
        $close = $notes = array();  //initialize close tag stack, notes array, compactme stack
        $heredoc = $debug = $showHTML = $compact = false;
        //the magic that makes the whole thing work -- Regex's are powerful stuff....they should only be used for good
        preg_match_all('/(?m)^([ \011]*)(:[\w]*)?(\%[\w]*)?(\.[\w.\-]*)?(#[A-Za-z0-9:-_]*)?(\(!.*!\))?({(.*)})?(\\\\|=|\/\/|\/|!!!!|!!!|<<<|>>>|\/\/<<<|\/\/>>>|---|-|\?\?|\?)?(.*)$/',$content,$lines);
        $last_indent = -1;  //the last indent
        $render = '';  //the rendered code
        for($i=0;$i<count($lines[0]);$i++){
            $text='';
            $current_indent =substr_count($lines[1][$i],' ');  //what is our indent
            $current_indent +=$this->_tabsize * substr_count($lines[1][$i],"\t");  //support tab indents as well, some editors like those
            $current_space  = ($compact)?'': str_repeat(' ',$current_indent) ;
            if($debug){ //create and add the debug info
                $render .=  str_repeat(' ',$current_indent) .'<!-- '. ($i + 1) .':'.(substr_count($lines[1][$i],' ') + $this->_tabsize * substr_count($lines[1][$i],"\t"));
                if(substr_count($lines[1][$i],"\t") > 0 ) $render .='*';
                if(!empty($lines[9][$i]))$render .='{'.$lines[9][$i].'}';
                if($heredoc) $render .='[on]';
                $render .=': '.trim($lines[0][$i]).' -->'."\n"; //notice that we always provide a return, even in compact mode
            }
            if(!$heredoc===false){
                if($lines[9][$i]==='>>>' || $lines[9][$i]==='//>>>'){  //we in heredoc? if so, print the line, keep the indents to make it all pretty
                    $heredoc=false;
                }else{
                    $render .= $lines[0][$i]."\n";
                }
                continue;
            }
            if(trim($lines[0][$i])==='' || $lines[9][$i]==='//') continue;
            if($lines[9][$i]==='?'){
                if(!$debug) $render .=  $current_space .'<!-- Debug on -->'."\n";
                $debug = !$debug;
                if(!$debug) $render .=  $current_space .'<!-- Debug off -->'."\n";
                continue;
            }
            if($lines[9][$i]==='---'){
                $compact = abs($compact-1);
                if($debug) $render .=  $current_space .'<!-- Compact '.(($compact)?'on':'off').' -->'."\n";
                continue;
            }
            //close open tags for this indent level
            for($j=$last_indent;$j >= $current_indent;$j--){
                if(isset($close[$j])){
                    $render .= $close[$j];
                    unset($close[$j]);
                }
            }
            $last_indent = $current_indent;  //update indent
            switch ($lines[9][$i]) { //do the commands
                case '\\':
                    $text = ltrim($lines[10][$i]);
                    break;
                case '??':
                    if($showHTML===false){
                        $showHTML = strlen($render);
                        $offset=false;
                        if(trim($lines[10][$i]) === 'C'){
                            $offset = $current_indent;
                        }else if(trim($lines[10][$i]) !== '') $offset = intval($lines[10][$i]);
                    }else{
                        if($offset) $render = substr($render,0,$showHTML).preg_replace('/(?m)^ {'.$current_indent.'}(.*)$/','$1',substr($render,$showHTML));
                        $render = substr($render,0,$showHTML).htmlspecialchars(substr($render,$showHTML));
                        $showHTML=false;
                    }
                    break;
                case '-':
                    $render .= ($this->_allowPHP)? $current_space .'<?PHP '.trim($lines[10][$i]).' ?>'."\n":'';  //php wrap
                    break;
                case '=':
                    $render .= ($this->_allowPHP)? $current_space .'<?PHP echo '.trim($lines[10][$i]).' ?>'."\n":'';  //php wrap
                    break;
                case '/':
                    $render .=  $current_space .'<!-- '.trim($lines[10][$i]).' -->'."\n";  //handle comments
                    break;
                case '<<<':
                case '//<<<':
                    $heredoc=true;  // heredoc on
                    break;
                case '!!!!':
                    switch (trim($lines[10][$i])) { //this is the HTML4 set
                        case '':
                            $render .= $current_space .'<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">'."\n";
                            break;
                        case 'Transitional':
                            $render .= $current_space .'<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">'."\n";
                            break;
                        case 'Frameset':
                            $render .= $current_space .'<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">'."\n";
                            break;
                        default:
                            $render .=  $current_space .trim($lines[10][$i])."\n";
                            break;
                    }
                    break;
                case '!!!':
                    switch (trim($lines[10][$i])) { //the XHTML set
                        case '':
                            $render .= $current_space .'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'."\n";
                            break;
                        case 'XML':
                            $render .= $current_space .'<?xml version="1.0" encoding="utf-8" ?>'."\n";
                            break;
                        case '1.1':
                            $render .= $current_space .'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">'."\n";
                            break;
                        case 'Strict':
                            $render .= $current_space .'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">'."\n";
                            break;
                        default:
                            $render .= $current_space .trim($lines[10][$i])."\n";
                            break;
                    }
                    break;
                default:
                    $text = ltrim($lines[10][$i]);
            }
            if(!empty($lines[2][$i])){ //command template
                $func = substr($lines[2][$i],1);
                if(isset($this->_function[$func])){
                    //pull the attributes
                    preg_match_all('/(?m)(\w+)\s*=\s*(?(?=[\'"])([\'"])([^\\2]+)\\2|(\S+))/', $lines[8][$i],$attrs);
                    $attr = array();
                    for($k=0;$k<count($attrs[0]);$k++){
                        $attr[$attrs[1][$k]]=$attrs[3][$k].$attrs[4][$k];
                    }
                    if(count(array_diff($this->_function[$func]['required'],array_keys($attr))) === 0){
                        $render.=  $current_space .'<?PHP '. str_replace(array_keys($attr), $attr, $this->_function[$func]['open']).' ?>'."\n";
                        if(!empty($this->_function[$func]['close'])) $close[$current_indent]= $current_space . '<?PHP '. str_replace(array_keys($attr),$attr,$this->_function[$func]['close']).' ?>'."\n";
                    }else{
                        if($debug) $render.='<!-- function '.$func.' missing required values: '.implode(', ',array_diff($this->_function[$func]['required'],array_keys($attr))).' -->'."\n";
                    }
                }else{
                    if($debug) $render.='<!-- function '.$func.' not found -->'."\n";
                }
            }
            //create the element tag with all the goodies
            if(!empty($lines[3][$i])||!empty($lines[4][$i])||!empty($lines[5][$i])||!empty($lines[8][$i]) && empty($lines[2][$i])){
                $attr_arr = array();
                $lines[3][$i] = (empty($lines[3][$i]))?'div':substr($lines[3][$i],1);
                $open = '<'.$lines[3][$i].' ';
                //grok classes
                if(!empty($lines[4][$i]))	$open .= 'class="' . ltrim(str_replace('.',' ',$lines[4][$i])). '" ' ;
                //grab the id
                if(!empty($lines[5][$i])) $open .= 'id="' . substr($lines[5][$i],1).'" ';
                if(!empty($lines[6][$i]))$this->_id_notes[] = array('notes'=>substr(substr($lines[6][$i],2),0,-2),'element'=>$lines[3][$i], 'class'=>$lines[4][$i], 'id'=>substr($lines[5][$i],1),'attributes'=>$lines[8][$i]);
                if(!empty($lines[8][$i])) $open .= $lines[8][$i];
                $render .=  $current_space  . rtrim($open). '>'."\n";
                //preload the close tag into the close stack
                $close[$current_indent] =  $current_space .'</'.$lines[3][$i].'>'."\n";
                //$current_indent +=2; //kick up indent in case there is text following
            }
            //handle non-element stuff
            if(!empty($text)) $render .=  $current_space . $text . "\n";
            
        }
        //empty the close tag stack
        foreach(array_reverse($close, true) as $indent=>$tag){
            $render .= $tag;
        }
        //replace the templates
        preg_match_all('/\[\[([a-zA-Z\x7f-\xff][a-zA-Z0-9_\x7f-\xff]+)\]\]/',$render,$vars);
        for($i=0;$i<count($vars[0]);$i++){ //could put recursion protection here and cut functionality, but you guys aren't script puppies are you???
            if(array_key_exists($vars[1][$i],$this->_templates)) $render = str_replace('[['.$vars[1][$i].']]',$this->render($this->_templates[$vars[1][$i]]['content'], $this->_templates[$vars[1][$i]]['isStream']),$render);
        }
        //now replace the variables
        preg_match_all('/\[\$((this->)?[a-zA-Z\x7f-\xff][a-zA-Z0-9_\x7f-\xff]+)\]/',$render,$vars);
        for($i=0;$i<count($vars[0]);$i++){
            if(array_key_exists($vars[1][$i],$this->_values)){
                $render = str_replace('[$'.$vars[1][$i].']',$this->_values[$vars[1][$i]],$render);
            }else{
                $replace = ($this->_allowPHP)?'<?php echo(isset($'.$vars[1][$i].'))?$'.$vars[1][$i].':\'\'; ?>':'';
                $render =  str_replace('[$'.$vars[1][$i].']',$replace,$render);
            }
        }
        return $render;
    }
}
?>
