# Genius Defender

This is a small text processing tool for PHP which renders text unreadable to [Genius.com](http://genius.com) web annotations. It works by randomly adding invisible characters that confuse computers but can't be seen by humans. The original text is not modified.

# WordPress

The included [wp-genius-defender.php](./wp-genius-defender.php) file allows WordPress to load this tool in the form of a plugin; just upload the contents of this directory to your wp-content/plugins/ folder. The plugin will scramble the text in the content body whenever a single post or page is viewed, but it will not do anything to indexes, archives, and feeds. If you aren't using WordPress, feel free to delete this file.

# Very Important Questions

Please review the extensive [release notes](http://www.vijithassar.com/2461/how-to-break-genius-annotations).

# Usage

```php
// include the tool
require_once('genius-defender.php');

// create a new text scrambler
$scrambler = new GeniusDefender;

// scramble a string that contains only Unicode text
$scrambled_text = $scrambler->string($text_content);

// scramble a string that contains HTML tags which you'd like to preserve
$scrambled_html = $scrambler->html($html_content);
```

# Requirements

- PHP 5.3.6 or higher

# Notes

- Code execution is reasonably fast, but your pages will take longer to load because of all the extra characters being added. This tool completely breaks at around a million words, but is totally usable for anything under a few thousand.

- The html() method may pad whitespace characters like spaces and newlines if they occur in between HTML tags. If this is a problem, you'll need to make sure the HTML string being scrambled doesn't include whitespace between adjacent tags, such as line breaks separating paragraphs and divs.
