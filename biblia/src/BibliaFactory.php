<?php

namespace jnplonte\Biblia;

class BibliaFactory
{
    protected $config;

    private $bibleKey;
    private $bibleTag;
    private $bibleDefault;

    private $bibleContent = 'https://api.biblia.com/v1/bible/contents/%bibleTag%?key=%bibleKey%';
    private $bibleVerse = 'http://api.biblia.com/v1/bible/content/%bibleTag%.txt?passage=%biblePassage%&key=%bibleKey%';

    /**
     * @param $config
     */
    public function __construct($config = null)
    {
        $this->config = $config;

        $this->bibleKey = $this->config['bibleKey'];
        $this->bibleTag = $this->config['bibleTag'];
        $this->bibleDefault = $this->config['bibleDefault'];
    }


    public function parseURL($url, $array = null)
    {
        if (!empty($array) && is_array($array)) {
            foreach ($array as $key => $value) {
                $url = str_replace('%'.$key.'%', $value, $url);
            }
        }

        return $url;
    }

    public function urlGetContents($url= null) {
        if(!empty($url)){
          if (!function_exists('curl_init')){
              die('CURL is not installed!');
          }
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $output = curl_exec($ch);
            curl_close($ch);
          return $output;
        }
    }

    public function getData($verse = null)
    {
        if (empty($verse)) {
            $verse = $this->bibleDefault;
        }

        $url = $this->parseURL($this->bibleVerse, array('bibleTag' => $this->bibleTag, 'biblePassage' => urlencode($verse), 'bibleKey' => $this->bibleKey));
        $jsonContent = trim($this->urlGetContents($url));
        if (empty($jsonContent)) {
            $url = $this->parseURL($this->bibleVerse, array('bibleTag' => $this->bibleTag, 'bibleKey' => $this->bibleKey, 'biblePassage' => urlencode($this->bibleDefault)));
            $jsonContent = trim($this->urlGetContents($url));
            $verse = $this->bibleDefault;
        }
        $finalData = array('content' => $jsonContent, 'verse' => $verse);

        return json_encode($finalData);
    }

    public function getVerse($num = null)
    {
        if (empty($num)) {
            $num = rand(1, 50);
        }

        $url = $this->parseURL($this->bibleContent, array('bibleTag' => $this->bibleTag, 'bibleKey' => $this->bibleKey));
        $jsonContent = json_decode($this->urlGetContents($url));

        foreach ($jsonContent->books as $key => $val) {
            foreach ($val->chapters as $k => $v) {
                $fArr[] = $v->passage;
            }
        }
        $finalVerse = $this->getData($fArr[array_rand($fArr)].':'.$num);

        return $finalVerse;
    }
}
