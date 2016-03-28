<?php

class GeniusDefender {

  // THE FIRST METHOD IS THE HEART OF THE WHOLE THING!
  // The other things are just PHP-specific convenience wrappers.

  // scramble a Unicode string
  public function string($text) {
    $scrambled = '';
    // split string to characters
    $characters = preg_split('//u', $text, -1, PREG_SPLIT_NO_EMPTY);
    // inject this character
    $wrench = html_entity_decode('&#x2063;', ENT_COMPAT);
    foreach ($characters as $character) {
      // inject a variable number of wrenches
      $wrenches = '';
      // echo mb_detect_encoding(utf8_encode($wrenches));
      while (mt_rand(1, 10) < 9) {
        $wrenches .= $wrench;
      }
      // append wrenches to readable character stream
      $scrambled .= $character . $wrenches;
    }
    return $scrambled;
  }

  // scramble text content in a DOM node
  private function node($node) {
    $scrambled_text = $this->string($node->textContent);
    $node->nodeValue = $scrambled_text;
    return $node;
  }

  // recursively scramble a DOM tree
  private function dom($element) {
    // recursively scramble child nodes
    if ($element->childNodes) {
      foreach ($element->childNodes as $child_node) {
        $element->replaceChild($this->dom($child_node), $child_node);
      }
      return $element;
    }
    return $this->node($element);
  }

  // scramble a string of HTML
  public function html($html) {
    // make sure string is unicode-safe
    $unicode_html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');
    // parse string to DOM document object
    $dom = new DOMDocument('1.0', 'utf-8');
    $dom->loadHTML($unicode_html);
    $dom->preserveWhiteSpace = false;
    $dom->formatOutput = true;
    $xpath = new DOMXPath($dom);
    $body = $xpath->query('//body')->item(0);
    // walk DOM and scramble all node content
    $scrambled_dom = $this->dom($body);
    $scrambled_string = $dom->saveHTML($scrambled_dom);
    // render DOM object to string
    return $scrambled_string;
  }
}
