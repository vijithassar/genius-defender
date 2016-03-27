<?php

class GeniusDefender {

  // THE FIRST METHOD IS THE HEART OF THE WHOLE THING!
  // The other things are just PHP-specific convenience wrappers.

  // obfuscate a unicode string
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

  // obfuscate a DOM node object
  public function element($node) {
    // look up tag name
    $tag = $node->parentNode->tagName;
    if ($tag) {
      // scramble text and return wrapped in tags
      $scrambled_text = $this->string($node->textContent);
      return "<$tag>$scrambled_text</$tag>";
    }
  }

  // recursively obfuscate a DOM document object
  public function dom($dom) {
    $results = '';
    foreach ($dom->childNodes as $node) {
      if ($node->hasChildNodes()) {
        // recursion
        $this->dom($node);
      } else {
        // obfuscate
        $result = $this->element($node);
        $results .= $result;
      }
    }
    echo $results;
    return $results;
  }

  // obfuscate a string of HTML
  public function html($html) {
    // parse string to DOM document object
    $dom = new DOMDocument('1.0', 'utf-8');
    $dom->preserveWhiteSpace = false;
    $dom->loadHTML($html);
    // scramble
    return $this->dom($dom);
  }
}
