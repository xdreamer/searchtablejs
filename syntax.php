<?php
/**
 * SearchTablejs: Javascript for Searchable table
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Robert Henjes
 * version 0.1 Initial version copied from sortablejs plugin
 */
// must be run within Dokuwiki
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN', DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'syntax.php');

class syntax_plugin_searchtablejs extends DokuWiki_Syntax_Plugin {

  function getInfo(){
    return array(
      'author' => 'Robert Henjes',
      'email'  => 'dokuwiki@rhenjes.de',
      'date'   => '2010-10-22',
      'name'   => 'Searchable javascript',
      'desc'   => 'Add <searchtable>  and </searchtable> around your table.',
      'url'    => 'http://github.com/xdreamer/searchtablejs/',
    );
  }
  function getType() { return 'container';}
  function getPType(){ return 'normal';}
  function getSort() { return 999; }
  
  //Fix compatibility with edittable 
  function getAllowedTypes() {return array('container','formatting','substition');}

  function connectTo($mode) {
    $this->Lexer->addEntryPattern('<searchtable[^>]*>(?=.*?\x3C/searchtable\x3E)',$mode,'plugin_searchtablejs');
  }
  function postConnect() {
    $this->Lexer->addExitPattern('</searchtable>','plugin_searchtablejs');
  }
  function handle($match, $state, $pos, Doku_Handler $handler){

    switch ($state) {
      case DOKU_LEXER_ENTER :
        $match = substr($match,12,-1);
        $match=trim($match);
        $scl="";
        if (strlen($match)>0) {
          $scl=" search$match";
        }
        return array($state, $scl);
        break;
      case DOKU_LEXER_UNMATCHED :
        return array($state, $match);
        break;
      case DOKU_LEXER_EXIT :
        return array($state, "");
        break;
    }
    return array();
  }

  function render($mode, Doku_Renderer $renderer, $data) {
    list($state,$match) = $data;
    if ($mode == 'xhtml'){
      switch ($state) {
        case DOKU_LEXER_ENTER :
          $id = mt_rand();
          $renderer->doc .= '<div class="searchtable'.$match.'" id="'.$id.'">';
          $renderer->doc .= 'Filter: <form class="searchtable" onsubmit="return false;"><input class="searchtable" name="filtertable" onkeyup="searchtable.filterall(this, \''.$id.'\')" type="text"></form>';
          break;
        case DOKU_LEXER_UNMATCHED :
          $renderer->doc .= p_render('xhtml',p_get_instructions($match),$info);
          break;
        case DOKU_LEXER_EXIT :
          $renderer->doc .=  '</div>';
          break;
      }
      return true;
    }
    return false;
  }
}
?>
