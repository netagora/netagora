<?php

namespace ECE\Bundle\NetagoraBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

class Publication
{
    const TWITTER = 'twitter';

    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var User $user
     */
    private $user;

    /**
     * @var KnownLink $knownLink
     */
    private $knownLink;

    /**
     * @var string $socialNetwork
     */
    private $socialNetwork;

    /**
     * @var string $author
     */
    private $author;
    
    /**
     * @var string $authorPicture
     */
    private $authorPicture;

    /**
     * @var datetime $publishedAt
     */
    private $publishedAt;

    /**
     * @var string $reference
     */
    private $reference;

    /**
     * @var text $content
     */
    private $content;

    /**
     * @var string $link_url
     */
    private $linkUrl;

    /**
     * @var Boolean $isFavorite
     */
    private $isFavorite;

    public function __construct()
    {
        $this->isFavorite = false;
    }

    public function getCategory()
    {
        if ($this->knownLink) {
            return $this->knownLink->getCategory();
        }
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set user
     *
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get user
     *
     * @return User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set known_link
     *
     * @param KnownLink $knownLink
     */
    public function setKnownLink(KnownLink $knownLink)
    {
        $this->knownLink = $knownLink;
    }

    /**
     * Get known_link
     *
     * @return KnownLink 
     */
    public function getKnownLink()
    {
        return $this->knownLink;
    }

    /**
     * Set network
     *
     * @param string $network
     */
    public function setSocialNetwork($network)
    {
        $this->socialNetwork = $network;
    }

    /**
     * Get network
     *
     * @return string 
     */
    public function getSocialNetwork()
    {
        return $this->socialNetwork;
    }

    /**
     * Set author
     *
     * @param string $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * Get author
     *
     * @return string 
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set authorPicture
     *
     * @param string $authorPicture
     */
    public function setAuthorPicture($authorPicture)
    {
        $this->authorPicture = $authorPicture;
    }

    /**
     * Get authorPicture
     *
     * @return string 
     */
    public function getAuthorPicture()
    {
        return $this->authorPicture;
    }

    /**
     * Set publishedAt
     *
     * @param datetime $publishedAt
     */
    public function setPublishedAt(\DateTime $date)
    {
        $this->publishedAt = $date;
    }

    /**
     * Get publishedAt
     *
     * @return datetime 
     */
    public function getPublishedAt()
    {
        return $this->publishedAt;
    }

    /**
     * Set reference
     *
     * @param string $reference
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
    }

    /**
     * Get reference
     *
     * @return string 
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set content
     *
     * @param text $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * Get content
     *
     * @return text 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set link_url
     *
     * @param string $linkUrl
     */
    public function setLinkUrl($linkUrl)
    {
        $this->linkUrl = $linkUrl;
    }

    /**
     * Get link_url
     *
     * @return string 
     */
    public function getLinkUrl()
    {
        return $this->linkUrl;
    }

    public function setIsFavorite($favorite)
    {
        $this->isFavorite = (Boolean) $favorite;
    }

    public function getIsFavorite()
    {
        return $this->isFavorite;
    }

    public function isFavorite()
    {
        return $this->isFavorite;
    }

    public function changeFavoriteStatus()
    {
        $this->isFavorite = !$this->isFavorite();
    }
    
    /* Methods for algorithm attach category to a publication */
    static public function lengthener($url)
    {
        $res = array();
        $options = array( 
            CURLOPT_RETURNTRANSFER => true,     // return web page 
            CURLOPT_HEADER         => true,    // do not return headers 
            CURLOPT_FOLLOWLOCATION => false,     // follow redirects 
            CURLOPT_USERAGENT      => "spider", // who am i 
            CURLOPT_AUTOREFERER    => true,     // set referer on redirect 
            CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect 
            CURLOPT_TIMEOUT        => 120,      // timeout on response 
            CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects 
        ); 
        $ch      = curl_init( $url ); 
        curl_setopt_array( $ch, $options ); 
        $content = curl_exec( $ch ); 
        $err     = curl_errno( $ch ); 
        $errmsg  = curl_error( $ch ); 
        $header  = curl_getinfo( $ch ); 
        curl_close( $ch );
        $headers = explode("\n", $content);
        foreach ($headers as $header) {
            if ('Location' === substr($header, 0, 8)) {
            $url = substr($header, 10);
            }
        }
    	return $url;
    }
    
    static public function urlImage($url)
    {
        $modele = '#image|photo|picture|img#';
        $test   = preg_match($modele, $url, $result);
        if ($test && $test>0 ){
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    static public function urlVideo($url)
    {
        $modele = '#video|watch|film|trailer#';
        $test   = preg_match($modele, $url, $result);
        
        if ($test && $test>0){
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    static public function urlMusic($url)
    {
        $modele = '#music|musique|audio|playlist|chanson|song|listen#';
        $test   = preg_match($modele, $url, $result);
        
        if ($test && $test>0){
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    static public function urlMap($url){
        $modele='#map|foursquare.com|loopt.com|4sq.com#';
        $test=preg_match($modele, $url, $result);
        
        if ($test && $test>0 ){
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    static public function testImage($url)
    {
        return false !== @exif_imagetype($url);
    }

    static public function compare($tab, $argument)
    {
        foreach($tab as $text){
            foreach($argument as $regex){
                $test = preg_match($regex, $text, $result);
                if ($test && $test>0){
                    return TRUE;
                } else {
                    return FALSE;
                }
            }
        }
    }
    
    static public function getHtmlContent($url)
    {
        try {
            return file_get_contents($url);
        } catch (\Exception $e) {
            var_dump($e);
            return false;
        }
    }

    static public function search_type($url)
    {
        $model     = '#<meta property="og:type" content="(.*)".*>#';
        $code_html = Publication::getHtmlContent($url);
        preg_match($model, $code_html, $type);
        return $type;
    }
    
    static public function search_keywords($url)
    {
        $model     = '#<meta.*name="keywords".*content="(.*?)".*>#';
        $code_html = Publication::getHtmlContent($url);
        preg_match($model, $code_html, $keywords);
        return $keywords;
    }
    
    static public function search_title($url)
    {
        $modele_title = '#<title.*?>(.*)</title>#is';
        $code_html    = Publication::getHtmlContent($url);
        preg_match($modele_title, $code_html, $title);
        return $title;
    }
    
    static public function search_h1($url)
    {
        $modele_title = '#<h1.*?>(.*?)</h1>#is';
        $code_html    = Publication::getHtmlContent($url);
        preg_match($modele_title, $code_html, $h1);
        return $h1;
    }
    
    static public function search_h2($url)
    {
        $modele_title = '#<h2.*?>(.*?)</h2>#is';
        $code_html    = Publication::getHtmlContent($url);
        preg_match($modele_title, $code_html, $h2);
        return $h2;
    }
    
    static public function search_description($url)
    {
        $model     = '#.*<meta name="description" content="(.*)".*>.*#';
        $code_html = Publication::getHtmlContent($url);
        echo $code_html;
        die;
        preg_match($model, $code_html, $description);
        return $description;
    }
}